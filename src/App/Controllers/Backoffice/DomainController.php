<?php

namespace Simplon\Mvc\App\Controllers\Backoffice;

use Simplon\Mvc\App\Routes\Backoffice\RouteBuilder;
use Simplon\Mvc\Core\Controllers\BrowserController;
use Simplon\Mvc\Core\Responses\BrowserRedirect;

/**
 * Class DomainController
 * @package Simplon\Mvc\App\Controllers\Backoffice
 */
class DomainController extends BrowserController
{
    /**
     * @return BrowserRedirect
     */
    public function index()
    {
        return $this->redirect(
            RouteBuilder::toHome($this->getLocale()->getCurrentLocale()),
            BrowserController::ROUTE_MOVED_TEMPORARILY
        );
    }
}