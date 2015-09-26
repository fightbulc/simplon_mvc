<?php

namespace Simplon\Mvc\App\Views;

use Simplon\Mvc\App\Views\Responses\SampleDataResponse;
use Simplon\Mvc\Core\Views\BrowserView;

/**
 * Class SampleBrowserView
 * @package Simplon\Mvc\App\Views
 */
class SampleBrowserView extends BrowserView
{
    /**
     * @return SampleDataResponse
     */
    public function getDataRespones()
    {
        return $this->dataResponse;
    }

    /**
     * @return $this
     */
    public function build()
    {
        $this->getTemplate()->renderPhtml('TMPL', []);

        return $this;
    }
}