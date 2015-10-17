<?php

namespace Simplon\Mvc\Controllers;

use Simplon\Mvc\Interfaces\RestControllerInterface;
use Simplon\Mvc\Interfaces\RestViewInterface;
use Simplon\Mvc\Responses\RestResponse;

/**
 * Class RestController
 * @package Simplon\Mvc\Controllers
 */
abstract class RestController implements RestControllerInterface
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