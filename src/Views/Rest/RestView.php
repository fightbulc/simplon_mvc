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
     * @return DataInterface
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param DataInterface $data
     *
     * @return static
     */
    public function setData(DataInterface $data)
    {
        $this->data = $data;

        return $this;
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
     * @return static
     */
    protected function setResult(array $result)
    {
        $this->result = $result;

        return $this;
    }
}