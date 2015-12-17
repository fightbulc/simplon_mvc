<?php

namespace Simplon\Mvc\Interfaces;

use Simplon\Locale\Locale;
use Simplon\Mvc\Responses\RestResponse;

/**
 * Interface RestControllerInterface
 * @package Simplon\Mvc\Interfaces
 */
interface RestControllerInterface
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
     * @param RestViewInterface $view
     *
     * @return RestResponse
     */
    public function respond(RestViewInterface $view);
}