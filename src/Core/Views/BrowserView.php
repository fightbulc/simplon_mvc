<?php

namespace Simplon\Mvc\Core\Views;

use Simplon\Mvc\Core\BrowserViewInterface;
use Simplon\Mvc\Core\DataResponseInterface;
use Simplon\Template\Template;

/**
 * Class BrowserView
 * @package Simplon\Mvc\Core\Views
 */
abstract class BrowserView implements BrowserViewInterface
{
    /**
     * @var Template
     */
    protected $template;

    /**
     * @var DataResponseInterface
     */
    protected $dataResponse;

    /**
     * @var string
     */
    protected $content;

    /**
     * @param DataResponseInterface $data
     */
    public function __construct(DataResponseInterface $data = null)
    {
        $this->dataResponse = $data;
        $this->template = new Template();
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
     * @return BrowserView
     */
    protected function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return Template
     */
    protected function getTemplate()
    {
        return $this->template;
    }
}