<?php

namespace Simplon\Mvc\App\Storages\Auth;

use Simplon\Mvc\App\Constants\SqlStorageConstants;
use Simplon\Mvc\App\Storages\Auth\Models\AuthUsersModel;
use Simplon\Mvc\Core\Storages\SqlStorage;

/**
 * Class AuthUsersStorage
 * @package Simplon\Mvc\App\Storages\Auth
 */
class AuthUsersStorage extends SqlStorage
{
    /**
     * @return string
     */
    public function getTableName()
    {
        return SqlStorageConstants::AUTH_USERS;
    }

    /**
     * @return AuthUsersModel
     */
    public function getModel()
    {
        return new AuthUsersModel();
    }

    /**
     * @param AuthUsersModel $model
     *
     * @return AuthUsersModel
     */
    public function create(AuthUsersModel $model)
    {
        return $this->crudCreate($model);
    }

    /**
     * @param array $conds
     *
     * @return null|AuthUsersModel[]
     */
    public function read(array $conds)
    {
        return $this->crudRead($conds);
    }

    /**
     * @param array $conds
     *
     * @return null|AuthUsersModel
     */
    public function readOne(array $conds)
    {
        return $this->crudReadOne($conds);
    }

    /**
     * @param AuthUsersModel $model
     *
     * @return AuthUsersModel
     */
    public function update(AuthUsersModel $model)
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