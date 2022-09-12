<?php
declare(strict_types=1);

/**
 * Amazon CloudFront Integration
 * @author Michael Schams | https://schams.net | https://t3rrific.com
 */

use Typo3OnAws\AwsCloudfront\Configuration\Extension;

defined('TYPO3') or die();

(function () {
    Extension::registerBackendHooks();
    Extension::registerToolbarCacheActions();
    Extension::registerButtonBarCacheActions();
})();
