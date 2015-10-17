<?php

namespace Simplon\Mvc\Interfaces;

/**
 * Interface QueryBuilderInterface
 * @package Simplon\Mvc\Interfaces
 */
interface QueryBuilderInterface
{
    /**
     * @return string
     */
    public function getQuery();
}