<?php

namespace Simplon\Mvc\App\Storages\Auth\Models;

use Simplon\Mvc\Core\Utils\CastAway;
use Simplon\Mysql\Crud\CrudModel;

/**
 * Class AuthTeamUserRelationsModel
 * @package Simplon\Mvc\App\Storages\Auth\Models
 */
class AuthTeamUserRelationsModel extends CrudModel
{
    /**
     * @var int
     */
    protected $teamId;

    /**
     * @var int
     */
    protected $userId;

    /**
     * @var string
     */
    protected $role;

    /**
     * @var int
     */
    protected $isAccessible;

    /**
     * @var int
     */
    protected $isSelected;

    /**
     * @return int
     */
    public function getTeamId()
    {
        return CastAway::toInt($this->teamId);
    }

    /**
     * @param int $teamId
     *
     * @return AuthTeamUserRelationsModel
     */
    public function setTeamId($teamId)
    {
        $this->teamId = $teamId;

        return $this;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     *
     * @return AuthTeamUserRelationsModel
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param string $role
     *
     * @return AuthTeamUserRelationsModel
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return bool
     */
    public function isAccessible()
    {
        return CastAway::intToBool($this->isAccessible);
    }

    /**
     * @return int
     */
    public function getIsAccessible()
    {
        return CastAway::toInt($this->isAccessible);
    }

    /**
     * @param int $isAccessible
     *
     * @return AuthTeamUserRelationsModel
     */
    public function setIsAccessible($isAccessible)
    {
        $this->isAccessible = $isAccessible;

        return $this;
    }

    /**
     * @return bool
     */
    public function isSelected()
    {
        return CastAway::intToBool($this->isSelected);
    }

    /**
     * @return int
     */
    public function getIsSelected()
    {
        return CastAway::toInt($this->isSelected);
    }

    /**
     * @param int $isSelected
     *
     * @return AuthTeamUserRelationsModel
     */
    public function setIsSelected($isSelected)
    {
        $this->isSelected = $isSelected;

        return $this;
    }
}