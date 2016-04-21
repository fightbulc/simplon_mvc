<?php

namespace Simplon\Mvc\Interfaces;

use Simplon\Locale\Locale;
use Simplon\Mvc\Store\UserSessionModelInterface;

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
     * @return UserSessionModelInterface
     */
    public function getUserSessionModel();

    /**
     * @param UserSessionModelInterface $model
     *
     * @return BrowserViewInterface
     */
    public function setUserSessionModel(UserSessionModelInterface $model = null);

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