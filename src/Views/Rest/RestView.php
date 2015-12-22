<?php

namespace Simplon\Mvc\Views\Rest;

use Simplon\Mvc\Interfaces\RestViewInterface;

/**
 * Class RestView
 * @package Simplon\Mvc\Views\Rest
 */
abstract class RestView implements RestViewInterface
{
    /**
     * @var array
     */
    protected $result = [];

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