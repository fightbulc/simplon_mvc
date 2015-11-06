<?php

namespace Simplon\Mvc\Utils\Routes;

use Simplon\Mvc\Utils\CastAway;

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
    private $domain;

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
     * @var string
     */
    private $requestMethod;

    /**
     * @param string $domain
     * @param string $pattern
     * @param string $controller
     * @param string $method
     * @param string $requestMethod
     */
    public function __construct($domain, $pattern, $controller, $method, $requestMethod = null)
    {
        $this->domain = $domain;
        $this->pattern = $pattern;
        $this->controller = $controller;
        $this->method = $method;

        if ($this->isAllowedRequestMethod($requestMethod))
        {
            $this->requestMethod = $requestMethod;
        }
    }

    /**
     * @return string
     */
    public function getDomain()
    {
        return CastAway::trimPath(
            strtolower($this->domain)
        );
    }

    /**
     * @param string $domain
     *
     * @return Route
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;

        return $this;
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
     *
     * @return Route
     */
    public function setController($controller)
    {
        $this->controller = $controller;

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
     * @param string $method
     *
     * @return Route
     */
    public function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @return string
     */
    public function getRequestMethod()
    {
        return strtoupper($this->requestMethod);
    }

    /**
     * @return bool
     */
    public function hasRequestMethod()
    {
        return isset($this->requestMethod);
    }

    /**
     * @param string $requestMethod
     *
     * @return Route
     */
    public function setRequestMethod($requestMethod)
    {
        if ($this->isAllowedRequestMethod($requestMethod))
        {
            $this->requestMethod = $requestMethod;
        }

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

    /**
     * @param string $method
     *
     * @return bool
     */
    private function isAllowedRequestMethod($method)
    {
        $validMethods = [
            self::REQUEST_METHOD_GET,
            self::REQUEST_METHOD_POST,
            self::REQUEST_METHOD_PUT,
            self::REQUEST_METHOD_DELETE,
        ];

        return in_array(strtoupper($method), $validMethods);
    }
}