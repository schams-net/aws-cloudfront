<?php
declare(strict_types=1);
namespace Typo3OnAws\AwsCloudfront\EventListener;

/**
 * Amazon CloudFront Integration
 * @author Michael Schams | https://schams.net | https://t3rrific.com
 */

use Typo3OnAws\AwsCloudfront\EventDispatcher\CloudfrontInvalidationRequestEvent;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;

/**
 * Write event details into the database
 */
class DatabaseListener
{
    /**
     * Method that is executed when the event is dispatched
     */
    public function __invoke(CloudfrontInvalidationRequestEvent $event): void
    {
        // Write the invalidation request into the database
        $this->insert($event->getPageId(), implode(',', $event->getPaths()));
    }

    /**
     * Write the data (page ID and comma-separated list of paths) in the database
     */
    protected function insert(int $pageId = 0, string $paths = ''): void
    {
        $data = [
            'pid' => $pageId,
            'tstamp' => time(),
            'crdate' => time(),
            'cruser_id' => intval($GLOBALS['BE_USER']->user['uid']),
            'method' => __METHOD__,
            'paths' => $paths
        ];

        $table = 'tx_awscloudfront_domain_model_invalidation';
        $database = GeneralUtility::makeInstance(ConnectionPool::class);
        $database->getConnectionForTable($table)->insert($table, $data);
    }
}
