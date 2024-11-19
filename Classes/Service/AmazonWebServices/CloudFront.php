<?php
declare(strict_types=1);
namespace T3rrific\AwsCloudfront\Service\AmazonWebServices;

/**
 * Amazon CloudFront Integration for TYPO3 CMS
 * @author Michael Schams | https://schams.net | https://t3rrific.com
 *
 * See README.md and/or LICENSE.txt for copyright and license information.
 */

use Aws\CloudFront\CloudFrontClient;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use T3rrific\AwsCloudfront\Utility\AwsExceptionHandler;

/**
 *
 */
class CloudFront extends Authentication
{
    /**
     *
     */
    public function __construct()
    {
        $this->configuration = [
            'version' => 'latest',
            'region' => 'us-east-1'
        ];
    }

    /**
     *
     */
    public function createInvalidation(string $distributionId, array $paths, ?string $callerReference = null): ?array
    {
        $cloudFrontClient = new CloudFrontClient($this->getConfiguration());

        try {
            $result = $cloudFrontClient->createInvalidation([
                'DistributionId' => $distributionId,
                'InvalidationBatch' => [
                    'CallerReference' => ($callerReference ?? bin2hex(random_bytes(20))),
                    'Paths' => [
                        'Items' => $paths,
                        'Quantity' => count($paths)
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            $exceptionHandler = GeneralUtility::makeInstance(AwsExceptionHandler::class);
            return $exceptionHandler->getResponse($e);
        }

        if (isset($result)) {
            return [
                'success' => true,
                'invalidationId' => $result->search('Invalidation.Id')
            ];
        }
        // Invalidation request failed
        return null;
    }

    /**
     *
     */
    public function listInvalidations(string $distributionId): ?array
    {
        $cloudFrontClient = new CloudFrontClient($this->getConfiguration());

        try {
            $result = $cloudFrontClient->listInvalidations([
                'DistributionId' => $distributionId,
                'MaxItems' => '10'
            ]);
        } catch (\Exception $e) {
            $exceptionHandler = GeneralUtility::makeInstance(AwsExceptionHandler::class);
            return $exceptionHandler->getResponse($e);
        }

        if (isset($result)) {
/*
            'InvalidationList' => [
                'IsTruncated' => true || false,
                'Items' => [
                    [
                        'CreateTime' => <DateTime>,
                        'Id' => '<string>',
                        'Status' => '<string>',
                    ],
                    // ...
                ],
                'Marker' => '<string>',
                'MaxItems' => <integer>,
                'NextMarker' => '<string>',
                'Quantity' => <integer>,
            ]
*/
            return [
                'success' => true,
                'invalidationId' => $result->search('InvalidationList.Items')
            ];
        }
        // Invalidation request failed
        return null;
    }
}
