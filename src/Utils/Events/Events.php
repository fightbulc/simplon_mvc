<?php

namespace Core\Utils\Events;

/**
 * Class Events
 * @package Core\Utils\Events
 */
class Events
{
    /**
     * @var array
     */
    protected $listeners = [];

    /**
     * @param string $event
     * @param \Closure $listener
     *
     * @return Events
     */
    public function on($event, \Closure $listener)
    {
        if (!isset($this->listeners[$event]))
        {
            $this->listeners[$event] = [];
        }

        $this->listeners[$event][] = $listener;

        return $this;
    }

    /**
     * @param string $event
     * @param \Closure $listener
     *
     * @return Events
     */
    public function once($event, \Closure $listener)
    {
        $onceListener = function () use (&$onceListener, $event, $listener)
        {
            $this->removeListener($event, $onceListener);
            call_user_func_array($listener, func_get_args());
        };

        $this->on($event, $onceListener);

        return $this;
    }

    /**
     * @param string $event
     * @param \Closure $listener
     *
     * @return Events
     */
    public function removeListener($event, \Closure $listener)
    {
        if (isset($this->listeners[$event]))
        {
            $index = array_search($listener, $this->listeners[$event], true);

            if (false !== $index)
            {
                unset($this->listeners[$event][$index]);
            }
        }

        return $this;
    }

    /**
     * @param string $event
     *
     * @return Events
     */
    public function removeAllListeners($event = null)
    {
        if ($event !== null)
        {
            unset($this->listeners[$event]);
        }
        else
        {
            $this->listeners = [];
        }

        return $this;
    }

    /**
     * @param string $event
     *
     * @return array
     */
    public function listeners($event)
    {
        return isset($this->listeners[$event]) ? $this->listeners[$event] : [];
    }

    /**
     * @param string $event
     * @param array $params
     *
     * @return Events
     */
    public function emit($event, array $params = [])
    {
        foreach ($this->listeners($event) as $listener)
        {
            call_user_func_array($listener, $params);
        }

        return $this;
    }
}