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
     * @param string $url
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
}