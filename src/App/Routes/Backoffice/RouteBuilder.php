<?php

namespace Simplon\Mvc\App\Routes\Backoffice;

/**
 * Class RouteBuilder
 * @package Simplon\Mvc\App\Routes\Backoffice
 */
class RouteBuilder extends \Simplon\Mvc\Core\Utils\RouteBuilder
{
    const PATTERN_DOMAIN = '';
    const PATTERN_HOME = '/{locale}';

    /**
     * @param string $locale
     *
     * @return string
     */
    public static function toHome($locale)
    {
        return self::buildUri(self::PATTERN_HOME, ['locale' => $locale]);
    }
}