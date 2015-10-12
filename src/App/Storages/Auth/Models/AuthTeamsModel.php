<?php

namespace Simplon\Mvc\App\Storages\Auth\Models;

use Simplon\Mvc\Core\Utils\CastAway;
use Simplon\Mysql\Crud\CrudModel;

/**
 * Class AuthTeamsModel
 * @package Simplon\Mvc\App\Storages\Auth\Models
 */
class AuthTeamsModel extends CrudModel
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
    protected $groupToken;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $constraintsJson;

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
     * @return AuthTeamsModel
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
     * @return AuthTeamsModel
     */
    public function setPubToken($pubToken)
    {
        $this->pubToken = $pubToken;

        return $this;
    }

    /**
     * @return string
     */
    public function getGroupToken()
    {
        return $this->groupToken;
    }

    /**
     * @param string $groupToken
     *
     * @return AuthTeamsModel
     */
    public function setGroupToken($groupToken)
    {
        $this->groupToken = $groupToken;

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
     * @return AuthTeamsModel
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return array
     */
    public function getConstraintsArray()
    {
        return CastAway::jsonToArray($this->constraintsJson);
    }

    /**
     * @param array $data
     *
     * @return AuthTeamsModel
     */
    public function setConstraintsArray(array $data)
    {
        return $this->setConstraintsJson(
            CastAway::arrayToJson($data)
        );
    }

    /**
     * @return string
     */
    public function getConstraintsJson()
    {
        return $this->constraintsJson;
    }

    /**
     * @param string $constraintsJson
     *
     * @return AuthTeamsModel
     */
    public function setConstraintsJson($constraintsJson)
    {
        $this->constraintsJson = $constraintsJson;

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