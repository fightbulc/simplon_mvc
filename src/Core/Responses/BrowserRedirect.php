<?php

namespace Simplon\Mvc\Core\Responses;

/**
 * Class BrowserRedirect
 * @package Simplon\Mvc\Core\Responses
 */
class BrowserRedirect
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var int
     */
    private $statusCode;

    /**
     * @param string $url
     * @param int $statusCode
     */
    public function __construct($url, $statusCode = null)
    {
        $this->url = $url;
        $this->statusCode = $statusCode;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return bool
     */
    public function hasStatusCode()
    {
        return $this->statusCode !== null;
    }

    /**
     * @return int|null
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }
}