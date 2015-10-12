<?php

namespace Simplon\Mvc\App\Views\Browser\Backoffice\Auth;

use Simplon\Mvc\App\Data\SampleData;
use Simplon\Mvc\App\Views\Browser\Backoffice\BackofficeBasePageBrowserView;
use Simplon\Mvc\Core\Views\PageBrowserViewHelper;

/**
 * Class AuthLoginBrowserView
 * @package Simplon\Mvc\App\Views\Browser\Backoffice\Auth
 */
class AuthLoginBrowserView extends BackofficeBasePageBrowserView
{
    /**
     * @return SampleData
     */
    public function getDataResponse()
    {
        return $this->dataResponse;
    }

    /**
     * @param array $params
     *
     * @return $this
     */
    public function build(array $params = [])
    {
        $this->setResult(
            $this->buildPage(
                (new PageBrowserViewHelper())
                    ->addPartialTemplate('content', __DIR__ . '/LoginPartialTemplate')
                    ->addParams($params)
            )
        );

        return $this;
    }
}