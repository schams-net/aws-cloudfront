<?php
declare(strict_types=1);
namespace Typo3OnAws\AwsCloudfront\Service\AmazonWebServices;

/**
 * Amazon CloudFront Integration
 * @author Michael Schams | https://schams.net | https://t3rrific.com
 */

use Aws\CloudFront\CloudFrontClient;
use Aws\Exception\AwsException;
use TYPO3\CMS\Core\Utility\GeneralUtility;

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
        } catch (AwsException $e) {
            // @TODO write error message to system log and output a general error here
            // Error: $e->getAwsErrorMessage()
            return [
                'success' => false,
                'message' => $e->getAwsErrorMessage()
            ];
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
        } catch (AwsException $e) {
            // @TODO write error message to system log and output a general error here
            // Error: $e->getAwsErrorMessage()
            return [
                'success' => false,
                'message' => $e->getAwsErrorMessage()
            ];
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
