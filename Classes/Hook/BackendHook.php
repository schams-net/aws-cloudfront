<?php
declare(strict_types=1);
namespace Typo3OnAws\AwsCloudfront\Hook;

/**
 * Amazon CloudFront
 * @author Michael Schams | https://schams.net | https://t3rrific.com
 */

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Exception\SiteNotFoundException;
use TYPO3\CMS\Core\Site\Entity\Site;
//use TYPO3\CMS\Core\Site\Entity\SiteLanguage;
use TYPO3\CMS\Core\Site\SiteFinder;

/**
 * Class contains backend-related hooks.
 *
 * These hooks can be used to trigger an invalidation request, e.g. when a backend user
 * adds/updates/deletes content elements on a page, or edits page properties that require
 * a CDN cache clear.
 * 
 * >>> THIS IS WORK IN PROGRESS AND HAS NOT BEEN IMPLEMENTED YET! <<<
 * 
 */
class BackendHook implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * Hook is called BEFORE any cmd of the commandmap is executed
     *
     * @param DataHandler $dataHandler reference to the main DataHandler object
     */
    public function processCmdmap_beforeStart(DataHandler $dataHandler)
    {
    }

    /**
     * Hook is called when no prepared command was found
     *
     * @param string $command the command to be executed
     * @param string $table the table of the record
     * @param int $id the ID of the record
     * @param mixed $value the value containing the data
     * @param bool $commandIsProcessed can be set so that other hooks or
     * @param DataHandler $dataHandler reference to the main DataHandler object
     */
    public function processCmdmap($command, $table, $id, $value, &$commandIsProcessed, DataHandler $dataHandler)
    {
    }

    /**
     * Hook is called AFTER all commands of the commandmap are executed
     *
     * @param DataHandler $dataHandler reference to the main DataHandler object
     */
    public function processCmdmap_afterFinish(DataHandler $dataHandler)
    {
    }

    /**
     *
     */
    public function processDatamap_preProcessFieldArray(array $incomingFieldArray, string $table, $id, DataHandler $dataHandler): void
    {
        if ($table === 'tt_content') {
            // @TODO
        }

        if ($table === 'pages' && is_numeric($id) && $id > 0) {
            // getRecord($table, $uid, $fields = '*', $where = '', $useDeleteClause = true)
            $record = BackendUtility::getRecord($table, (int)$id, 'slug');

            $site = $this->getCurrentSite(intval($id));
            $siteConfiguration = $site->getConfiguration();
            $cloudfrontActive = (isset($siteConfiguration['cloudfrontActive']) ? $siteConfiguration['cloudfrontActive'] : null);
            $distributionId = (isset($siteConfiguration['cloudfrontDistributionId']) ? $siteConfiguration['cloudfrontDistributionId'] : null);
            // @TODO
        }
    }

    /**
     * Acts on potential slug changes.
     *
     * Hook `processDatamap_postProcessFieldArray` is executed after `DataHandler::fillInFields` which
     * ensure access to pages.slug field and applies possible evaluations (`eval => 'trim,...`).
     */
    public function processDatamap_postProcessFieldArray(string $status, string $table, $id, array $fieldArray, DataHandler $dataHandler): void
    {
    }

    /**
     *
     */
    protected function getCurrentSite(int $pageId): ?Site
    {
        $siteFinder = GeneralUtility::makeInstance(SiteFinder::class);
        try {
            return $siteFinder->getSiteByPageId($pageId);
        } catch (SiteNotFoundException $e) {
            return null;
        }
    }
}
