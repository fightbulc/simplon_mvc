<?php

namespace Simplon\Mvc\Core\Responses;

/**
 * Class RestResponse
 * @package Simplon\Mvc\Core\Responses
 */
class RestResponse
{
    /**
     * @var array
     */
    private $data;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return ['data' => $this->data];
    }
}