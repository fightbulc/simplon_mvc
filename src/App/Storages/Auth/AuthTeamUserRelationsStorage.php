<?php

namespace Simplon\Mvc\App\Storages\Auth;

use Simplon\Mvc\App\Constants\SqlStorageConstants;
use Simplon\Mvc\App\Storages\Auth\Models\AuthTeamUserRelationsModel;
use Simplon\Mvc\Core\Storages\SqlStorage;

/**
 * Class AuthTeamUserRelationsStorage
 * @package Simplon\Mvc\App\Storages\Auth
 */
class AuthTeamUserRelationsStorage extends SqlStorage
{
    /**
     * @return string
     */
    public function getTableName()
    {
        return SqlStorageConstants::AUTH_TEAM_USER_RELATIONS;
    }

    /**
     * @return AuthTeamUserRelationsModel
     */
    public function getModel()
    {
        return new AuthTeamUserRelationsModel();
    }

    /**
     * @param AuthTeamUserRelationsModel $model
     *
     * @return AuthTeamUserRelationsModel
     */
    public function create(AuthTeamUserRelationsModel $model)
    {
        return $this->crudCreate($model);
    }

    /**
     * @param array $conds
     *
     * @return null|AuthTeamUserRelationsModel[]
     */
    public function read(array $conds)
    {
        return $this->crudRead($conds);
    }

    /**
     * @param array $conds
     *
     * @return null|AuthTeamUserRelationsModel
     */
    public function readOne(array $conds)
    {
        return $this->crudReadOne($conds);
    }

    /**
     * @param AuthTeamUserRelationsModel $model
     *
     * @return AuthTeamUserRelationsModel
     */
    public function update(AuthTeamUserRelationsModel $model)
    {
        return $this->crudUpdate($model);
    }

    /**
     * @param array $conds
     */
    public function delete(array $conds)
    {
        $this->crudDelete($conds);
    }
}