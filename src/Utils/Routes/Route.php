<?php

namespace Simplon\Mvc\Utils\Routes;

/**
 * Class Route
 * @package Simplon\Mvc\Utils\Routes
 */
class Route
{
    const REQUEST_METHOD_GET = 'GET';
    const REQUEST_METHOD_POST = 'POST';
    const REQUEST_METHOD_PUT = 'PUT';
    const REQUEST_METHOD_DELETE = 'DELETE';

    /**
     * @var string
     */
    private $module;

    /**
     * @var string
     */
    private $pattern;

    /**
     * @var string
     */
    private $controller;

    /**
     * @var string
     */
    private $method;

    /**
     * @var \Closure
     */
    private $callback;

    /**
     * @var array
     */
    private $requestMethods;

    /**
     * @param string $module
     */
    public function __construct($module)
    {
        $this->module = $module;
    }

    /**
     * @return string
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * @return string
     */
    public function getPattern()
    {
        return strtolower($this->pattern);
    }

    /**
     * @param string $pattern
     *
     * @return Route
     */
    public function setPattern($pattern)
    {
        $this->pattern = $pattern;

        return $this;
    }

    /**
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @return bool
     */
    public function hasController()
    {
        return isset($this->controller);
    }

    /**
     * @param string $controller
     * @param string|null $method
     *
     * @return Route
     */
    public function setController($controller, $method = null)
    {
        $this->controller = $controller;
        $this->method = $method;

        return $this;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return array
     */
    public function getRequestMethods()
    {
        return $this->requestMethods;
    }

    /**
     * @return bool
     */
    public function hasRequestMethod()
    {
        return isset($this->requestMethods);
    }

    /**
     * @return Route
     */
    public function allowGet()
    {
        $this->requestMethods[] = self::REQUEST_METHOD_GET;

        return $this;
    }

    /**
     * @return Route
     */
    public function allowPost()
    {
        $this->requestMethods[] = self::REQUEST_METHOD_POST;

        return $this;
    }

    /**
     * @return Route
     */
    public function allowPut()
    {
        $this->requestMethods[] = self::REQUEST_METHOD_PUT;

        return $this;
    }

    /**
     * @return Route
     */
    public function allowDelete()
    {
        $this->requestMethods[] = self::REQUEST_METHOD_DELETE;

        return $this;
    }

    /**
     * @return \Closure
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * @param \Closure $callback
     *
     * @return Route
     */
    public function setCallback(\Closure $callback)
    {
        $this->callback = $callback;

        return $this;
    }
}