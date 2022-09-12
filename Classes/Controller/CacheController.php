<?php
declare(strict_types=1);
namespace Typo3OnAws\AwsCloudfront\Controller;

/**
 * Amazon CloudFront Integration
 * @author Michael Schams | https://schams.net | https://t3rrific.com
 */

use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Backend\Toolbar\ClearCacheActionsHookInterface;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Http\Response;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class to handle flushing all caches
 */
class CacheController implements ClearCacheActionsHookInterface
{
    /**
     * Modifies CacheMenuItems array and adds a "Flush CloudFront caches (CDN)"
     *
     * @param array $cacheActions Array of CacheMenuItems
     * @param array $optionValues Array of AccessConfigurations-identifiers (typically used by userTS with options.clearCache.identifier)
     */
    public function manipulateCacheActions(&$cacheActions, &$optionValues)
    {
        // @TODO only add menu item if only ONE CloudFront distribution is enabled/configured in ALL sites (SiteFinder)
        // It does not make sense to offer the menu item if no sites have been configured to use CDN distributions.
        // It does not make sense to offer the menu item if more than one site has been configured to use CDN distributions.
        //
        // or: consider to take extension configuration into account

        if ($this->getBackendUser()->isAdmin()) {
            $uriBuilder = GeneralUtility::makeInstance(UriBuilder::class);
            $item = [
                'id' => 'CloudFrontFlushAll',
                'title' => 'LLL:EXT:aws_cloudfront/Resources/Private/Language/locallang.xlf:menuitem.title',
                'description' => 'LLL:EXT:aws_cloudfront/Resources/Private/Language/locallang.xlf:menuitem.description',
                'href' => $uriBuilder->buildUriFromRoute('ajax_cloudfront', ['foo' => 'bar']),
                'iconIdentifier' => 'toolbar-cloudfront'
            ];

            // @TODO add menu item to the cache menu once functionality has been developed and fully tested
            // (currently disabled as the line below is commented out)
            //array_push($cacheActions, $item);

        } else {
            // Backend user is not an admin
        }
    }

    /**
     * AJAX endpoint when triggering the call from the cache menu
     */
    public function flushAction(): Response
    {
        // @TODO implement invalidation request, see Typo3OnAws\AwsCloudfront\Service\AmazonWebServices\createInvalidation()

        // we cannot add our own message unfortunately
        $response = new Response();
        // $response->getBody()->write(json_encode($content));
        return $response;
    }

    /**
     *
     */
    protected function getBackendUser(): BackendUserAuthentication
    {
        return $GLOBALS['BE_USER'];
    }

    /**
     *
     */
    protected function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }
}
