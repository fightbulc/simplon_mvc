<?php

namespace Simplon\Mvc\Responses;

/**
 * Class BrowserResponse
 * @package Simplon\Mvc\Responses
 */
class BrowserResponse
{
    /**
     * @var string
     */
    private $content;

    /**
     * @param string $content
     */
    public function __construct($content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return (string)$this->content;
    }
}