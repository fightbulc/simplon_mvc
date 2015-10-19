<?php

namespace Simplon\Mvc\Interfaces;

use Simplon\Mvc\Mvc;
use Simplon\Mvc\Utils\Routes\Route;

/**
 * Interface ComponentRegistryInterface
 * @package Simplon\Mvc\Interfaces
 */
interface ComponentRegistryInterface
{
    /**
     * @param Mvc $mvc
     *
     * @return ComponentEventsInterface|null
     */
    public function registerEvents(Mvc $mvc);

    /**
     * @return Route[]
     */
    public function registerRoutes();
}