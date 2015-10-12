<?php

namespace Simplon\Mvc\Core\Utils;

use Simplon\Error\Exceptions\ServerException;

/**
 * Class Config
 * @package Simplon\Mvc\Core\Utils
 */
class Config
{
    /**
     * @var array
     */
    private $config;

    /**
     * @return array
     */
    public function getConfig()
    {
        return (array)$this->config;
    }

    /**
     * @param array $configCommon
     * @param array $configEnv
     *
     * @return Config
     */
    public function setConfig(array $configCommon, array $configEnv = [])
    {
        $this->config = array_replace_recursive($configCommon, $configEnv);

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