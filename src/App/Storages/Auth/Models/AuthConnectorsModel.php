<?php

namespace Simplon\Mvc\App\Storages\Auth\Models;

use Simplon\Mvc\Core\Utils\CastAway;
use Simplon\Mysql\Crud\CrudModel;

/**
 * Class AuthConnectorsModel
 * @package Simplon\Mvc\App\Storages\Auth\Models
 */
class AuthConnectorsModel extends CrudModel
{
    /**
     * @var int
     */
    protected $userId;

    /**
     * @var string
     */
    protected $connName;

    /**
     * @var string
     */
    protected $connKey;

    /**
     * @var string
     */
    protected $connValueJson;

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
    public function getUserId()
    {
        return CastAway::toInt($this->userId);
    }

    /**
     * @param int $userId
     *
     * @return AuthConnectorsModel
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @return string
     */
    public function getConnName()
    {
        return $this->connName;
    }

    /**
     * @param string $connName
     *
     * @return AuthConnectorsModel
     */
    public function setConnName($connName)
    {
        $this->connName = $connName;

        return $this;
    }

    /**
     * @return string
     */
    public function getConnKey()
    {
        return $this->connKey;
    }

    /**
     * @param string $connKey
     *
     * @return AuthConnectorsModel
     */
    public function setConnKey($connKey)
    {
        $this->connKey = $connKey;

        return $this;
    }

    /**
     * @return array
     */
    public function getConnValueArray()
    {
        return CastAway::jsonToArray($this->connValueJson);
    }

    /**
     * @param array $data
     *
     * @return AuthConnectorsModel
     */
    public function setConnValueArray(array $data)
    {
        return $this->setConnValueJson(
            CastAway::arrayToJson($data)
        );
    }

    /**
     * @return string
     */
    public function getConnValueJson()
    {
        return $this->connValueJson;
    }

    /**
     * @param string $connValueJson
     *
     * @return AuthConnectorsModel
     */
    public function setConnValueJson($connValueJson)
    {
        $this->connValueJson = $connValueJson;

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
     * @return AuthConnectorsModel
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
     * @return AuthConnectorsModel
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}