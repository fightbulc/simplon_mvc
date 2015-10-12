<?php

namespace Simplon\Mvc\Core\Interfaces;

/**
 * Interface QueryBuilderInterface
 * @package Simplon\Mvc\Core\Interfaces
 */
interface QueryBuilderInterface
{
    /**
     * @return string
     */
    public function getQuery();
}