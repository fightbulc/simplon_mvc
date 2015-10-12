<?php

namespace Simplon\Mvc\Core\Interfaces;

/**
 * Interface RestViewInterface
 * @package Simplon\Mvc\Core
 */
interface RestViewInterface
{
    /**
     * @param DataInterface $data
     */
    public function __construct(DataInterface $data);

    /**
     * @param array $params
     *
     * @return RestViewInterface
     */
    public function build(array $params = []);

    /**
     * @return DataInterface
     */
    public function getDataResponse();

    /**
     * @return array
     */
    public function getResult();
}