<?php
declare(strict_types=1);
namespace T3rrific\AwsCloudfront\Utility;

/**
 * Amazon CloudFront Integration for TYPO3 CMS
 * @author Michael Schams | https://schams.net | https://t3rrific.com
 *
 * See README.md and/or LICENSE.txt for copyright and license information.
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

		$configuration = $site->getConfiguration();
		if (!isset($configuration['cloudfrontActive']) || !isset($configuration['cloudfrontDistributionId'])) {
			return false;
		}

        if (!is_string($configuration['cloudfrontDistributionId']) || !preg_match('/^E[A-Z0-9]{8,32}$/', $configuration['cloudfrontDistributionId'])) {
            unset($configuration['cloudfrontDistributionId']);
        }

        if ($configuration['cloudfrontActive'] == true && isset($configuration['cloudfrontDistributionId'])) {
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
