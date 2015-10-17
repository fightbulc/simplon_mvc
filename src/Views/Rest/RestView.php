<?php

namespace Simplon\Mvc\Views\Rest;

use Simplon\Mvc\Interfaces\DataInterface;
use Simplon\Mvc\Interfaces\RestViewInterface;

/**
 * Class RestView
 * @package Simplon\Mvc\Views\Rest
 */
abstract class RestView implements RestViewInterface
{
    /**
     * @var DataInterface
     */
    protected $data;

    /**
     * @var array
     */
    protected $result = [];

    /**
     * RestView constructor.
     *
     * @param DataInterface $data
     */
    public function __construct(DataInterface $data)
    {
        $this->data = $data;
    }

    /**
     * @return DataInterface
     */
    public function getDataResponse()
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param array $result
     *
     * @return RestView
     */
    protected function setResult(array $result)
    {
        $this->result = $result;

        return $this;
    }
}