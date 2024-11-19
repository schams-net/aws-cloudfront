<?php

/**
 * Amazon CloudFront Integration for TYPO3 CMS
 * @author Michael Schams | https://schams.net | https://t3rrific.com
 *
 * See README.md and/or LICENSE.txt for copyright and license information.
 */

return [
   'module-cloudfront' => [
       'provider' => \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
       'source' => 'EXT:aws_cloudfront/Resources/Public/Icons/Extension.svg'
   ],
   'button-bar-cloudfront' => [
       'provider' => \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
       'source' => 'EXT:aws_cloudfront/Resources/Public/Icons/button-bar.svg'
   ]
];
