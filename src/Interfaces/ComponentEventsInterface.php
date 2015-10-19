<?php

namespace Simplon\Mvc\Interfaces;

use Simplon\Mvc\Mvc;
use Simplon\Mvc\Utils\Events\EventListener;

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
}