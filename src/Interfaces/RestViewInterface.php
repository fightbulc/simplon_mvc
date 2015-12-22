<?php

namespace Simplon\Mvc\Interfaces;

use Simplon\Locale\Locale;

/**
 * Interface RestViewInterface
 * @package Simplon\Mvc
 */
interface RestViewInterface
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
     * @return RestViewInterface
     */
    public function setLocale(Locale $locale);

    /**
     * @param array $params
     *
     * @return RestViewInterface
     */
    public function build(array $params = []);

    /**
     * @return array
     */
    public function getResult();
}