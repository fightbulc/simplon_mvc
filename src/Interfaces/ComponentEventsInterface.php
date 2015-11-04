<?php

namespace Simplon\Mvc\Interfaces;

use Simplon\Mvc\Mvc;
use Simplon\Mvc\Utils\Events\PushEvent;
use Simplon\Mvc\Utils\Events\PullEvent;

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
     * @return PushEvent[]|null
     */
    public function registerPushes();

    /**
     * @return PullEvent[]|null
     */
    public function registerPulls();
}