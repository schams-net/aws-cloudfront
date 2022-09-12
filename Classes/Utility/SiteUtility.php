<?php
declare(strict_types=1);
namespace Typo3OnAws\AwsCloudfront\Utility;

/**
 * Amazon CloudFront Integration
 * @author Michael Schams | https://schams.net | https://t3rrific.com
 */

use TYPO3\CMS\Core\Exception\SiteNotFoundException;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Site\Entity\Site;
use TYPO3\CMS\Core\Site\SiteFinder;

/**
 * Site Utility
 */
class SiteUtility
{
    /**
     *
     */
    public static function isCloudfrontActive(int $pageId): bool
    {
        $site = self::getCurrentSite($pageId);
        if (!$site) {
            return false;
        }
        $cloudfrontActive = $site->getConfiguration()['cloudfrontActive'];
        $distributionId = $site->getConfiguration()['cloudfrontDistributionId'];

        if (!is_string($distributionId) || !preg_match('/^E[A-Z0-9]{8,32}$/', $distributionId)) {
            unset($distributionId);
        }

        if ($cloudfrontActive == true && isset($distributionId)) {
            return true;
        }
        return false;
    }

    /**
     *
     */
    public static function getCurrentSite(int $pageId): ?Site
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
    public static function getAllSites(): ?array
    {
        $siteFinder = GeneralUtility::makeInstance(SiteFinder::class);
        try {
            return $siteFinder->getAllSites();
        } catch (SiteNotFoundException $e) {
            return null;
        }
    }
}
