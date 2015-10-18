<?php

namespace Simplon\Mvc\Interfaces;

/**
 * Interface BrowserViewInterface
 * @package Simplon\Mvc\Interfaces
 */
interface BrowserViewInterface
{
    /**
     * @param array $params
     *
     * @return BrowserViewInterface
     */
    public function build(array $params = []);

    /**
     * @return DataInterface
     */
    public function getData();

    /**
     * @return string
     */
    public function getResult();
}