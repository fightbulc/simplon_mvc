<?php

namespace Simplon\Mvc\Utils;

use Simplon\Error\Exceptions\ServerException;

/**
 * Class Config
 * @package Simplon\Mvc\Utils
 */
class Config
{
    /**
     * @var array
     */
    private $config;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return (array)$this->config;
    }

    /**
     * @param array $config
     *
     * @return Config
     */
    public function merge(array $config)
    {
        $this->config = array_replace_recursive($this->config, $config);

        return $this;
    }

    /**
     * @param array $keys
     *
     * @return bool
     */
    public function hasConfigKeys(array $keys)
    {
        $config = $this->getConfig();

        while ($key = array_shift($keys))
        {
            if (isset($config[$key]) === false)
            {
                return false;
            }

            $config = $config[$key];
        }

        if (empty($config) === true)
        {
            return false;
        }

        return true;
    }

    /**
     * @param array $keys
     *
     * @return array|null
     * @throws ServerException
     */
    public function getConfigByKeys(array $keys)
    {
        $keysString = join(' => ', $keys);
        $config = self::getConfig();

        while ($key = array_shift($keys))
        {
            if (isset($config[$key]) === false)
            {
                throw (new ServerException())->internalError([
                    'reason' => 'Missing config key',
                    'key'    => $keysString,
                ]);
            }

            $config = $config[$key];
        }

        if (empty($config) === true)
        {
            return null;
        }

        return $config;
    }

}