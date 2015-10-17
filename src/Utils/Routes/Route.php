<?php

namespace Core\Utils\Routes;

/**
 * Class Route
 * @package Core\Utils\Routes
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
     * @var string
     */
    private $requestMethod;

    /**
     * @param string $pattern
     * @param string $controller
     * @param string $method
     * @param string $requestMethod
     */
    public function __construct($pattern, $controller, $method, $requestMethod = null)
    {
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