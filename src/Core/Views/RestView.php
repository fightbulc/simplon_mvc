<?php

namespace Simplon\Mvc\Core\Views;

use Simplon\Mvc\Core\DataResponseInterface;
use Simplon\Mvc\Core\RestViewInterface;

/**
 * Class RestView
 * @package Simplon\Mvc\Core\Views
 */
abstract class RestView implements RestViewInterface
{
    /**
     * @var DataResponseInterface
     */
    private $data;

    /**
     * @var string
     */
    private $content;

    /**
     * RestView constructor.
     *
     * @param DataResponseInterface $data
     */
    public function __construct(DataResponseInterface $data)
    {
        $this->data = $data;
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
     * @return RestView
     */
    protected function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @param array $data
     *
     * @return string
     */
    protected function renderJson(array $data)
    {
        return json_encode($data);
    }
}