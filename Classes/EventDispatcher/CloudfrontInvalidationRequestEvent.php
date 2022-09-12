<?php
declare(strict_types=1);
namespace Typo3OnAws\AwsCloudfront\EventDispatcher;

/**
 * Amazon CloudFront Integration
 * @author Michael Schams | https://schams.net | https://t3rrific.com
 */

final class CloudfrontInvalidationRequestEvent
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
     * Constructor
     */
    public function __construct(array $paths, ?int $pageId)
    {
        $this->paths = $paths;
        $this->pageId = $pageId;
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
}
