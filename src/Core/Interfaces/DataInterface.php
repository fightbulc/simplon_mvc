<?php

namespace Simplon\Mvc\Core\Interfaces;

/**
 * Interface DataInterface
 * @package Simplon\Mvc\Core\Interfaces
 */
interface DataInterface
{
    /**
     * @param array $data
     *
     * @return DataInterface
     */
    public function fromArray(array $data);

    /**
     * @return array
     */
    public function toArray();
}