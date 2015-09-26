<?php

namespace Simplon\Mvc\App\Controllers;

use Simplon\Mvc\App\Views\SampleBrowserView;
use Simplon\Mvc\Core\Controllers\BrowserController;
use Simplon\Mvc\Core\Responses\BrowserResponse;

/**
 * Class SampleController
 * @package Simplon\Mvc\App\Controllers
 */
class SampleController extends BrowserController
{
    /**
     * @return BrowserResponse
     */
    public function index()
    {
        return $this->respond(
            new SampleBrowserView()
        );
    }
}