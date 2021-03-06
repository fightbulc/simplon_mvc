<?php

namespace Simplon\Mvc\Interfaces;

use Simplon\Locale\Locale;
use Simplon\Mvc\Responses\BrowserRedirect;
use Simplon\Mvc\Responses\BrowserResponse;
use Simplon\Mvc\Store\SessionStore;
use Simplon\Mvc\Views\Browser\FlashMessage;
use Simplon\Mvc\Views\Browser\Navigation\NavigationHiddenView;
use Simplon\Mvc\Views\Browser\Navigation\NavigationItemView;
use Simplon\Mvc\Views\Browser\Navigation\NavigationSideView;
use Simplon\Mvc\Store\UserSessionModelInterface;

/**
 * Interface BrowserControllerInterface
 * @package Simplon\Mvc\Interfaces
 */
interface BrowserControllerInterface
{
    /**
     * @param BrowserViewInterface $view
     *
     * @return BrowserResponse
     */
    public function respond(BrowserViewInterface $view);

    /**
     * @param string $url
     * @param int $hasMovedCode
     *
     * @return BrowserRedirect
     */
    public function redirect($url, $hasMovedCode = null);

    /**
     * @return Locale
     */
    public function getLocale();

    /**
     * @return string
     */
    public function getLocaleCode();

    /**
     * @return NavigationItemView[]
     */
    public function getNavigationMain();

    /**
     * @return NavigationHiddenView[]
     */
    public function getNavigationHidden();

    /**
     * @return NavigationSideView[]
     */
    public function getNavigationSide();

    /**
     * @return FlashMessage
     */
    public function getFlashMessage();

    /**
     * @return UserSessionModelInterface
     */
    public function getUserSessionModel();

    /**
     * @return SessionStore
     */
    public function getSessionStore();
}