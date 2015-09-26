<?php

namespace Simplon\Mvc\Core;

/**
 * Interface ModelInterface
 * @package Simplon\Mvc\Core
 */
interface ModelInterface
{
    /**
     * @param array $data
     *
     * @return $this
     */
    public function fromArray(array $data);

    /**
     * @param bool $snakeCase
     *
     * @return array
     */
    public function toArray($snakeCase = true);
}