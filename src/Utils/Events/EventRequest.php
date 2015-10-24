<?php

namespace Simplon\Mvc\Utils\Events;

/**
 * Class EventRequest
 * @package Simplon\Mvc\Utils\Events
 */
class EventRequest
{
    /**
     * @var string
     */
    private $trigger;

    /**
     * @var \Closure
     */
    private $closure;

    /**
     * @param string $trigger
     * @param \Closure $closure
     */
    public function __construct($trigger, \Closure $closure)
    {
        $this->trigger = $trigger;
        $this->closure = $closure;
    }

    /**
     * @return string
     */
    public function getTrigger()
    {
        return $this->trigger;
    }

    /**
     * @return \Closure
     */
    public function getClosure()
    {
        return $this->closure;
    }
}