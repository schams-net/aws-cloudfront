<?php

/**
 * Amazon CloudFront
 * @author Michael Schams | https://schams.net | https://t3rrific.com
 */

$languageFile = 'EXT:aws_cloudfront/Resources/Private/Language/siteconfiguration.xlf';

$newColumns = [
    'cloudfrontActive' => [
        'label' => 'LLL:' . $languageFile . ':cloudfrontActive.label',
        'description' => 'LLL:' . $languageFile . ':cloudfrontActive.description',
        'onChange' => 'reload',
        'config' => [
            'type' => 'check',
        ],
    ],
    'cloudfrontDistributionId' => [
        'label' => 'LLL:' . $languageFile . ':cloudfrontDistributionId.label',
        'description' => 'LLL:' . $languageFile . ':cloudfrontDistributionId.description',
        'displayCond' => 'FIELD:cloudfrontActive:=:1',
        'config' => [
            'type' => 'input',
            'eval' => '',
        ],
    ],
    'cloudfrontAccessKeyId' => [
        'label' => 'LLL:' . $languageFile . ':cloudfrontAccessKeyId.label',
        'description' => 'LLL:' . $languageFile . ':cloudfrontAccessKeyId.description',
        'displayCond' => 'FIELD:cloudfrontActive:=:1',
        'config' => [
            'type' => 'input',
            'eval' => '',
        ],
    ],
    'cloudfrontSecretAccessKeyId' => [
        'label' => 'LLL:' . $languageFile . ':cloudfrontSecretAccessKeyId.label',
        'description' => 'LLL:' . $languageFile . ':cloudfrontSecretAccessKeyId.description',
        'displayCond' => 'FIELD:cloudfrontActive:=:1',
        'config' => [
            'type' => 'input',
            'eval' => '',
        ],
    ]
];

$GLOBALS['SiteConfiguration']['site']['columns'] = array_merge_recursive(
    $GLOBALS['SiteConfiguration']['site']['columns'],
    $newColumns
);

$tabLabel = 'LLL:' . $languageFile . ':cloudfront.tab';

//$GLOBALS['SiteConfiguration']['site']['types']['0']['showitem'] .= ',--div--;Maintenance,cloudfrontActive,cloudfrontDistributionId,cloudfrontAccessKeyId,cloudfrontSecretAccessKeyId';
$GLOBALS['SiteConfiguration']['site']['types']['0']['showitem'] .= ',--div--;' . $tabLabel . ',' . implode(',', array_keys($newColumns));
