<?php

namespace Simplon\Mvc;

use Simplon\Error\ErrorContext;
use Simplon\Helper\Config;
use Simplon\Locale\Locale;
use Simplon\Mvc\Core\Responses\BrowserRedirect;
use Simplon\Mvc\Core\Responses\BrowserResponse;
use Simplon\Mvc\Core\Responses\RestResponse;
use Simplon\Request\Request;

/**
 * Class Mvc
 * @package Simplon\Mvc
 */
class Mvc
{
    const ENV_DEVEL = 'devel';
    const ENV_STAGING = 'staging';
    const ENV_PRODUCTION = 'production';

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
     * @var Request
     */
    private $request;

    /**
     * @var Locale
     */
    private $locale;

    /**
     * @param string $env
     * @param ErrorObserver $errorObserver
     */
    public function __construct($env = self::ENV_DEVEL, ErrorObserver $errorObserver)
    {
        $this->env = $env;
        $this->errorObserver = $errorObserver->observe();
        $this->request = new Request();
        $this->setupLocale();
    }

    /**
     * @param string $path
     *
     * @return mixed
     */
    public static function loadFile($path)
    {
        /** @noinspection PhpIncludeInspection */
        return require $path;
    }

    /**
     * @return string
     */
    public function getEnv()
    {
        return $this->env;
    }

    /**
     * @return Config
     */
    public function getConfig()
    {
        if ($this->config === null)
        {
            $common = self::loadFile(__DIR__ . '/App/Configs/config.php');
            $env = self::loadFile(__DIR__ . '/App/Configs/' . $this->getEnv() . '/config.php');
            $this->config = new Config($common, $env);
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
     * @return string
     */
    public function getCurrentLocale()
    {
        return $this->getLocale()->getCurrentLocale();
    }

    /**
     * @param $locale
     *
     * @return void
     */
    public function setCurrentLocale($locale)
    {
        self::getLocale()->setLocale($locale);
    }

    /**
     * @param string $requestedRoute
     *
     * @return string
     */
    public function dispatch($requestedRoute = null)
    {
        // set all available routes
        $routes = self::loadFile(__DIR__ . '/App/Configs/routes.php');

        // set route
        $requestedRoute = $requestedRoute ?: $_SERVER['PATH_INFO'];

        // clean route
        $requestedRoute = rtrim($requestedRoute, '/');

        // set request method
        $requestMethod = strtoupper($_SERVER['REQUEST_METHOD']);

        // loop through all defined routes
        foreach ($routes as $route)
        {
            $placeholders = [];

            // find placeholders
            if (preg_match_all('/\{(.*?)\}/i', $route['pattern'], $matchPlaceholders, PREG_SET_ORDER))
            {
                foreach ($matchPlaceholders as $placeholderKey)
                {
                    $placeholders[] = $placeholderKey[1];
                }
            }

            // handle controller matching
            if (preg_match_all('/' . preg_quote($route['pattern'], '/') . '\/*/i', $requestedRoute, $match, PREG_SET_ORDER))
            {
                // if home pattern the requested route should be empty too
                if (empty($route['pattern']) === true && empty($requestedRoute) === false)
                {
                    continue;
                }

                // handle request method restrictions
                if (empty($route['method']) === false && strpos(strtoupper($route['method']), $requestMethod) === false)
                {
                    continue;
                }

                // prepare params
                $params = [];

                if (isset($match[0][1]))
                {
                    // remove matched string
                    unset($match[0][0]);

                    // set params
                    $params = $match[0];
                }

                // handle request/response
                return $this->handleRequest($route, $params);
            }
        }

        $errorContext = (new ErrorContext())
            ->requestNotFound('Sorry, we cannot find what you requested', 0, ['route' => $requestedRoute]);

        return $this->getErrorObserver()->handleErrorResponse($errorContext);
    }

    /**
     * @param array $route
     * @param array $params
     *
     * @return string
     */
    private function handleRequest(array $route, array $params)
    {
        // handling via class
        if (isset($route['controller']))
        {
            list($controller, $method) = explode('::', $route['controller']);

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
                rtrim($this->getConfig()->getConfigByKeys(['paths', 'src']), '/') . '/Views/Locales',
                $availableLocales,
                $this->getConfig()->getConfigByKeys(['locales', 'default'])
            );
        }

        return $this;
    }

    /**
     * @param $response
     *
     * @return string
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

            $errorContext = (new ErrorContext())
                ->internalError('An error occured while trying to send a JSON response', 0, ['type' => $errorCodes[$lastError]]);

            return $this->getErrorObserver()->handleErrorResponse($errorContext);
        }
        elseif ($response instanceof BrowserRedirect)
        {
            $this->getRequest()->redirect($response->getUrl());
        }

        $errorContext = (new ErrorContext())
            ->internalError('Unknown response type', 0, ['class' => get_class($response)]);

        return $this->getErrorObserver()->handleErrorResponse($errorContext);
    }

    /**
     * @return ErrorObserver
     */
    private function getErrorObserver()
    {
        return $this->errorObserver;
    }
}