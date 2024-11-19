<?php

/**
 * Amazon CloudFront Integration for TYPO3 CMS
 * @author Michael Schams | https://schams.net | https://t3rrific.com
 *
 * See README.md and/or LICENSE.txt for copyright and license information.
 */

return [
    // ...
    'cloudfront_test' => [
        'path' => '/cloudfront/test',
        'target' => \T3rrific\AwsCloudfront\Ajax\AjaxController::class . '::test'
    ],
    // Flush specific URI, triggered from the page or list module
    // see T3rrific\AwsCloudfront\Hook\ButtonBarHook
    'cloudfront_clear_page_cache' => [
        'path' => '/cloudfront/page',
        'target' => \T3rrific\AwsCloudfront\Ajax\AjaxController::class . '::page'
    ]
];
