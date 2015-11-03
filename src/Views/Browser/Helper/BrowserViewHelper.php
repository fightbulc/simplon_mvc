<?php

namespace Simplon\Mvc\Views\Browser\Helper;

use Simplon\Phtml\Phtml;
use Simplon\Phtml\PhtmlException;

/**
 * Class BrowserViewHelper
 * @package Simplon\Mvc\Views\Browser\Helper
 */
class BrowserViewHelper
{
    const TABS_PATH_TEMPLATE = __DIR__ . '/../Partials/TabsPartialTemplate';

    /**
     * @param TabsView $tabsView
     * @param string $pathTemplate
     *
     * @return string
     * @throws PhtmlException
     */
    public static function renderTabs(TabsView $tabsView, $pathTemplate = self::TABS_PATH_TEMPLATE)
    {
        $data = [
            'activeTabId' => $tabsView->getActiveTabId(),
            'content'     => $tabsView->getContent(),
            'tabs'        => $tabsView->getTabs(),
        ];

        return (new Phtml())->render($pathTemplate, $data);
    }
}