<?php

namespace Simplon\Mvc\Views\Browser\Pages;

use Simplon\Mvc\Views\Browser\Assets;
use Simplon\Mvc\Views\Browser\BrowserView;
use Simplon\Mvc\Views\Browser\Helper\PageBrowserViewHelper;

/**
 * Class CorePageBrowserView
 * @package Simplon\Mvc\Views\Browser\Core
 */
abstract class CorePageBrowserView extends BrowserView
{
    /**
     * @param PageBrowserViewHelper $page
     *
     * @return string
     */
    public function buildPage(PageBrowserViewHelper $page)
    {
        $this->addCssVendor(Assets::CORE_CSS);
        $this->addJsVendor(Assets::CORE_JQUERY_VENDOR);
        $this->addJsVendor(Assets::CORE_JS);

        $page->setPage(__DIR__ . '/CorePageTemplate');

        return parent::buildPage($page);
    }
}