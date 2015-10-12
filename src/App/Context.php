<?php

namespace Simplon\Mvc\App;

use Simplon\Error\Exceptions\ServerException;
use Simplon\Locale\Locale;
use Simplon\Mvc\App\Storages\Auth\AuthUsersStorage;
use Simplon\Mvc\Core\Storages\SessionStorage;
use Simplon\Mvc\Core\Utils\Config;
use Simplon\Mvc\Mvc;
use Simplon\Mysql\Crud\CrudManager;
use Simplon\Mysql\Mysql;
use Simplon\Request\Request;

/**
 * Class Context
 * @package Simplon\Mvc\App
 */
abstract class Context
{
    /**
     * @var Mvc
     */
    private $mvc;

    /**
     * @param Mvc $mvc
     */
    public function __construct(Mvc $mvc)
    {
        $this->mvc = $mvc;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->getMvc()->getRequest();
    }

    /**
     * @return Locale
     */
    public function getLocale()
    {
        return $this->getMvc()->getLocale();
    }

    /**
     * @return Mysql
     * @throws ServerException
     */
    public function getMysql()
    {
        $config = $this->getConfig()->getConfigByKeys(
            ['databases', 'mysql', 'localhost']
        );

        return new Mysql(
            $config['host'],
            $config['user'],
            $config['password'],
            $config['dbname']
        );
    }

    /**
     * @return SessionStorage
     */
    public function getSessionStorage()
    {
        return new SessionStorage();
    }

    /**
     * @return CrudManager
     */
    public function getCrudManager()
    {
        return new CrudManager($this->getMysql());
    }

    /**
     * @return AuthUsersStorage
     */
    public function getAuthUsersStorage()
    {
        return new AuthUsersStorage($this->getCrudManager());
    }

    /**
     * @return Mvc
     */
    private function getMvc()
    {
        return $this->mvc;
    }

    /**
     * @return Config
     */
    private function getConfig()
    {
        return $this->getMvc()->getConfig();
    }
}