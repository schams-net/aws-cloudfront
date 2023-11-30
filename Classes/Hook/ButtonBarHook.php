<?php
declare(strict_types=1);
namespace T3rrific\AwsCloudfront\Hook;

/**
 * Amazon CloudFront Integration for TYPO3 CMS
 * @author Michael Schams | https://schams.net | https://t3rrific.com
 *
 * See README.md and/or LICENSE.md for copyright and license information.
 */

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\Template\Components\ButtonBar;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use T3rrific\AwsCloudfront\Utility\SiteUtility;

/**
 * Hook to manipulate the button bar in page module
 */
class ButtonBarHook
{
    public PageRenderer $pageRenderer;

    /**
     * List of backend modules that should show the button
     */
    private const ALLOWED_MODULES = ['web_layout', 'web_list'];

    /**
     * Constructor
     */
    public function __construct(
        PageRenderer $pageRenderer
    ) {
        $this->pageRenderer = $pageRenderer;
    }

    /**
     * Add button to let backend users flush the CDN cache on a page-by-page basis
     *
     * @param array $params
     * @param ButtonBar $buttonBar
     */
    public function getButtons(array $params, ButtonBar $buttonBar): array
    {
        // JavaScript module has a click() listener on $('a.btn.flush-cloudfront-cache')
        $this->pageRenderer->loadRequireJsModule('TYPO3/CMS/AwsCloudfront/Module');

        $buttons = $params['buttons'];
        $request = $this->getRequest();
        $pageId = (int)($request->getParsedBody()['id'] ?? $request->getQueryParams()['id'] ?? 0);
        $route = $request->getAttribute('route');
        $normalizedParams = $request->getAttribute('normalizedParams');

        // Only add button if page is part of a site that has a CloudFront configuration
        $site = SiteUtility::isCloudfrontActive($pageId);

        if (!$pageId
            || $route === null
            || $normalizedParams === null
            || !$site
            || !in_array($route->getOption('moduleName'), self::ALLOWED_MODULES, true)
        ) {
            return $buttons;
        }

        // Generate the button with icon, CSS class, etc.
        $iconFactory = GeneralUtility::makeInstance(IconFactory::class);
        $button = $buttonBar->makeLinkButton();
        $button->setHref('#');
        $button->setDataAttributes(['pageId' => $pageId]);
        $button->setClasses('flush-cloudfront-cache');
        //$button->setIcon($this->iconFactory->getIcon('actions-system-cache-clear', Icon::SIZE_SMALL));
        $button->setIcon($iconFactory->getIcon('button-bar-cloudfront', Icon::SIZE_SMALL));
        $button->setTitle('Flush CloudFront cache (CDN)'); // @TODO translate

        //$buttonBar->addButton($button, ButtonBar::BUTTON_POSITION_RIGHT, 1);
        $buttons[ButtonBar::BUTTON_POSITION_RIGHT][1][] = $button;

        return $buttons;
    }

    /**
     *
     */
    protected function getRequest(): ServerRequestInterface
    {
        return $GLOBALS['TYPO3_REQUEST'];
    }
}
