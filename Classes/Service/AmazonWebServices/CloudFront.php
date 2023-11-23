<?php
declare(strict_types=1);
namespace Typo3OnAws\AwsCloudfront\Service\AmazonWebServices;

/**
 * Amazon CloudFront Integration
 * @author Michael Schams | https://schams.net | https://t3rrific.com
 */

use Aws\CloudFront\CloudFrontClient;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Typo3OnAws\AwsCloudfront\Utility\AwsExceptionHandler;

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
    public function createInvalidation(string $distributionId, array $paths): ?array
    {
        $callerReference = bin2hex(random_bytes(20));
        $cloudFrontClient = new CloudFrontClient($this->getConfiguration());

        try {
            $result = $cloudFrontClient->createInvalidation([
                'DistributionId' => $distributionId,
                'InvalidationBatch' => [
                    'CallerReference' => $callerReference,
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
            return AwsExceptionHandler::getResponse($e);
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
