<?php
declare(strict_types=1);
namespace T3rrific\AwsCloudfront\Provider;

/**
 * Amazon CloudFront Integration for TYPO3 CMS
 * @author Michael Schams | https://schams.net | https://t3rrific.com
 *
 * See README.md and/or LICENSE.md for copyright and license information.
 */

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\Routing\Exception\RouteNotFoundException;
use TYPO3\CMS\Backend\Template\Components\ButtonBar;
use TYPO3\CMS\Backend\Template\Components\ModifyButtonBarEvent;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Page\PageRenderer;
use T3rrific\AwsCloudfront\Utility\SiteUtility;

/**
 * Event listener to add the sys_note button to the button bar
 */
final class ButtonBarProvider
{
    private const ALLOWED_MODULES = [
        '/module/web/layout',
        '/module/web/list'
    ];

    /**
     * Add a sys_note creation button to the button bar of defined modules
     *
     * @throws RouteNotFoundException
     */
    public function __invoke(ModifyButtonBarEvent $event): void
    {
        $buttons = $event->getButtons();
        $request = $this->getRequest();

        $pageId = (int)($request->getParsedBody()['id'] ?? $request->getQueryParams()['id'] ?? 0);
        $route = $request->getAttribute('route');
        $normalizedParams = $request->getAttribute('normalizedParams');

        // Only add button if page is part of a site that has a CloudFront configuration
        $isCloudfrontActive = SiteUtility::isCloudfrontActive($pageId);

        if ($pageId > 0
         && $route !== null
         && $normalizedParams !== null
         && $isCloudfrontActive === true
         && in_array($route->getPath(), self::ALLOWED_MODULES)) {

            // Load JavaScript for the backend
            $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
            $pageRenderer->loadJavaScriptModule(
                '@t3rrific/aws-cloudfront/CloudFront.js'
            );

            // Generate the button with icon, CSS class, etc.
            $iconFactory = GeneralUtility::makeInstance(IconFactory::class);
            $button = $event->getButtonBar()
                ->makeLinkButton()
                ->setDataAttributes(['pageId' => $pageId])
                ->setClasses('flush-cloudfront-cache')
                //->setIcon($iconFactory->getIcon('actions-system-cache-clear', Icon::SIZE_SMALL))
                ->setIcon($iconFactory->getIcon('button-bar-cloudfront', Icon::SIZE_SMALL))
                ->setTitle('Flush CloudFront cache (CDN)') // @TODO translate
                ->setHref('#');

            //$buttonBar->addButton($button, ButtonBar::BUTTON_POSITION_RIGHT, 1);
            $buttons[ButtonBar::BUTTON_POSITION_RIGHT][1][] = $button;

            $event->setButtons($buttons);
        }
    }

    protected function getRequest(): ServerRequestInterface
    {
        return $GLOBALS['TYPO3_REQUEST'];
    }

    protected function getBackendUserAuthentication(): BackendUserAuthentication
    {
        return $GLOBALS['BE_USER'];
    }

    protected function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }
}
