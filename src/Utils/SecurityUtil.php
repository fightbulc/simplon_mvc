<?php

namespace Simplon\Mvc\Utils;

/**
 * Class SecurityUtil
 * @package Simplon\Mvc\Utils
 */
class SecurityUtil
{
    /**
     * @param string $password
     * @param int $algo
     * @param array $options
     *
     * @return bool|string
     */
    public static function createPasswordHash($password, $algo = PASSWORD_BCRYPT, $options = [])
    {
        if (empty($options))
        {
            $options = [
                'cost' => 12,
            ];
        }

        return password_hash($password, $algo, $options);
    }

    /**
     * @param string $password
     * @param string $passwordHash
     *
     * @return bool
     */
    public static function verifyPasswordHash($password, $passwordHash)
    {
        return password_verify($password, $passwordHash);
    }

    /**
     * @param int $length
     * @param string $prefix
     * @param string $customCharacters
     *
     * @return string
     */
    public static function createRandomToken($length = 12, $prefix = null, $customCharacters = null)
    {
        $randomString = '';
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        // set custom characters
        if ($customCharacters !== null && empty($customCharacters) === false)
        {
            $characters = $customCharacters;
        }

        // handle prefix
        if ($prefix !== null)
        {
            $prefixLength = strlen($prefix);
            $length -= $prefixLength;

            if ($length < 0)
            {
                $length = 0;
            }
        }

        // generate token
        for ($i = 0; $i < $length; $i++)
        {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $prefix . $randomString;
    }

    /**
     * @param int $length
     *
     * @return string
     */
    public static function createSessionId($length = 36)
    {
        return self::createRandomToken($length);
    }
}