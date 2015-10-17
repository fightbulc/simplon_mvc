<?php

namespace Simplon\Mvc;

use Core\Interfaces\ComponentRegistryInterface;
use Core\Utils\Events\EventListener;
use Core\Utils\Events\Events;
use Core\Utils\Routes\Route;
use Simplon\Error\ErrorObserver;
use Simplon\Error\Exceptions\ClientException;
use Simplon\Error\Exceptions\ServerException;
use Simplon\Locale\Locale;
use Simplon\Mvc\Responses\BrowserRedirect;
use Simplon\Mvc\Responses\BrowserResponse;
use Simplon\Mvc\Responses\RestResponse;
use Simplon\Mvc\Utils\Config;
use Simplon\Request\Request;

/**
 * Class Mvc
 * @package Simplon\Mvc
 */
class Mvc
{
    const ENV_DEV = 'dev';
    const ENV_STAGING = 'staging';
    const ENV_PRODUCTION = 'production';
    const ROUTE_PLACEHOLDER_LOCALE = 'locale';

    /**
     * @var string
     */
    private $env;

    /**
     * @var Config
     */
    private $config;

    /**
     * @var ErrorObserver
     */
    private $errorObserver;

    /**
     * @var Events
     */
    private $events;

    /**
     * @var Route[]
     */
    private $routes;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var Locale
     */
    private $locale;

    /**
     * @var string
     */
    private $module;

    /**
     * @param ErrorObserver $errorObserver
     * @param string $env
     * @param string $module
     */
    public function __construct(ErrorObserver $errorObserver, $env = self::ENV_DEV, $module = 'app')
    {
        $this->errorObserver = $errorObserver->observe();
        $this->env = $env;
        $this->module = $module;
        $this->request = new Request();
        $this->events = new Events();
        $this->setupLocale();
    }

    /**
     * @return string
     */
    public function getEnv()
    {
        return $this->env;
    }

    /**
     * @return string
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * @return Config
     */
    public function getConfig()
    {
        if ($this->config === null)
        {
            $env = [];
            $common = self::loadFile(__DIR__ . '/App/Configs/config.php');

            // DEVEL will be our starting point for all environments
            if ($this->getEnv() !== self::ENV_DEV)
            {
                $env = self::loadFile(__DIR__ . '/App/Configs/' . $this->getEnv() . '/config.php');
            }

            $this->config = (new Config())->setConfig($common, $env);
        }

        return $this->config;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return new Request();
    }

    /**
     * @return Locale
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @return Events
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @param ComponentRegistryInterface $registry
     *
     * @return Mvc
     */
    public function addComponent(ComponentRegistryInterface $registry)
    {
        $this
            ->addRoutes($registry->registerRoutes())
            ->addEventListeners($registry->registerListeners());

        return $this;
    }

    /**
     * @param ComponentRegistryInterface[] $components
     *
     * @return Mvc
     */
    public function setComponents(array $components)
    {
        foreach ($components as $registry)
        {
            $this->addComponent($registry);
        }

        return $this;
    }

    /**
     * @param string $requestedRoute
     *
     * @return string
     * @throws ClientException
     */
    public function dispatch($requestedRoute = null)
    {
        $requestedRoute = rtrim($requestedRoute ?: $_SERVER['PATH_INFO'], '/');
        $requestMethod = strtoupper($_SERVER['REQUEST_METHOD']);

        foreach ($this->getRoutes() as $route)
        {
            $placeholders = [];

            // detect placeholders
            if (preg_match_all('/\{(.*?)\}/i', $route->getPattern(), $matchPlaceholders, PREG_SET_ORDER))
            {
                foreach ($matchPlaceholders as $placeholderKey)
                {
                    $placeholders[] = $placeholderKey[1];
                }
            }

            // replace placeholders
            foreach ($placeholders as $placeholder)
            {
                $route->setPattern(
                    str_replace('{' . $placeholder . '}', $this->getRoutePattern($placeholder), $route->getPattern())
                );
            }

            // handle controller matching
            if (preg_match_all('#^' . $route->getPattern() . '/*$#i', $requestedRoute, $match, PREG_SET_ORDER))
            {
                // if home pattern the requested route should be empty too
                if (empty($route->getPattern()) === true && empty($requestedRoute) === false)
                {
                    continue;
                }

                // handle request method restrictions
                if ($route->hasRequestMethod() && $route->getRequestMethod() !== $requestMethod)
                {
                    continue;
                }

                // prepare params
                $params = [];

                if (isset($match[0][1]))
                {
                    // remove matched string
                    array_shift($match[0]);

                    // set params
                    $params = $match[0];
                }

                // handle placeholder
                $this->handleRoutePlaceholders($placeholders, $params);

                // handle request/response
                return $this->handleRequest($route, $params);
            }
        }

        throw (new ClientException())->contentNotFound(['route' => $requestedRoute]);
    }

    /**
     * @param EventListener[] $events
     *
     * @return Mvc
     */
    private function addEventListeners(array $events)
    {
        foreach ($events as $event)
        {
            $this->getEvents()->on($event->getTrigger(), $event->getClosure());
        }

        return $this;
    }

    /**
     * @return Route[]
     */
    private function getRoutes()
    {
        return $this->routes;
    }

    /**
     * @param Route[] $routes
     *
     * @return Mvc
     */
    private function addRoutes(array $routes)
    {
        $this->routes = array_merge($this->routes, $routes);

        return $this;
    }

    /**
     * @param string $key
     *
     * @return null|string
     * @throws ServerException
     */
    private function getRoutePattern($key)
    {
        $pattern = null;

        switch ($key)
        {
            case self::ROUTE_PLACEHOLDER_LOCALE:
                if ($this->getConfig()->hasConfigKeys(['locales', 'available']))
                {
                    /** @var array $locales */
                    $locales = $this->getConfig()->getConfigByKeys(['locales', 'available']);
                    $pattern = '(' . join('|', $locales) . ')';
                }
                break;

            default:
                $pattern = '(.*?)';
        }

        return $pattern;
    }

    /**
     * @param array $placeholders
     * @param array $params
     *
     * @return array
     */
    private function handleRoutePlaceholders(array $placeholders, array $params)
    {
        foreach ($placeholders as $index => $placeholder)
        {
            switch ($placeholder)
            {
                case self::ROUTE_PLACEHOLDER_LOCALE:
                    $this->setupLocale();
                    $this->getLocale()->setLocale($params[$index]);
                    unset($params[$index]);
                    break;

                default:
            }
        }

        return $params;
    }

    /**
     * @param Route $route
     * @param array $params
     *
     * @return string
     */
    private function handleRequest(Route $route, array $params)
    {
        // handling via class
        if (isset($route['controller']))
        {
            $controller = $route->getController();
            $method = $route->getMethod();
            $response = call_user_func_array([(new $controller($this)), $method], $params);
        }

        // handling via closure
        else
        {
            $response = call_user_func_array($route['callback']($this), $params);
        }

        return $this->handleResponse($response);
    }

    /**
     * @return Mvc
     */
    private function setupLocale()
    {
        $hasValidLocaleConfig =
            $this->getConfig()->hasConfigKeys(['locales']) === true
            && $this->getConfig()->hasConfigKeys(['locales', 'default']) === true;

        if ($hasValidLocaleConfig)
        {
            $availableLocales = [];

            $hasDefinedAvailableLocales =
                $this->getConfig()->hasConfigKeys(['locales', 'available'])
                && is_array($this->getConfig()->getConfigByKeys(['locales', 'available']));

            // set available if defined
            if ($hasDefinedAvailableLocales)
            {
                $availableLocales = $this->getConfig()->getConfigByKeys(['locales', 'available']);
            }

            // fill up default locale
            if (empty($availableLocales) === true)
            {
                $availableLocales = [
                    $this->getConfig()->getConfigByKeys(['locales', 'default']),
                ];
            }

            // init locale
            $this->locale = new Locale(
                __DIR__ . '/App/Locales',
                $availableLocales,
                $this->getConfig()->getConfigByKeys(['locales', 'default'])
            );
        }

        return $this;
    }

    /**
     * @param mixed $response
     *
     * @return string
     * @throws ServerException
     */
    private function handleResponse($response)
    {
        if ($response instanceof BrowserResponse)
        {
            return $response->getContent();
        }
        elseif ($response instanceof RestResponse)
        {
            $responseData = json_encode($response->getData());

            // catch encoding errors
            $lastError = json_last_error();

            if ($lastError === JSON_ERROR_NONE)
            {
                header('Content-type: application/json; charset=utf-8');

                return $responseData;
            }

            $errorCodes = [
                1 => 'JSON_ERROR_DEPTH',
                2 => 'JSON_ERROR_STATE_MISMATCH',
                3 => 'JSON_ERROR_CTRL_CHAR',
                4 => 'JSON_ERROR_SYNTAX',
                5 => 'JSON_ERROR_UTF8',
            ];

            throw (new ServerException())->internalError(['type' => $errorCodes[$lastError]]);
        }
        elseif ($response instanceof BrowserRedirect)
        {
            // temporary/permanently status codes
            if ($response->hasStatusCode())
            {
                http_response_code($response->getStatusCode());
            }

            $this->getRequest()->redirect($response->getUrl());
        }

        throw (new ServerException())->internalError(['class' => get_class($response)]);
    }

    /**
     * @param string $path
     *
     * @return mixed
     */
    private static function loadFile($path)
    {
        /** @noinspection PhpIncludeInspection */
        return require $path;
    }
}