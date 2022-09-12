<?php
declare(strict_types=1);
namespace Typo3OnAws\AwsCloudfront\Configuration;

/**
 * Amazon CloudFront
 * @author Michael Schams | https://schams.net | https://t3rrific.com
 * Based on EXT:typo3_warming by Elias Häußler <elias@haeussler.dev> | https://github.com/eliashaeussler/typo3-warming
 */

use Typo3OnAws\AwsCloudfront\Controller\CacheController;
use Typo3OnAws\AwsCloudfront\Hook\BackendHook;
use Typo3OnAws\AwsCloudfront\Hook\ButtonBarHook;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Extension
 */
final class Extension
{
    /**
     * Extension
     */
    private const KEY = 'aws_cloudfront';

    /**
     * Register backend hooks
     * ext_localconf.php
     */
    public static function registerBackendHooks(): void
    {
        $lib = 't3lib/class.t3lib_tcemain.php';
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][$lib]['processCmdmapClass'][self::KEY] =
            BackendHook::class;
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][$lib]['processDatamapClass'][self::KEY] =
            BackendHook::class;
    }

    /**
     * Register clear cache action as additional backend items (top bar in the backend)
     * ext_localconf.php
     */
    public static function registerToolbarCacheActions(): void
    {
        $lib = 'additionalBackendItems';
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][$lib]['cacheActions'][self::KEY] =
            CacheController::class;
    }

    /**
     * Register clear cache action as additional backend items (top bar in the backend)
     * ext_localconf.php
     */
    public static function registerButtonBarCacheActions(): void
    {
        $lib = 'Backend\Template\Components\ButtonBar';
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][$lib]['getButtonsHook'][self::KEY] =
            ButtonBarHook::class . '->getButtons';
    }

    /**
     * Register custom styles for the TYPO3 backend
     * ext_tables.php
     */
    public static function registerCustomStyles(): void
    {
        $GLOBALS['TBE_STYLES']['skins'][self::KEY] = [
            'name' => 'aws_cloudfront',
            'stylesheetDirectories' => [
                'css' => 'EXT:aws_cloudfront/Resources/Public/Css/Backend',
            ],
        ];
    }

    /**
     * Load additional libraries provided by PHAR file (only to be used in non-Composer-mode).
     * @TODO do not ship the aws.phar file with the extension but let the user configure the path to the file.
     */
    public static function loadVendorLibraries(): void
    {
        // Vendor libraries are already available in Composer mode
        if (Environment::isComposerMode()) {
            return;
        }
        $vendorPharFile = GeneralUtility::getFileAbsFileName('EXT:aws_cloudfront/Resources/Private/Libs/aws.phar');
        if (file_exists($vendorPharFile)) {
            require 'phar://' . $vendorPharFile . '/vendor/autoload.php';
        }
    }
}
