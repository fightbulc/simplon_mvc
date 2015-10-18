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
     * @param RestViewInterface $view
     *
     * @return RestResponse
     */
    public function respond(RestViewInterface $view);

    /**
     * @return Locale
     */
    public function getLocale();
}