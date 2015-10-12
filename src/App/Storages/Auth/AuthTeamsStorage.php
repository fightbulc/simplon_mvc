<?php

namespace Simplon\Mvc\App\Storages\Auth;

use Simplon\Mvc\App\Constants\SqlStorageConstants;
use Simplon\Mvc\App\Storages\Auth\Models\AuthTeamsModel;
use Simplon\Mvc\Core\Storages\SqlStorage;

/**
 * Class AuthTeamsStorage
 * @package Simplon\Mvc\App\Storages\Auth
 */
class AuthTeamsStorage extends SqlStorage
{
    /**
     * @return string
     */
    public function getTableName()
    {
        return SqlStorageConstants::AUTH_TEAMS;
    }

    /**
     * @return AuthTeamsModel
     */
    public function getModel()
    {
        return new AuthTeamsModel();
    }

    /**
     * @param AuthTeamsModel $model
     *
     * @return AuthTeamsModel
     */
    public function create(AuthTeamsModel $model)
    {
        return $this->crudCreate($model);
    }

    /**
     * @param array $conds
     *
     * @return null|AuthTeamsModel[]
     */
    public function read(array $conds)
    {
        return $this->crudRead($conds);
    }

    /**
     * @param array $conds
     *
     * @return null|AuthTeamsModel
     */
    public function readOne(array $conds)
    {
        return $this->crudReadOne($conds);
    }

    /**
     * @param AuthTeamsModel $model
     *
     * @return AuthTeamsModel
     */
    public function update(AuthTeamsModel $model)
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