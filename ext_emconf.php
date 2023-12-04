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
    'description' => 'Amazon CloudFront Integration for TYPO3 CMS',
    'category' => 'backend',
    'author' => 'Michael Schams',
    'author_company' => 'schams.net | t3rrific.com',
    'state' => 'beta',
    'version' => '2.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '12.0.0-12.99.99',
        ],
        'conflicts' => [
        ],
        'suggests' => [
        ]
    ]
];
