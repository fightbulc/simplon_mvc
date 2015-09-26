<?php

namespace Simplon\Mvc\Core\Responses;

/**
 * Class BrowserResponse
 * @package Simplon\Mvc\Core\Responses
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