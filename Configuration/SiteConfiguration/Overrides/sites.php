<?php

/**
 * Amazon CloudFront
 * @author Michael Schams | https://schams.net | https://t3rrific.com
 */

$languageFile = 'EXT:aws_cloudfront/Resources/Private/Language/siteconfiguration.xlf';

$GLOBALS['SiteConfiguration']['site']['columns']['cloudfrontActive'] = [
    'label' => 'LLL:' . $languageFile . ':cloudfrontActive.label',
    'description' => 'LLL:' . $languageFile . ':cloudfrontActive.description',
    'onChange' => 'reload',
    'config' => [
        'type' => 'check',
    ]
];
$GLOBALS['SiteConfiguration']['site']['columns']['cloudfrontDistributionId'] = [
    'label' => 'LLL:' . $languageFile . ':cloudfrontDistributionId.label',
    'description' => 'LLL:' . $languageFile . ':cloudfrontDistributionId.description',
    'displayCond' => 'FIELD:cloudfrontActive:=:1',
    'config'=> [
        'type' => 'input',
        'eval' => '',
    ],
];
$GLOBALS['SiteConfiguration']['site']['columns']['cloudfrontAccessKeyId'] = [
    'label' => 'LLL:' . $languageFile . ':cloudfrontAccessKeyId.label',
    'description' => 'LLL:' . $languageFile . ':cloudfrontAccessKeyId.description',
    'displayCond' => 'FIELD:cloudfrontActive:=:1',
    'config' => [
        'type' => 'input',
        'eval' => '',
    ],
];
$GLOBALS['SiteConfiguration']['site']['columns']['cloudfrontSecretAccessKeyId'] = [
    'label' => 'LLL:' . $languageFile . ':cloudfrontSecretAccessKeyId.label',
    'description' => 'LLL:' . $languageFile . ':cloudfrontSecretAccessKeyId.description',
    'displayCond' => 'FIELD:cloudfrontActive:=:1',
    'config' => [
        'type' => 'input',
        'eval' => '',
    ],
];

$GLOBALS['SiteConfiguration']['site']['palettes']['group1']['showitem'] = 'cloudfrontActive';
//$GLOBALS['SiteConfiguration']['site']['palettes']['group2']['showitem'] = 'cloudfrontDistributionId,--linebreak--,cloudfrontAccessKeyId,cloudfrontSecretAccessKeyId';
$GLOBALS['SiteConfiguration']['site']['palettes']['group2']['showitem'] = 'cloudfrontDistributionId,cloudfrontAccessKeyId,cloudfrontSecretAccessKeyId';

$tabLabel = 'LLL:' . $languageFile . ':cloudfront.tab.label';
$paletteGroup1Label = 'LLL:' . $languageFile . ':cloudfront.palette.group1.label';
$paletteGroup2Label = 'LLL:' . $languageFile . ':cloudfront.palette.group2.label';

$GLOBALS['SiteConfiguration']['site']['types']['0']['showitem'] .= ',' . implode(',', [
    '--div--;' . $tabLabel,
    '--palette--;' . $paletteGroup1Label . ';group1',
    '--palette--;' . $paletteGroup2Label . ';group2'
]);
