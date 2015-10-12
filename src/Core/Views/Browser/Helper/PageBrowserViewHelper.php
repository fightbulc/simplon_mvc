<?php

namespace Simplon\Mvc\Core\Views\Browser\Helper;

/**
 * Class PageBrowserViewHelper
 * @package Simplon\Mvc\Core\Views\Browser\Helper
 */
class PageBrowserViewHelper
{
    /**
     * @var string
     */
    private $page;

    /**
     * @var array
     */
    private $partials = [];

    /**
     * @var array
     */
    private $params = [];

    /**
     * @return string
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param string $page
     *
     * @return PageBrowserViewHelper
     */
    public function setPage($page)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * @param string $key
     * @param string $pathTemplate
     *
     * @return $this
     */
    public function addPartialTemplate($key, $pathTemplate)
    {
        $this->partials[$key] = $pathTemplate;

        return $this;
    }

    /**
     * @param array $params
     *
     * @return $this
     */
    public function addParams(array $params)
    {
        $this->params[] = $params;

        return $this;
    }

    /**
     * @return array
     */
    public function getPartials()
    {
        return $this->partials;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @return array
     */
    public function getParamsFlattened()
    {
        $flatParams = [];

        foreach ($this->params as $params)
        {
            $flatParams = array_merge($flatParams, $params);
        }

        return $flatParams;
    }
}