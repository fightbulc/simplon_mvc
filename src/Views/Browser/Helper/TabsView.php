<?php

namespace Simplon\Mvc\Views\Browser\Helper;

/**
 * Class TabsView
 * @package Simplon\Mvc\Views\Browser\Helper
 */
class TabsView
{
    /**
     * @var array
     */
    private $tabs;

    /**
     * @var string
     */
    private $activeTabId;

    /**
     * @var string
     */
    private $content;

    /**
     * @return string
     */
    public function getActiveTabId()
    {
        return $this->activeTabId;
    }

    /**
     * @param string $activeTabId
     *
     * @return TabsView
     */
    public function setActiveTabId($activeTabId)
    {
        $this->activeTabId = $activeTabId;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     *
     * @return TabsView
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return array
     */
    public function getTabs()
    {
        return $this->tabs;
    }

    /**
     * @param string $id
     * @param string $url
     * @param string $label
     *
     * @return TabsView
     */
    public function addTab($id, $url, $label)
    {
        $this->tabs[$id] = [
            'url'   => $url,
            'label' => $label,
        ];

        return $this;
    }
}