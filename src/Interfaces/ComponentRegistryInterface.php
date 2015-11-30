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
     * @param Mvc $mvc
     */
    public function __construct(Mvc $mvc);

    /**
     * @return Route[]|null
     */
    public function registerRoutes();

    /**
     * @return ComponentEventsInterface|null
     */
    public function registerEvents();

    /**
     * @return NavigationMainView|null
     */
    public function registerMainNavigation();

    /**
     * @return NavigationHiddenView|null
     */
    public function registerHiddenNavigation();

    /**
     * @return NavigationSideView|null
     */
    public function registerSideNavigation();
}