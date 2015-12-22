<?php

namespace Simplon\Mvc;

use Simplon\Locale\LocaleException;
use Simplon\Locale\Readers\FileReader;
use Simplon\Mvc\Interfaces\ComponentRegistryInterface;
use Simplon\Mvc\Utils\CastAway;
use Simplon\Mvc\Utils\Events\PushEvent;
use Simplon\Mvc\Utils\Events\PullEvent;
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
use Simplon\Mvc\Views\Browser\Navigation\NavigationHiddenView;
use Simplon\Mvc\Views\Browser\Navigation\NavigationMainView;
use Simplon\Mvc\Views\Browser\Navigation\NavigationSideView;
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
     * @var Request
     */
    private $request;

    /**
     * @var string
     */
    private $localeCode;

    /**
     * @var ComponentRegistryInterface[]
     */
    private $components;

    /**
     * @var Events
     */
    private $events;

    /**
     * @var Route[]
     */
    private $routes;

    /**
     * @var NavigationMainView[]
     */
    private $navigationMain = [];

    /**
     * @var NavigationHiddenView[]
     */
    private $navigationHidden = [];

    /**
     * @var NavigationSideView[]
     */
    private $navigationSide = [];

    /**
     * @param string[] $components
     * @param ErrorObserver $errorObserver
     */
    public function __construct(array $components, ErrorObserver $errorObserver = null)
    {
        if ($errorObserver === null)
        {
            $errorObserver = new ErrorObserver(ErrorObserver::RESPONSE_HTML);
        }

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
     * @return Request
     */
    public function getRequest()
    {
        return new Request();
    }

    /**
     * @return Events
     */
    public function getEvents()
    {
        return $this->events;
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
     * @param string $componentRootPath
     *
     * @return Mvc
     */
    public function mergeComponentConfig($componentRootPath)
    {
        $pathComponentParts = explode('/', $componentRootPath);
        $componentName = array_pop($pathComponentParts);

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
     * @return string
     */
    public function getLocaleCode()
    {
        return $this->localeCode;
    }

    /**
     * @param string $localeCode
     *
     * @return Mvc
     */
    public function setLocaleCode($localeCode)
    {
        $this->localeCode = $localeCode;

        return $this;
    }

    /**
     * @param string $componentRootPath
     *
     * @return Locale
     * @throws ServerException
     */
    public function mergeComponentLocale($componentRootPath)
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

                $pathComponentParts = explode('/', $componentRootPath);
                $componentName = array_pop($pathComponentParts);

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
     * @param string[] $components
     *
     * @return Mvc
     */
    public function setComponents(array $components)
    {
        foreach ($components as $className)
        {
            $this->registerComponent(
                new $className($this)
            );
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
            $isMatchingRoute =
                $this->getModule() === $route->getModule() &&
                preg_match_all('#^' . $route->getPattern() . '/*$#i', $requestedRoute, $match, PREG_SET_ORDER);

            if ($isMatchingRoute)
            {
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
                $params = $this->handleRoutePlaceholders($placeholders, $params);

                // inject components navigation
                $this->registerComponentsNavigation();

                // handle request/response
                return $this->handleRequest($route, $params);
            }
        }

        throw (new ClientException())->contentNotFound(['route' => $requestedRoute]);
    }

    /**
     * @return NavigationHiddenView[]|null
     */
    public function getNavigationHidden()
    {
        return $this->navigationHidden;
    }

    /**
     * @return NavigationMainView[]|null
     */
    public function getNavigationMain()
    {
        return $this->navigationMain;
    }

    /**
     * @return NavigationSideView[]|null
     */
    public function getNavigationSide()
    {
        return $this->navigationSide;
    }

    /**
     * @param ComponentRegistryInterface $registry
     *
     * @return Mvc
     */
    private function registerComponent(ComponentRegistryInterface $registry)
    {
        $this->components[] = $registry;

        $routes = $registry->registerRoutes();
        $events = $registry->registerEvents();

        if ($routes)
        {
            $this->addRoutes($routes);
        }

        if ($events)
        {
            $pushes = $events->registerPushes();

            if ($pushes)
            {
                $this->addEventPushes($pushes);
            }

            $pulls = $events->registerPulls();

            if ($pulls)
            {
                $this->addEventPulls($pulls);
            }
        }

        return $this;
    }

    /**
     * @return Mvc
     */
    private function registerComponentsNavigation()
    {
        foreach ($this->components as $registry)
        {
            $this->addMainNavigation(
                $registry->registerMainNavigation()
            );

            $this->addHiddenNavigation(
                $registry->registerHiddenNavigation()
            );

            $this->addSideNavigation(
                $registry->registerSideNavigation()
            );
        }

        return $this;
    }

    /**
     * @param NavigationMainView|null $nav
     *
     * @return Mvc
     */
    private function addMainNavigation(NavigationMainView $nav = null)
    {
        if ($nav)
        {
            $this->navigationMain[$nav->getPosition()] = $nav;
            ksort($this->navigationMain);
        }

        return $this;
    }

    /**
     * @param NavigationHiddenView|null $nav
     *
     * @return Mvc
     */
    private function addHiddenNavigation(NavigationHiddenView $nav = null)
    {
        if ($nav)
        {
            $this->navigationHidden[$nav->getPosition()] = $nav;
            ksort($this->navigationHidden);
        }

        return $this;
    }

    /**
     * @param NavigationSideView|null $nav
     *
     * @return Mvc
     */
    private function addSideNavigation(NavigationSideView $nav = null)
    {
        if ($nav)
        {
            $this->navigationSide[$nav->getPosition()] = $nav;
            ksort($this->navigationSide);
        }

        return $this;
    }

    /**
     * @param PushEvent[] $events
     *
     * @return Mvc
     */
    private function addEventPushes(array $events)
    {
        foreach ($events as $event)
        {
            $this->getEvents()->addPush($event->getTrigger(), $event->getClosure());
        }

        return $this;
    }

    /**
     * @param PullEvent[] $events
     *
     * @return Mvc
     */
    private function addEventPulls(array $events)
    {
        foreach ($events as $event)
        {
            $this->getEvents()->addPull($event);
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
            $patternHash = md5($route->getModule() . $route->getPattern() . $route->getRequestMethod());

            if (isset($this->routes[$patternHash]))
            {
                throw (new ServerException())->internalError(
                    [
                        'reason'        => 'Component is trying to redeclare existing route',
                        'domain'        => $route->getModule(),
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
                    $this->setLocaleCode($params[$index]);
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