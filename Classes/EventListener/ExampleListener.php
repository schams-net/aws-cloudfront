<?php
declare(strict_types=1);
namespace Typo3OnAws\AwsCloudfront\EventListener;

/**
 * Amazon CloudFront Integration
 * @author Michael Schams | https://schams.net | https://t3rrific.com
 */

use Typo3OnAws\AwsCloudfront\EventDispatcher\CloudfrontInvalidationRequestEvent;

/**
 * Example on how to manipulate the paths BEFORE they are used in a CDN invalidation.
 * The code below adds the element '/manipulated' in front of every path.
 */
class ExampleListener
{
    /**
     * Method that is executed when the event is dispatched
     */
    public function __invoke(CloudfrontInvalidationRequestEvent $event): void
    {
        // Read the current paths list
        $paths = $event->getPaths();

        // Iterate the list and prepend '/manipulated' to every path
        foreach ($paths as $key => $path) {
            $paths[$key] = '/manipulated' . $path;
        }

        // Return the new paths to the dispatching class which then uses the new paths for the
        // invalidation request that gets submitted to CloudFront
        $event->setPaths($paths);
    }
}
