<?php

namespace Simplon\Mvc\Utils\Events;

/**
 * Class Events
 * @package Simplon\Mvc\Utils\Events
 */
class Events
{
    /**
     * @var array
     */
    protected $pushes = [];

    /**
     * @var array
     */
    protected $pulls = [];

    /**
     * @param string $event
     * @param \Closure $listener
     *
     * @return Events
     */
    public function addPush($event, \Closure $listener)
    {
        if (empty($this->pushes[$event]))
        {
            $this->pushes[$event] = [];
        }

        $this->pushes[$event][] = $listener;

        return $this;
    }

    /**
     * @param string $event
     * @param \Closure $listener
     *
     * @return Events
     */
    public function removePush($event, \Closure $listener)
    {
        if (isset($this->pushes[$event]))
        {
            $index = array_search($listener, $this->pushes[$event], true);

            if (false !== $index)
            {
                unset($this->pushes[$event][$index]);
            }
        }

        return $this;
    }

    /**
     * @param string $event
     *
     * @return Events
     */
    public function removePushes($event = null)
    {
        if ($event !== null)
        {
            unset($this->pushes[$event]);
        }
        else
        {
            $this->pushes = [];
        }

        return $this;
    }

    /**
     * @param string $event
     *
     * @return array
     */
    public function getPushes($event)
    {
        return isset($this->pushes[$event]) ? $this->pushes[$event] : [];
    }

    /**
     * @param string $event
     * @param array $params
     *
     * @return Events
     */
    public function push($event, array $params = [])
    {
        foreach ($this->getPushes($event) as $push)
        {
            call_user_func_array($push, $params);
        }

        return $this;
    }

    /**
     * @param PullEvent $event
     *
     * @return Events
     */
    public function addPull(PullEvent $event)
    {
        $this->pulls[$event->getTrigger()] = $event->getClosure();

        return $this;
    }

    /**
     * @param string $event
     * @param array $params
     *
     * @return mixed|null
     */
    public function pull($event, array $params = [])
    {
        if (isset($this->pulls[$event]))
        {
            return call_user_func_array($this->pulls[$event], $params);
        }

        return null;
    }
}