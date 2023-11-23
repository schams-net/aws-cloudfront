<?php
declare(strict_types=1);
namespace Typo3OnAws\AwsCloudfront\EventDispatcher;

/**
 * Amazon CloudFront Integration
 * @author Michael Schams | https://schams.net | https://t3rrific.com
 */

final class InvalidationRequestEvent
{
    /**
     * Paths
     */
    private array $paths;

    /**
     * Page ID
     */
    private ?int $pageId;

    /**
     * Site identifier (string)
     */
    private ?string $siteIdentifier;

    /**
     * Caller reference (string)
     */
    private ?string $callerReference;

    /**
     * Constructor
     */
    public function __construct(array $paths, ?int $pageId, ?string $siteIdentifier, ?string $callerReference)
    {
        $this->paths = $paths;
        $this->pageId = $pageId;
        $this->siteIdentifier = $siteIdentifier;
        $this->callerReference = $callerReference;
    }

    /**
     * Get paths
     */
    public function getPaths(): array
    {
        return $this->paths;
    }

    /**
     * Set paths
     */
    public function setPaths(array $paths): void
    {
        $this->paths = $paths;
    }

    /**
     * Get page ID
     */
    public function getPageId(): ?int
    {
        return $this->pageId;
    }

    /**
     * Get site identifier
     */
    public function getSiteIdentifier(): ?string
    {
        return $this->siteIdentifier;
    }

    /**
     * Get caller reference
     */
    public function getCallerReference(): ?string
    {
        return $this->callerReference;
    }
}
