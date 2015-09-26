<?php

namespace Simplon\Mvc\Core\Controllers;

use Simplon\Mvc\Core\BrowserViewInterface;
use Simplon\Mvc\Core\Responses\BrowserRedirect;
use Simplon\Mvc\Core\Responses\BrowserResponse;
use Simplon\Mvc\Mvc;

/**
 * Class BrowserController
 * @package Simplon\Mvc\Core\Controllers
 */
abstract class BrowserController
{
    /**
     * @var Mvc
     */
    private $mvc;

    /**
     * @param Mvc $mvc
     */
    public function __construct(Mvc $mvc)
    {
        $this->mvc = $mvc;
    }

    /**
     * @param BrowserViewInterface $view
     *
     * @return BrowserResponse
     */
    public function respond(BrowserViewInterface $view)
    {
        return new BrowserResponse($view->getContent());
    }

    /**
     * @param string $url
     *
     * @return BrowserRedirect
     */
    public function redirect($url)
    {
        return new BrowserRedirect($url);
    }

    /**
     * @return bool
     */
    public function hasFlash()
    {
        return $this->getMvc()->hasFlash();
    }

    /**
     * @return null|string
     */
    public function getFlash()
    {
        return self::$flashMessage->getFlash();
    }

    /**
     * @param string $message
     *
     * @return bool
     */
    public function setFlashNormal($message)
    {
        return self::$flashMessage->setFlashNormal($message);
    }

    /**
     * @param string $message
     *
     * @return bool
     */
    public function setFlashSuccess($message)
    {
        return self::$flashMessage->setFlashSuccess($message);
    }

    /**
     * @param string $message
     *
     * @return bool
     */
    public function setFlashWarning($message)
    {
        return self::$flashMessage->setFlashWarning($message);
    }

    /**
     * @param string $message
     *
     * @return bool
     */
    public function setFlashError($message)
    {
        return self::$flashMessage->setFlashError($message);
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return self::$locale->getCurrentLocale();
    }

    /**
     * @return Mvc
     */
    protected function getMvc()
    {
        return $this->mvc;
    }
}