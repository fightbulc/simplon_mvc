<?php

namespace Simplon\Mvc\Interfaces;

use Simplon\Locale\Locale;
use Simplon\Mvc\Responses\BrowserRedirect;
use Simplon\Mvc\Responses\BrowserResponse;
use Simplon\Mvc\Storages\SessionStorage;
use Simplon\Mvc\Views\Browser\FlashMessage;

/**
 * Interface BrowserControllerInterface
 * @package Core\Interfaces
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
     * @return FlashMessage
     */
    public function getFlashMessage();

    /**
     * @return SessionStorage
     */
    public function getSessionStorage();
}