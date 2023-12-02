<?php
declare(strict_types=1);
namespace T3rrific\AwsCloudfront\Configuration;

/**
 * Amazon CloudFront Integration for TYPO3 CMS
 * @author Michael Schams | https://schams.net | https://t3rrific.com
 * Based on EXT:typo3_warming by Elias Häußler <elias@haeussler.dev> | https://github.com/eliashaeussler/typo3-warming
 *
 * See README.md and/or LICENSE.md for copyright and license information.
 */

use T3rrific\AwsCloudfront\Hook\BackendHook;
use T3rrific\AwsCloudfront\Hook\ButtonBarHook;
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
     * Register an additional button in backend modules such as "Page" or "List"
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
        // Add all stylesheets from folder
        $GLOBALS['TYPO3_CONF_VARS']['BE']['stylesheets'][self::KEY] =
            'EXT:' . self::KEY . '/Resources/Public/Css/Backend/';
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
