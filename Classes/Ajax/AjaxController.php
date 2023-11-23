<?php
declare(strict_types=1);
namespace Typo3OnAws\AwsCloudfront\Ajax;

/**
 * Amazon CloudFront Integration
 * @author Michael Schams | https://schams.net | https://t3rrific.com
 */

use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Typo3OnAws\AwsCloudfront\EventDispatcher\InvalidationRequestEvent;
use Typo3OnAws\AwsCloudfront\EventDispatcher\InvalidationResponseEvent;
use Typo3OnAws\AwsCloudfront\Service\AmazonWebServices\CloudFront;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Exception\SiteNotFoundException;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Site\Entity\Site;
use TYPO3\CMS\Core\Site\SiteFinder;

/**
 * Ajax Controller
 */
class AjaxController
{
    /**
     *
     */
    private EventDispatcherInterface $eventDispatcher;

    /**
     *
     */
    private Site $site;

    /**
     *
     */
    private array $jsonResponse = [];

    /**
     *
     */
    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Test
     */
    public function test(ServerRequestInterface $request): ResponseInterface
    {
        $this->setResponse(['method' => __METHOD__]);
        return new JsonResponse($this->jsonResponse);
    }

    /**
     * Page
     */
    public function page(ServerRequestInterface $request): ResponseInterface
    {
        $pageId = (int)($request->getParsedBody()['pageId'] ?? $request->getQueryParams()['pageId'] ?? 0);

        $this->site = $this->getCurrentSiteByPageId($pageId);
        $cloudfrontActive = $this->site->getConfiguration()['cloudfrontActive'];
        $distributionId = $this->site->getConfiguration()['cloudfrontDistributionId'];
        $siteIdentifier = $this->site->getIdentifier();
        $callerReference = md5(strval(time()));

        if ($cloudfrontActive == true && $this->validDistributionId($distributionId)) {
            // Get all page URI of the default language and all translations
            $paths = $this->getUriPaths($pageId);

            // Let other extensions manipulate the request, e.g. adjust the paths
            $eventBeforeRequest = new InvalidationRequestEvent($paths, $pageId, $siteIdentifier, $callerReference);
            $paths = $this->eventDispatcher->dispatch($eventBeforeRequest)->getPaths();

            // Initialization
            $this->setResponse([
                'success' => false,
                'method' => __METHOD__,
                'message' => 'Invalidation failed.'
            ]);

            // Trigger invalidation
            $result = $this->triggerInvalidation($paths);
            if (is_array($result) && array_key_exists('success', $result) && $result['success'] === true) {
                $this->setResponse(['success' => true]);
                $this->setResponse(['message' => 'Invalidation successfully triggered.']); // @TODO translate
                if (array_key_exists('invalidationId', $result)) {
                    $this->setResponse(['invalidationId' => $result['invalidationId']]);
                    $this->setResponse(['message' => 'Invalidation successfully triggered. ID: ' . $result['invalidationId']]); // @TODO translate
                }
                // invoke event after request
                $eventAfterRequest = new InvalidationResponseEvent($paths, $pageId, $siteIdentifier, $callerReference, $result['invalidationId']);
                $this->eventDispatcher->dispatch($eventAfterRequest);
            }
            if (array_key_exists('message', $result)) {
                $this->setResponse(['message' => $result['message']]);
            }
        } else {
            // CloudFront integration not enabled ot invalid distribution ID
            $this->setResponse(['message' => 'Invalid CloudFront integration configuration.']); // @TODO translate
        }

        return new JsonResponse($this->jsonResponse);
    }

    /**
     *
     */
    protected function getCurrentSiteByPageId(int $pageId): ?Site
    {
        $siteFinder = GeneralUtility::makeInstance(SiteFinder::class);
        try {
            return $siteFinder->getSiteByPageId($pageId);
        } catch (SiteNotFoundException $e) {
            return null;
        }
    }

    /**
     *
     */
    protected function getCurrentSiteBySiteIdentifier(string $identifier): ?Site
    {
        $siteFinder = GeneralUtility::makeInstance(SiteFinder::class);
        try {
            return $siteFinder->getSiteByIdentifier($identifier);
        } catch (SiteNotFoundException $e) {
            return null;
        }
    }

    /**
     *
     */
    protected function validDistributionId(?string $distributionId): bool
    {
        if (!is_string($distributionId)
         || !preg_match('/^E[A-Z0-9]{8,32}$/', $distributionId)
        ) {
            return false;
        }
        return true;
    }

    /**
     *
     */
    protected function getUriPaths(int $pageId): array
    {
        $uriPaths = [];

        $allLanguages = $this->site->getLanguages();
        foreach ($allLanguages as $language) {
            $languageId = intval($language->getLanguageId());

            if ($languageId === 0) {
                // get page record
                $record = BackendUtility::getRecord('pages', $pageId, 'slug');
            } else {
                // get localized page record
                $record = BackendUtility::getRecordLocalization('pages', $pageId, $languageId);
                if (is_array($record) && count($record) > 0) {
                    $record = $record[0];
                } else {
                    // No translation for this language exists
                    unset($record);
                }
            }

            if (isset($record)) {
                $uriPaths[] = preg_replace('/\/{2,}/', '/', $language->getBase()->getPath() . $record['slug']);
            }
            unset($record);
        }
        return $uriPaths;
    }

    /**
     *
     */
    protected function triggerInvalidation(array $paths): ?array
    {
        // ...
        $cloudfront = GeneralUtility::makeInstance(CloudFront::class);

        // ...
        $accessKeyId = $this->site->getConfiguration()['cloudfrontAccessKeyId'] ?: null;
        $secretAccessKeyId = $this->site->getConfiguration()['cloudfrontSecretAccessKeyId'] ?: null;
        if ($accessKeyId && $secretAccessKeyId) {
            $cloudfront->setCredentials([
                'key' => $accessKeyId,
                'secret' => $secretAccessKeyId
            ]);
        }

        $distributionId = $this->site->getConfiguration()['cloudfrontDistributionId'];
        return $cloudfront->createInvalidation($distributionId, $paths);
    }

    /**
     *
     */
    protected function listInvalidations(string $distributionId): ?array
    {
        $cloudfront = GeneralUtility::makeInstance(CloudFront::class);

        // ...
        $accessKeyId = $this->site->getConfiguration()['cloudfrontAccessKeyId'] ?: null;
        $secretAccessKeyId = $this->site->getConfiguration()['cloudfrontSecretAccessKeyId'] ?: null;
        if ($accessKeyId && $secretAccessKeyId) {
            $cloudfront->setCredentials([
                'key' => $accessKeyId,
                'secret' => $secretAccessKeyId
            ]);
        }

        return $cloudfront->listInvalidations($distributionId);
    }

    /**
     *
     */
    private function setResponse(array $elements): void
    {
        $this->jsonResponse = array_merge($this->jsonResponse, $elements);
    }
}
