<?php

namespace Simplon\Mvc\App\Storages\Auth\Models;

use Simplon\Mvc\Core\Utils\CastAway;
use Simplon\Mysql\Crud\CrudModel;

/**
 * Class AuthUsersModel
 * @package Simplon\Mvc\App\Storages\Auth\Models
 */
class AuthUsersModel extends CrudModel
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $pubToken;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $createdAt;

    /**
     * @var int
     */
    protected $updatedAt;

    /**
     * @return int
     */
    public function getId()
    {
        return CastAway::toInt($this->id);
    }

    /**
     * @param int $id
     *
     * @return AuthUsersModel
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getPubToken()
    {
        return $this->pubToken;
    }

    /**
     * @param string $pubToken
     *
     * @return AuthUsersModel
     */
    public function setPubToken($pubToken)
    {
        $this->pubToken = $pubToken;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return AuthUsersModel
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return int
     */
    public function getCreatedAt()
    {
        return CastAway::toInt($this->createdAt);
    }

    /**
     * @param int $createdAt
     *
     * @return AuthUsersModel
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return int
     */
    public function getUpdatedAt()
    {
        return CastAway::toInt($this->updatedAt);
    }

    /**
     * @param int $updatedAt
     *
     * @return AuthUsersModel
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}