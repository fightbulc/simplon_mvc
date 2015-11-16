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
     * @param string $domain
     * @param string|array $paths
     * @param array $params
     *
     * @return string
     */
    protected static function buildUri($domain, $paths, array $params = [])
    {
        if (is_array($paths) === false)
        {
            $paths = [$paths];
        }

        // remove leading slash
        $paths[0] = trim($paths[0], '/');

        // trim url and lets adopt protocol
        array_unshift($paths, '//' . CastAway::trimUrl($domain));

        return CastAway::pathsToUriString($paths, $params);
    }
}