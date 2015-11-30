<?php

namespace Simplon\Mvc\Utils\Routes;

use Simplon\Mvc\Utils\CastAway;

/**
 * Class RouteBuilder
 * @package Simplon\Mvc\Utils\Routes
 */
abstract class RouteBuilder
{
    /**
     * @param string|array $paths
     * @param array $params
     *
     * @return string
     */
    protected static function buildUri($paths, array $params = [])
    {
        if (is_array($paths) === false)
        {
            $paths = [$paths];
        }

        return CastAway::pathsToUriString($paths, $params);
    }

    /**
     * @param string $urlDomain
     * @param string|array $paths
     * @param array $params
     *
     * @return string
     */
    protected static function buildUriWithDomain($urlDomain, $paths, array $params = [])
    {
        return CastAway::trimUrl($urlDomain) . self::buildUri($paths, $params);
    }
}