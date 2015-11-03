<?php

namespace Simplon\Mvc\Utils;

/**
 * Class CastAway
 * @package Simplon\Mvc\Utils
 */
class CastAway
{
    /**
     * @param mixed $val
     *
     * @return int|null
     */
    public static function toInt($val)
    {
        return $val !== null ? (int)trim($val) : null;
    }

    /**
     * @param mixed $val
     *
     * @return null|string
     */
    public static function toString($val)
    {
        return $val !== null ? (string)trim($val) : null;
    }

    /**
     * @param mixed $val
     *
     * @return bool|null
     */
    public static function toBool($val)
    {
        return $val !== null ? $val === true : null;
    }

    /**
     * @param mixed $val
     *
     * @return float|null
     */
    public static function toFloat($val)
    {
        return $val !== null ? (float)trim($val) : null;
    }

    /**
     * @param mixed $val
     *
     * @return array|null
     */
    public static function toArray($val)
    {
        return $val !== null ? (array)$val : null;
    }

    /**
     * @param mixed $val
     *
     * @return null|object
     */
    public static function toObject($val)
    {
        return $val !== null ? (object)$val : null;
    }

    /**
     * @param mixed $val
     * @param \DateTimeZone $dateTimeZone
     *
     * @return \DateTime|null
     */
    public static function toDateTime($val, \DateTimeZone $dateTimeZone = null)
    {
        return $val !== null ? new \DateTime(trim($val), $dateTimeZone) : null;
    }

    /**
     * @param string $json
     *
     * @return array
     */
    public static function jsonToArray($json)
    {
        return json_decode($json, true);
    }

    /**
     * @param array $data
     *
     * @return string
     */
    public static function arrayToJson(array $data)
    {
        return json_encode($data);
    }

    /**
     * @param int $int
     *
     * @return bool
     */
    public static function intToBool($int)
    {
        return $int === 1 ? true : false;
    }

    /**
     * @param bool $bool
     *
     * @return int
     */
    public static function boolToInt($bool)
    {
        return $bool === true ? 1 : 0;
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public static function trimPath($path)
    {
        return rtrim($path, '/');
    }

    /**
     * @param string $url
     *
     * @return string
     */
    public static function trimUrl($url)
    {
        return rtrim($url, '/');
    }

    /**
     * @param array $paths
     * @param array $params
     *
     * @return string
     */
    public static function pathsToUriString(array $paths, array $params = [])
    {
        $uri = [];

        foreach ($paths as $path)
        {
            $uri[] = self::trimPath($path);
        }

        return self::renderPlaceholders(join('/', $uri), $params);
    }

    /**
     * @param string $string
     * @param array $placeholders
     * @param string $enclosed
     *
     * @return string
     */
    public static function renderPlaceholders($string, array $placeholders, $enclosed = '{}')
    {
        $left = '\\' . substr($enclosed, 0, 1);
        $right = '\\' . substr($enclosed, 1);

        foreach ($placeholders as $key => $val)
        {
            $string = preg_replace('/' . $left . $key . $right . '/i', $val, $string);
        }

        return $string;
    }

    /**
     * @param int $int
     *
     * @return string
     * @throws \Exception
     */
    public static function intToColumnWord($int)
    {
        $word = null;

        switch ($int)
        {
            case 1:
                $word = 'one';
                break;

            case 2:
                $word = 'two';
                break;

            case 3:
                $word = 'three';
                break;

            case 4:
                $word = 'four';
                break;

            case 5:
                $word = 'five';
                break;

            case 6:
                $word = 'six';
                break;

            case 7:
                $word = 'seven';
                break;

            case 8:
                $word = 'eight';
                break;

            case 9:
                $word = 'nine';
                break;

            case 10:
                $word = 'ten';
                break;

            case 11:
                $word = 'eleven';
                break;

            case 12:
                $word = 'twelve';
                break;

            case 13:
                $word = 'thirteen';
                break;

            case 14:
                $word = 'fourteen';
                break;

            case 15:
                $word = 'fifthteen';
                break;

            case 16:
                $word = 'sixthteen';
                break;

            default:
                throw new \Exception('Integer is greater than possible column count');
        }

        return $word;
    }
}