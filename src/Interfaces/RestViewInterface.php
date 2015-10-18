<?php

namespace Simplon\Mvc\Interfaces;

/**
 * Interface RestViewInterface
 * @package Simplon\Mvc
 */
interface RestViewInterface
{
    /**
     * @param array $params
     *
     * @return RestViewInterface
     */
    public function build(array $params = []);

    /**
     * @return DataInterface
     */
    public function getData();

    /**
     * @return array
     */
    public function getResult();
}