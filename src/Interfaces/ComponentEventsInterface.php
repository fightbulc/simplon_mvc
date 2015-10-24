<?php

namespace Simplon\Mvc\Interfaces;

use Simplon\Mvc\Mvc;
use Simplon\Mvc\Utils\Events\EventListener;
use Simplon\Mvc\Utils\Events\EventRequest;

/**
 * Interface ComponentEventsInterface
 * @package Simplon\Mvc\Interfaces
 */
interface ComponentEventsInterface
{
    /**
     * @param Mvc $mvc
     */
    public function __construct(Mvc $mvc);

    /**
     * @return EventListener[]|null
     */
    public function registerListeners();

    /**
     * @return EventRequest[]|null
     */
    public function registerRequests();
}