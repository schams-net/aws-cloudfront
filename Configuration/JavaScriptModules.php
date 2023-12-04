<?php

/**
 * Amazon CloudFront Integration for TYPO3 CMS
 * @author Michael Schams | https://schams.net | https://t3rrific.com
 *
 * See README.md and/or LICENSE.md for copyright and license information.
 */

 return [
    'dependencies' => [
        'core',
        'backend'
    ],
    'imports' => [
        '@t3rrific/aws-cloudfront/' => 'EXT:aws_cloudfront/Resources/Public/JavaScript/'
    ]
];
