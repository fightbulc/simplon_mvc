<?php

namespace Simplon\Mvc\Core\Storages;

use Simplon\Mvc\Core\ModelInterface;
use Simplon\Mvc\Core\SqlStorageInterface;
use Simplon\Mysql\Manager\SqlManager;
use Simplon\Mysql\Manager\SqlQueryBuilder;
use Simplon\Mysql\Mysql;

/**
 * Class SqlStorage
 * @package Simplon\Mvc\Core\Storages
 */
abstract class SqlStorage implements SqlStorageInterface
{
    /**
     * @var Mysql
     */
    private $connection;

    /**
     * @var SqlManager
     */
    private $sqlManager;

    /**
     * @param Mysql $connection
     */
    public function __construct(Mysql $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return Mysql
     */
    protected function getConnection()
    {
        return $this->connection;
    }

    /**
     * @return SqlManager
     */
    protected function getManager()
    {
        if ($this->sqlManager === null)
        {
            $this->sqlManager = new SqlManager($this->getConnection());
        }

        return $this->sqlManager;
    }

    /**
     * @return SqlQueryBuilder
     */
    protected function getQueryBuilder()
    {
        return (new SqlQueryBuilder())->setTableName($this->getTableName());
    }

    /**
     * @param array $data
     *
     * @return ModelInterface
     */
    protected function dataToModel(array $data)
    {
        $model = $this->manyDataToModels([$data]);

        return array_shift($model);
    }

    /**
     * @param array $manyData
     *
     * @return ModelInterface[]
     */
    protected function manyDataToModels(array $manyData)
    {
        $models = [];

        foreach ($manyData as $data)
        {
            $model = clone $this->getModel();
            $models[] = $model->fromArray($data);
        }

        return $models;
    }

    /**
     * @param bool $snakeCase
     *
     * @return array
     */
    protected function modelToArray($snakeCase = true)
    {
        return $this->getModel()->toArray($snakeCase);
    }
}