<?php
declare(strict_types=1);

/**
 * Amazon CloudFront Integration for TYPO3 CMS
 * @author Michael Schams | https://schams.net | https://t3rrific.com
 *
 * See README.md and/or LICENSE.txt for copyright and license information.
 */

use T3rrific\AwsCloudfront\Configuration\Extension;

defined('TYPO3') or die();

(function () {
    // Register custom styles: Resources/Public/Css/Backend/*
    Extension::registerCustomStyles();
})();
