<?php

namespace Simplon\Mvc\Core\Controllers;

use Simplon\Mvc\Core\RestViewInterface;

/**
 * Class RestController
 * @package Simplon\Mvc\Core\Controllers
 */
abstract class RestController
{
    /**
     * @param RestViewInterface $view
     *
     * @return string
     */
    public function respond(RestViewInterface $view)
    {
        return $view->getContent();
    }
}