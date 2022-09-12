<?php

/**
 * Amazon CloudFront
 * @author Michael Schams | https://schams.net | https://t3rrific.com
 */

return [
    // ...
    'cloudfront_test' => [
        'path' => '/cloudfront/test',
        'target' => \Typo3OnAws\AwsCloudfront\Ajax\AjaxController::class . '::test'
    ],
    // Flush specific URI, triggered from the page or list module
    // see Typo3OnAws\AwsCloudfront\Hook\ButtonBarHook
    'cloudfront_clear_page_cache' => [
        'path' => '/cloudfront/page',
        'target' => \Typo3OnAws\AwsCloudfront\Ajax\AjaxController::class . '::page'
    ],
    // Flush cache, triggered from top bar (clear caches menu)
    // see Typo3OnAws\AwsCloudfront\Controller\CacheController
    'cloudfront' => [
        'path' => '/cloudfront/flush',
        'target' => \Typo3OnAws\AwsCloudfront\Controller\CacheController::class . '::flushAction'
    ],
];
