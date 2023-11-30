<?php
declare(strict_types=1);

/**
 * Amazon CloudFront Integration
 * @author Michael Schams | https://schams.net | https://t3rrific.com
 */

use T3rrific\AwsCloudfront\Configuration\Extension;

defined('TYPO3') or die();

(function () {
    // Register custom styles: Resources/Public/Css/Backend/*
    Extension::registerCustomStyles();
})();
