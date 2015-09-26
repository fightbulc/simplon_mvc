<?php

namespace Simplon\Mvc;

use Simplon\Error\ErrorContext;
use Simplon\Error\ErrorHandler;
use Simplon\Phtml\Phtml;
use Simplon\Phtml\PhtmlException;

/**
 * Class ErrorObserver
 * @package Simplon\Mvc
 */
class ErrorObserver
{
    /**
     * @var string
     */
    private $responseType;

    /**
     * @var string
     */
    private $pathErrorTemplate;

    /**
     * @var \Closure[]
     */
    private $callbacks = [];

    /**
     * @param string $responseType
     * @param string $pathErrorTemplate
     */
    public function __construct($responseType, $pathErrorTemplate = __DIR__ . '/Core/Views/Templates/ErrorTemplate')
    {
        $this->responseType = $responseType;
        $this->pathErrorTemplate = $pathErrorTemplate;
    }

    /**
     * @return ErrorObserver
     */
    public function observe()
    {
        $this->observeScriptErrors();
        $this->observeFatalErrors();
        $this->observeExceptions();

        return $this;
    }

    /**
     * @param \Closure $callback
     *
     * @return ErrorObserver
     */
    public function addCallback(\Closure $callback)
    {
        $this->callbacks[] = $callback;

        return $this;
    }

    /**
     * @param ErrorContext $errorContext
     *
     * @return string
     * @throws PhtmlException
     */
    public function handleErrorResponse(ErrorContext $errorContext)
    {
        // set http status
        http_response_code($errorContext->getHttpCode());

        // handle context response
        switch ($this->getResponseType())
        {
            case ErrorContext::RESPONSE_TYPE_JSON:
                header('Content-type: application/json');

                return $this->handleErrorJsonResponse($errorContext);

            default:
                return Phtml::render($this->pathErrorTemplate, ['errorContext' => $errorContext]);
        }
    }

    /**
     * @return string
     */
    private function getResponseType()
    {
        return $this->responseType;
    }

    /**
     * @param ErrorContext $errorContext
     *
     * @return string
     */
    private function handleErrorJsonResponse(ErrorContext $errorContext)
    {
        $data = [
            'error' => [
                'code'    => $errorContext->getHttpCode(),
                'message' => $errorContext->getMessage(),
            ],
        ];

        // set code
        if ($errorContext->getCode() !== null)
        {
            $data['error']['code'] = $errorContext->getCode();
        }

        // set data
        if ($errorContext->hasData() === true)
        {
            $data['error']['data'] = $errorContext->getData();
        }

        return json_encode($data);
    }

    /**
     * @param ErrorContext $errorContext
     *
     * @return ErrorObserver
     */
    private function handleCallbacks(ErrorContext $errorContext)
    {
        foreach ($this->callbacks as $callback)
        {
            $callback($errorContext);
        }

        return $this;
    }

    /**
     * @return ErrorObserver
     */
    private function observeScriptErrors()
    {
        ErrorHandler::handleScriptErrors(
            function (ErrorContext $errorContext)
            {
                $this->handleCallbacks($errorContext);

                return $this->handleErrorResponse($errorContext);
            }
        );

        return $this;
    }

    /**
     * @return ErrorObserver
     */
    private function observeFatalErrors()
    {
        ErrorHandler::handleFatalErrors(
            function (ErrorContext $errorContext)
            {
                $this->handleCallbacks($errorContext);

                return $this->handleErrorResponse($errorContext);
            }
        );

        return $this;
    }

    /**
     * @return ErrorObserver
     */
    private function observeExceptions()
    {
        ErrorHandler::handleExceptions(
            function (ErrorContext $errorContext)
            {
                $this->handleCallbacks($errorContext);

                return $this->handleErrorResponse($errorContext);
            }
        );

        return $this;
    }
}