<?php

namespace Simplon\Mvc\Core\Controllers;

use Simplon\Mvc\App\Context;
use Simplon\Mvc\Core\Interfaces\BrowserViewInterface;
use Simplon\Mvc\Core\Responses\BrowserRedirect;
use Simplon\Mvc\Core\Responses\BrowserResponse;
use Simplon\Mvc\Core\Views\FlashMessage;

/**
 * Class BrowserController
 * @package Simplon\Mvc\Core\Controllers
 */
abstract class BrowserController extends Context
{
    const ROUTE_MOVED_PERMANENTLY = 301;
    const ROUTE_MOVED_TEMPORARILY = 302;

    /**
     * @var FlashMessage
     */
    protected $flashMessage;

    /**
     * @param BrowserViewInterface $view
     *
     * @return BrowserResponse
     */
    public function respond(BrowserViewInterface $view)
    {
        $params = [
            'flash' => $this->getFlashMessage(),
            'trans' => $this->getLocale(),
        ];

        return new BrowserResponse(
            $view->build($params)->getResult()
        );
    }

    /**
     * @param string $url
     * @param int $hasMovedCode
     *
     * @return BrowserRedirect
     */
    public function redirect($url, $hasMovedCode = null)
    {
        if ($hasMovedCode !== null)
        {
            if (in_array($hasMovedCode, [self::ROUTE_MOVED_PERMANENTLY, self::ROUTE_MOVED_TEMPORARILY]) === false)
            {
                $hasMovedCode = null;
            }
        }

        return new BrowserRedirect($url, $hasMovedCode);
    }

    /**
     * @return FlashMessage
     */
    public function getFlashMessage()
    {
        if ($this->flashMessage === null)
        {
            $this->flashMessage = new FlashMessage(
                $this->getSessionStorage()
            );
        }

        return $this->flashMessage;
    }
}