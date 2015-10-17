<?php

namespace Core\Utils\Events;

/**
 * Class EventListener
 * @package Core\Utils\Events
 */
class EventListener
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