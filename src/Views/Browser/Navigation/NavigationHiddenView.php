<?php

namespace Simplon\Mvc\Views\Browser\Navigation;

/**
 * Class NavigationHiddenView
 * @package Simplon\Mvc\Views\Browser\Navigation
 */
class NavigationHiddenView extends NavigationView
{
    /**
     * @var string
     */
    private $header;

    /**
     * @return bool
     */
    public function hasHeader()
    {
        return $this->header !== null;
    }

    /**
     * @return string
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @param string $header
     *
     * @return NavigationHiddenView
     */
    public function setHeader($header)
    {
        $this->header = $header;

        return $this;
    }
}