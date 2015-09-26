<?php

namespace Simplon\Mvc;

/**
 * Class MvcException
 * @package Simplon\Frontend
 */
class MvcException extends \Exception
{
    const RENDER_JSON = 'json';
    const RENDER_BROWSER = 'browser';

    /**
     * @var string
     */
    private $renderType;

    /**
     * @var int
     */
    private $httpStatus;

    /**
     * @var array
     */
    private $data = [];

    /**
     * @var \Exception
     */
    private $previous;

    /**
     * @param string $renderType
     * @param int $httpStatus
     * @param string $message
     * @param array $data
     * @param \Exception $previous
     */
    public function __construct($renderType, $httpStatus, $message, array $data = [], \Exception $previous = null)
    {
        $this->renderType = $renderType;
        $this->data = $data;
        $this->httpStatus = $httpStatus;
        $this->previous = $previous;
        $this->message = $message;
    }

    /**
     * @return int
     */
    public function getHttpStatus()
    {
        return $this->httpStatus;
    }

    /**
     * @return string
     */
    public function getRenderType()
    {
        return $this->renderType;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
} 