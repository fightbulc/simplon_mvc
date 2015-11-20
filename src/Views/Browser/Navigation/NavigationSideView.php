<?php

namespace Simplon\Mvc\Views\Browser\Navigation;

/**
 * Class NavigationSideView
 * @package Simplon\Mvc\Views\Browser\Navigation
 */
class NavigationSideView
{
    /**
     * @var int
     */
    private $position;

    /**
     * @var \string[]
     */
    private $html = [];

    /**
     * @return \string[]
     */
    public function getHtml()
    {
        return $this->html;
    }

    /**
     * @param \string[] $html
     *
     * @return NavigationSideView
     */
    public function addHtml($html)
    {
        $this->html[] = $html;

        return $this;
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param int $position
     *
     * @return NavigationSideView
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }
}