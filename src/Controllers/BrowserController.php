<?php

namespace Simplon\Mvc\Controllers;

use Simplon\Mvc\Interfaces\BrowserControllerInterface;
use Simplon\Mvc\Interfaces\BrowserViewInterface;
use Simplon\Mvc\Responses\BrowserRedirect;
use Simplon\Mvc\Responses\BrowserResponse;
use Simplon\Mvc\Views\Browser\FlashMessage;

/**
 * Class BrowserController
 * @package Simplon\Mvc\Controllers
 */
abstract class BrowserController implements BrowserControllerInterface
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
            'flash'            => $this->getFlashMessage(),
            'locale'           => $this->getLocale(),
            'navigationMain'   => $this->getNavigationMain(),
            'navigationHidden' => $this->getNavigationHidden(),
            'navigationSide'   => $this->getNavigationSide(),
        ];

        return new BrowserResponse(
            $view
                ->setLocale($this->getLocale())
                ->build($params)
                ->getResult()
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
     * @return string
     */
    public function getLocaleCode()
    {
        return $this->getLocale()->getCurrentLocale();
    }

    /**
     * @return FlashMessage
     */
    public function getFlashMessage()
    {
        if ($this->flashMessage === null)
        {
            $this->flashMessage = new FlashMessage(
                $this->getSessionStore()
            );
        }

        return $this->flashMessage;
    }
}