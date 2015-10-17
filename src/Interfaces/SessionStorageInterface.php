<?php

namespace Simplon\Mvc\Interfaces;

/**
 * Interface SessionStorageInterface
 * @package Simplon\Mvc\Interfaces
 */
interface SessionStorageInterface
{
    /**
     * @param string $key
     * @param mixed  $data
     *
     * @return bool
     */
    public function set($key, $data);

    /**
     * @param string $key
     *
     * @return bool
     */
    public function has($key);

    /**
     * @param string $key
     *
     * @return mixed|null
     */
    public function get($key);

    /**
     * @param string $key
     *
     * @return bool
     */
    public function del($key);

    /**
     * @return bool
     */
    public function destroy();
}