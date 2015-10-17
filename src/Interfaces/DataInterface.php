<?php

namespace Simplon\Mvc\Interfaces;

/**
 * Interface DataInterface
 * @package Simplon\Mvc\Interfaces
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