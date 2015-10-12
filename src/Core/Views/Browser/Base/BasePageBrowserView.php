<?php

namespace Simplon\Mvc\Core\Views\Browser\Base;

use Simplon\Mvc\App\Constants\AssetsConstants;
use Simplon\Mvc\Core\Views\Browser\BrowserView;
use Simplon\Mvc\Core\Views\Browser\Helper\PageBrowserViewHelper;

/**
 * Class BasePageBrowserView
 * @package Simplon\Mvc\Core\Views\Browser\Base
 */
abstract class BasePageBrowserView extends BrowserView
{
    /**
     * @param PageBrowserViewHelper $page
     *
     * @return string
     */
    public function buildPage(PageBrowserViewHelper $page)
    {
        // vendor related
        $this->addCss(AssetsConstants::VENDOR_CSS_NORMALIZE, AssetsConstants::BLOCK_VENDOR);
        $this->addCss(AssetsConstants::VENDOR_CSS_FLEXBOXGRID, AssetsConstants::BLOCK_VENDOR);
        $this->addJs(AssetsConstants::VENDOR_JS_VUEJS, AssetsConstants::BLOCK_VENDOR);
        $this->addJs(AssetsConstants::VENDOR_JS_QWEST, AssetsConstants::BLOCK_VENDOR);

        // page related
        $this->addCss(AssetsConstants::APP_CSS_BASE, AssetsConstants::BLOCK_PAGE);
        $this->addJs(AssetsConstants::APP_JS_BASE, AssetsConstants::BLOCK_PAGE);

        $page->setPage(__DIR__ . '/BasePageTemplate');

        return parent::buildPage($page);
    }
}