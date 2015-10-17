<?php

namespace Core\Interfaces;

use Core\Utils\Events\EventListener;
use Core\Utils\Routes\Route;

/**
 * Interface ComponentRegistryInterface
 * @package Core\Interfaces
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