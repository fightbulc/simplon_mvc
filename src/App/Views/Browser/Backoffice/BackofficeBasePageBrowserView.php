<?php

namespace Simplon\Mvc\App\Views\Browser\Backoffice;

use Simplon\Mvc\Core\Views\Browser\Base\BasePageBrowserView;
use Simplon\Mvc\Core\Views\Browser\Helper\PageBrowserViewHelper;

/**
 * Class BackofficeBasePageBrowserView
 * @package App\Views\Browser\Backoffice
 */
abstract class BackofficeBasePageBrowserView extends BasePageBrowserView
{
    /**
     * @param PageBrowserViewHelper $page
     *
     * @return string
     */
    public function buildPage(PageBrowserViewHelper $page)
    {
        return parent::buildPage(
            $page->addPartialTemplate('module', __DIR__ . '/BackofficeBasePageTemplate')
        );
    }
}