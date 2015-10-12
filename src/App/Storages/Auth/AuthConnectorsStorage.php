<?php

namespace Simplon\Mvc\App\Storages\Auth;

use Simplon\Mvc\App\Constants\SqlStorageConstants;
use Simplon\Mvc\App\Storages\Auth\Models\AuthConnectorsModel;
use Simplon\Mvc\Core\Storages\SqlStorage;

/**
 * Class AuthConnectorsStorage
 * @package Simplon\Mvc\App\Storages\Auth
 */
class AuthConnectorsStorage extends SqlStorage
{
    /**
     * @return string
     */
    public function getTableName()
    {
        return SqlStorageConstants::AUTH_TEAMS;
    }

    /**
     * @return AuthConnectorsModel
     */
    public function getModel()
    {
        return new AuthConnectorsModel();
    }

    /**
     * @param AuthConnectorsModel $model
     *
     * @return AuthConnectorsModel
     */
    public function create(AuthConnectorsModel $model)
    {
        return $this->crudCreate($model);
    }

    /**
     * @param array $conds
     *
     * @return null|AuthConnectorsModel[]
     */
    public function read(array $conds)
    {
        return $this->crudRead($conds);
    }

    /**
     * @param array $conds
     *
     * @return null|AuthConnectorsModel
     */
    public function readOne(array $conds)
    {
        return $this->crudReadOne($conds);
    }

    /**
     * @param AuthConnectorsModel $model
     *
     * @return AuthConnectorsModel
     */
    public function update(AuthConnectorsModel $model)
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