<?php
declare(strict_types=1);
namespace T3rrific\AwsCloudfront\EventDispatcher;

/**
 * Amazon CloudFront Integration
 * @author Michael Schams | https://schams.net | https://t3rrific.com
 */

final class InvalidationResponseEvent
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
     * Invalidation ID (string)
     */
    private ?string $invalidationId;

    /**
     * Constructor
     */
    public function __construct(array $paths, ?int $pageId, ?string $siteIdentifier, ?string $callerReference, ?string $invalidationId)
    {
        $this->paths = $paths;
        $this->pageId = $pageId;
        $this->siteIdentifier = $siteIdentifier;
        $this->callerReference = $callerReference;
        $this->invalidationId = $invalidationId;
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

    /**
     * Get invalidation ID
     */
    public function getInvalidationId(): ?string
    {
        return $this->invalidationId;
    }
}
