<?php

namespace Simplon\Mvc;

use Simplon\Locale\LocaleException;
use Simplon\Locale\Readers\FileReader;
use Simplon\Mvc\Interfaces\ComponentRegistryInterface;
use Simplon\Mvc\Utils\CastAway;
use Simplon\Mvc\Utils\Events\EventListener;
use Simplon\Mvc\Utils\Events\EventRequest;
use Simplon\Mvc\Utils\Events\Events;
use Simplon\Mvc\Utils\Routes\Route;
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
    const MODULE_DEFAULT = 'app';
    const ROUTE_PLACEHOLDER_LOCALE = 'locale';

    /**
     * @var string
     */
    private $pathApp = __DIR__ . '/../../../../src/App';

    /**
     * @var string
     */
    private $env = self::ENV_DEV;

    /**
     * @var string
     */
    private $module = self::MODULE_DEFAULT;

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
     * @var string
     */
    private $localeId;

    /**
     * @param ErrorObserver $errorObserver
     * @param ComponentRegistryInterface[] $components
     */
    public function __construct(ErrorObserver $errorObserver, array $components)
    {
        $this->errorObserver = $errorObserver->observe();

        $this->request = new Request();
        $this->events = new Events();

        $this->initConfig();
        $this->setComponents($components);
    }

    /**
     * @return string
     */
    public function getEnv()
    {
        return $this->env;
    }

    /**
     * @param string $env
     *
     * @return Mvc
     */
    public function setEnv($env)
    {
        $this->env = $env;

        return $this;
    }

    /**
     * @return string
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * @param string $module
     *
     * @return Mvc
     */
    public function setModule($module)
    {
        $this->module = $module;

        return $this;
    }

    /**
     * @return Mvc
     */
    public function initConfig()
    {
        $this->config = new Config(
            self::loadFile($this->getPathApp() . '/Configs/config.php')
        );

        // staging or production
        if ($this->getEnv() !== self::ENV_DEV)
        {
            $this->config->merge(
                self::loadFile($this->getPathApp() . '/Configs/' . $this->getEnv() . '/config.php')
            );
        }

        return $this;
    }

    /**
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param string $componentName
     *
     * @return Mvc
     */
    public function mergeComponentConfig($componentName)
    {
        $path = 'Components/' . $componentName . '/Configs';

        $this->getConfig()->merge(
            self::loadFile($this->getPathApp($path . '/config.php'))
        );

        if ($this->getEnv() !== self::ENV_DEV)
        {
            $this->getConfig()->merge(
                self::loadFile($path . '/' . $this->getEnv() . '/config.php')
            );
        }

        return $this;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return new Request();
    }

    /**
     * @return string
     */
    public function getLocaleId()
    {
        return $this->localeId;
    }

    /**
     * @param string $localeId
     *
     * @return Mvc
     */
    public function setLocaleId($localeId)
    {
        $this->localeId = $localeId;

        return $this;
    }

    /**
     * @param string $componentName
     *
     * @return Locale
     * @throws ServerException
     */
    public function mergeComponentLocale($componentName)
    {
        $meta = null;

        try
        {
            $hasValidLocaleConfig =
                $this->getConfig()->hasConfigKeys(['locales']) === true
                && $this->getConfig()->hasConfigKeys(['locales', 'default']) === true;

            if ($hasValidLocaleConfig)
            {
                $availableLocales = [];
                $defaultLocale = $this->getConfig()->getConfigByKeys(['locales', 'default']);

                $hasDefinedAvailableLocales =
                    $this->getConfig()->hasConfigKeys(['locales', 'available'])
                    && is_array($this->getConfig()->getConfigByKeys(['locales', 'available']));

                // set available if defined
                if ($hasDefinedAvailableLocales)
                {
                    $availableLocales = $this->getConfig()->getConfigByKeys(['locales', 'available']);
                }

                // catch empty available locale
                if (empty($availableLocales))
                {
                    $availableLocales = [
                        $defaultLocale,
                    ];
                }

                $paths = [
                    $this->getPathApp('Locales'),
                    $this->getPathApp('Components/' . $componentName . '/Locales'),
                ];

                return new Locale(new FileReader($paths), $availableLocales);
            }
        }
        catch (LocaleException $e)
        {
            $meta = $e->getMessage();
        }

        throw (new ServerException)->internalError(
            [
                'reason' => 'Could not read locale information.',
                'meta'   => $meta,
            ]
        );
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
        $this->addRoutes($registry->registerRoutes());

        if (method_exists($registry, 'registerEvents'))
        {
            $events = $registry->registerEvents($this);

            if ($events !== null)
            {
                $listeners = $events->registerListeners();

                if ($listeners)
                {
                    $this->addEventListeners($listeners);
                }

                $requests = $events->registerRequests();

                if ($requests)
                {
                    $this->addEventRequests($requests);
                }
            }
        }

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
     * @param string $addToPath
     *
     * @return string
     */
    private function getPathApp($addToPath = null)
    {
        if (isset($addToPath))
        {
            return $this->pathApp . '/' . CastAway::trimPath($addToPath);
        }

        return $this->pathApp;
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
     * @param EventRequest[] $events
     *
     * @return Mvc
     */
    private function addEventRequests(array $events)
    {
        foreach ($events as $event)
        {
            $this->getEvents()->addRequest($event);
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
     * @throws ServerException
     */
    private function addRoutes(array $routes)
    {
        foreach ($routes as $route)
        {
            $patternHash = md5($route->getPattern() . $route->getRequestMethod());

            if (isset($this->routes[$patternHash]))
            {
                throw (new ServerException())->internalError(
                    [
                        'reason'        => 'Component is trying to redeclare existing route',
                        'pattern'       => $route->getPattern(),
                        'requestMethod' => $route->getRequestMethod(),
                        'controller'    => $route->getController(),
                        'method'        => $route->getMethod(),
                    ]
                );
            }

            $this->routes[$patternHash] = $route;
        }

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
                    $this->setLocaleId($params[$index]);
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
        $controller = $route->getController();
        $method = $route->getMethod();

        return $this->handleResponse(
            call_user_func_array([(new $controller($this)), $method], $params)
        );
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