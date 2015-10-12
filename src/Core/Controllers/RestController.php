<?php

namespace Simplon\Mvc\Core\Controllers;

use Simplon\Mvc\App\Context;
use Simplon\Mvc\Core\Interfaces\RestViewInterface;
use Simplon\Mvc\Core\Responses\RestResponse;

/**
 * Class RestController
 * @package Simplon\Mvc\Core\Controllers
 */
abstract class RestController extends Context
{
    /**
     * @param RestViewInterface $view
     *
     * @return RestResponse
     */
    public function respond(RestViewInterface $view)
    {
        return new RestResponse($view->build()->getResult());
    }
}