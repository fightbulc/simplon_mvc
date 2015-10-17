<?php

namespace Simplon\Mvc\Interfaces;

/**
 * Interface BrowserViewInterface
 * @package Simplon\Mvc\Interfaces
 */
interface BrowserViewInterface
{
    /**
     * @param DataInterface $data
     */
    public function __construct(DataInterface $data = null);

    /**
     * @param array $params
     *
     * @return BrowserViewInterface
     */
    public function build(array $params = []);

    /**
     * @return DataInterface
     */
    public function getDataResponse();

    /**
     * @return string
     */
    public function getResult();
}