<?php

namespace Simplon\Mvc\App\Controllers\Backoffice;

use Simplon\Mvc\App\Views\Browser\Backoffice\Auth\AuthLoginBrowserView;
use Simplon\Mvc\Core\Controllers\BrowserController;
use Simplon\Mvc\Core\Responses\BrowserResponse;

/**
 * Class AuthController
 * @package Simplon\Mvc\App\Controllers\Backoffice
 */
class AuthController extends BrowserController
{
    /**
     * @return BrowserResponse
     */
    public function index()
    {
        return $this->respond(
            new AuthLoginBrowserView()
        );
    }
}