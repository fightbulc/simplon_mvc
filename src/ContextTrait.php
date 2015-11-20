<?php

namespace Simplon\Mvc;

use Simplon\Mvc\Utils\Events\Events;
use Simplon\Mvc\Storages\SessionStorage;
use Simplon\Mvc\Utils\Config;
use Simplon\Mvc\Views\Browser\Navigation\NavigationHiddenView;
use Simplon\Mvc\Views\Browser\Navigation\NavigationItemView;
use Simplon\Mvc\Views\Browser\Navigation\NavigationSideView;
use Simplon\Request\Request;

/**
 * Class ContextTrait
 * @package Simplon\Mvc
 */
trait ContextTrait
{
    /**
     * @var Mvc
     */
    private $mvc;

    /**
     * @param Mvc $mvc
     */
    public function __construct(Mvc $mvc)
    {
        $this->mvc = $mvc;
    }

    /**
     * @return null|NavigationItemView[]
     */
    public function getNavigationMain()
    {
        return $this->getMvc()->getNavigationMain();
    }

    /**
     * @return null|NavigationHiddenView[]
     */
    public function getNavigationHidden()
    {
        return $this->getMvc()->getNavigationHidden();
    }

    /**
     * @return null|NavigationSideView[]
     */
    public function getNavigationSide()
    {
        return $this->getMvc()->getNavigationSide();
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->getMvc()->getRequest();
    }

    /**
     * @return Events
     */
    public function getEvents()
    {
        return $this->getMvc()->getEvents();
    }

    /**
     * @return SessionStorage
     */
    public function getSessionStorage()
    {
        return new SessionStorage();
    }

    /**
     * @return Config
     */
    public function getConfig()
    {
        return $this->getMvc()->getConfig();
    }

    /**
     * @return Mvc
     */
    private function getMvc()
    {
        return $this->mvc;
    }
}