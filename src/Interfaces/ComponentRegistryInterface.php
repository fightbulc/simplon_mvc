<?php

namespace Simplon\Mvc\Interfaces;

use Simplon\Mvc\Utils\Events\EventListener;
use Simplon\Mvc\Utils\Routes\Route;

/**
 * Interface ComponentRegistryInterface
 * @package Simplon\Mvc\Interfaces
 */
interface ComponentRegistryInterface
{
    /**
     * @return EventListener[]
     */
    public function registerListeners();

    /**
     * @return Route[]
     */
    public function registerRoutes();
}