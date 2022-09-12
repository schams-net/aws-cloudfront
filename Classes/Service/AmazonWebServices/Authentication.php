<?php
declare(strict_types=1);
namespace Typo3OnAws\AwsCloudfront\Service\AmazonWebServices;

/**
 * Amazon CloudFront Integration
 * @author Michael Schams | https://schams.net | https://t3rrific.com
 */

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 *
 */
class Authentication
{
    /**
     *
     */
    protected array $configuration;

    /**
     *
     */
    protected array $credentials;

    /**
     *
     */
    public function setCredentials(array $credentials): void
    {
        $this->configuration['credentials'] = $credentials;
    }

    /**
     *
     */
    public function getConfiguration(): array
    {
        return $this->configuration;
    }
}
