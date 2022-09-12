<?php
declare(strict_types=1);

/**
 * Amazon CloudFront
 * @author Michael Schams | https://schams.net | https://t3rrific.com
 */

$languageFile = 'aws_cloudfront/Resources/Private/Language/locallang_db.xlf';

return [
    'ctrl' => [
        'title' => 'LLL:EXT:' . $languageFile . ':tx_awscloudfront_domain_model_invalidation',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'searchFields' => 'method,paths',
        'iconfile' => 'EXT:aws_cloudfront/Resources/Public/Icons/file-text.svg',
    ],
    'interface' => [
        'showRecordFieldList' => 'hidden, method, paths',
    ],
    'types' => [
        '1' => ['showitem' => 'hidden, method, paths, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access'],
    ],
    'columns' => [
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.visible',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        0 => '',
                        1 => '',
                        'invertStateDisplay' => true
                    ]
                ],
            ],
        ],
        'crdate' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.crdate',
            'config' => [
                'type' => 'input'
            ],
        ],

        'method' => [
            'exclude' => false,
            'label' => 'LLL:EXT:' . $languageFile . ':tx_awscloudfront_domain_model_invalidation.method',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
        ],
        'paths' => [
            'exclude' => false,
            'label' => 'LLL:EXT:' . $languageFile . ':tx_awscloudfront_domain_model_invalidation.paths',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
        ],

    ],
];
