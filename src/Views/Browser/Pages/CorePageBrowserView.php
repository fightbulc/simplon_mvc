<?php

namespace Simplon\Mvc\Views\Browser\Pages;

use Core\Views\Browser\Assets;
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
        $this->addCssVendor(Assets::VENDOR_NORMALIZE_CSS);
        $this->addCssVendor(Assets::VENDOR_FLEXBOXGRID_CSS);
        $this->addJsVendor(Assets::VENDOR_VUEJS_JS);
        $this->addJsVendor(Assets::VENDOR_QWEST_JS);

        $page->setPage(__DIR__ . '/CorePageTemplate');

        return parent::buildPage($page);
    }
}