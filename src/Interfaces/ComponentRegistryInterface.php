<?php

namespace Simplon\Mvc\Interfaces;

use Simplon\Mvc\Mvc;
use Simplon\Mvc\Utils\Routes\Route;
use Simplon\Mvc\Views\Browser\Navigation\NavigationHiddenView;
use Simplon\Mvc\Views\Browser\Navigation\NavigationMainView;
use Simplon\Mvc\Views\Browser\Navigation\NavigationSideView;

/**
 * Interface ComponentRegistryInterface
 * @package Simplon\Mvc\Interfaces
 */
interface ComponentRegistryInterface
{
    /**
     * @return Route[]|null
     */
    public function registerRoutes();

    /**
     * @param Mvc $mvc
     *
     * @return ComponentEventsInterface|null
     */
    public function registerEvents(Mvc $mvc);

    /**
     * @param Mvc $mvc
     *
     * @return NavigationMainView|null
     */
    public function registerMainNavigation(Mvc $mvc);

    /**
     * @param Mvc $mvc
     *
     * @return NavigationHiddenView|null
     */
    public function registerHiddenNavigation(Mvc $mvc);

    /**
     * @param Mvc $mvc
     *
     * @return NavigationSideView|null
     */
    public function registerSideNavigation(Mvc $mvc);
}