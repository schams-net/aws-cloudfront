<?php
declare(strict_types=1);

/**
 * Amazon CloudFront Integration for TYPO3 CMS
 * @author Michael Schams | https://schams.net | https://t3rrific.com
 *
 * See README.md and/or LICENSE.md for copyright and license information.
 */

$EM_CONF[$_EXTKEY] = [
    'title' => 'Amazon CloudFront',
    'description' => 'Amazon CloudFront integration',
    'category' => 'backend',
    'author' => 'Michael Schams',
    'state' => 'beta',
    'clearCacheOnLoad' => 0,
    'version' => '0.0.1',
    'constraints' => [
        'depends' => [
            'typo3' => '11.0.0-11.99.99',
        ],
        'conflicts' => [
        ],
        'suggests' => [
        ]
    ]
];
