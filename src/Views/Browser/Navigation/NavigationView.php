<?php

namespace Simplon\Mvc\Views\Browser\Navigation;

/**
 * Class NavigationView
 * @package Simplon\Mvc\Views\Browser\Navigation
 */
abstract class NavigationView
{
    /**
     * @var int
     */
    private $position;

    /**
     * @var NavigationItemView[]
     */
    private $items;

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
     * @return static
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return NavigationItemView[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param string $id
     *
     * @return null|NavigationItemView
     */
    public function getItem($id)
    {
        if (isset($this->items[$id]))
        {
            return $this->items[$id];
        }

        return null;
    }

    /**
     * @param NavigationItemView $item
     *
     * @return static
     */
    public function addItem(NavigationItemView $item)
    {
        $this->items[$item->getId()] = $item;

        return $this;
    }
}