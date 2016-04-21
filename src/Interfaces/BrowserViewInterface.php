<?php

namespace Simplon\Mvc\Interfaces;

use Simplon\Locale\Locale;
use Store\UserSessionModelInterface;

/**
 * Interface BrowserViewInterface
 * @package Simplon\Mvc\Interfaces
 */
interface BrowserViewInterface
{
    /**
     * @return Locale
     */
    public function getLocale();

    /**
     * @return UserSessionModelInterface
     */
    public function getUserSessionModel();

    /**
     * @return string
     */
    public function getLocaleCode();

    /**
     * @param Locale $locale
     *
     * @return BrowserViewInterface
     */
    public function setLocale(Locale $locale);

    /**
     * @param array $params
     *
     * @return BrowserViewInterface
     */
    public function build(array $params = []);

    /**
     * @return string
     */
    public function getResult();
}