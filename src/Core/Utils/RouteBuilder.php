<?php

namespace Simplon\Mvc\Core\Utils;

/**
 * Class RouteBuilder
 * @package Simplon\Mvc\Core\Utils
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
}