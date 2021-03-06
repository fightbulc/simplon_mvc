<?php

namespace Simplon\Mvc\Store;

use Simplon\Mysql\Crud\CrudManager;
use Simplon\Mysql\Crud\CrudModelInterface;
use Simplon\Mysql\Crud\CrudStoreInterface;
use Simplon\Mysql\Mysql;
use Simplon\Mysql\MysqlException;
use Simplon\Mysql\MysqlQueryIterator;
use Simplon\Mysql\QueryBuilder\CreateQueryBuilder;
use Simplon\Mysql\QueryBuilder\DeleteQueryBuilder;
use Simplon\Mysql\QueryBuilder\ReadQueryBuilder;
use Simplon\Mysql\QueryBuilder\UpdateQueryBuilder;

/**
 * Class SqlStore
 * @package Simplon\Mvc\Store
 */
abstract class SqlStore implements CrudStoreInterface
{
    /**
     * @var Mysql
     */
    private $mysql;

    /**
     * @var CrudManager
     */
    protected $crud;

    /**
     * @param Mysql $mysql
     * @param CrudManager $crudManager
     */
    public function __construct(Mysql $mysql, CrudManager $crudManager)
    {
        $this->crud = $crudManager;
        $this->mysql = $mysql;
    }

    /**
     * @param CrudModelInterface $model
     *
     * @return CrudModelInterface
     */
    public function crudCreate(CrudModelInterface $model)
    {
        return $this->getCrud()->create(
            (new CreateQueryBuilder())
                ->setModel($model)
                ->setTableName($this->getTableName())
        );
    }

    /**
     * @param array $conds
     * @param array $sorting
     *
     * @return null|CrudModelInterface[]
     */
    public function crudRead(array $conds = [], array $sorting = [])
    {
        $cursor = $this->getCrud()->read(
            (new ReadQueryBuilder())
                ->setFrom($this->getTableName())
                ->setConditions($conds)
                ->setSorting($sorting)
        );

        if ($cursor === null)
        {
            return null;
        }

        return $this->manyDataToModels($cursor);
    }

    /**
     * @param array $conds
     *
     * @return null|CrudModelInterface
     */
    public function crudReadOne(array $conds)
    {
        $data = $this->getCrud()->readOne(
            (new ReadQueryBuilder())
                ->setFrom($this->getTableName())
                ->setConditions($conds)
        );

        if ($data === null)
        {
            return null;
        }

        return $this->dataToModel($data);
    }

    /**
     * @param CrudModelInterface $model
     * @param array $conds
     *
     * @return CrudModelInterface
     */
    public function crudUpdate(CrudModelInterface $model, array $conds)
    {
        return $this->getCrud()->update(
            (new UpdateQueryBuilder())
                ->setModel($model)
                ->setTableName($this->getTableName())
                ->setConds($conds)
        );
    }

    /**
     * @param array $conds
     *
     * @throws MysqlException
     */
    public function crudDelete(array $conds)
    {
        $this->getCrud()->delete(
            (new DeleteQueryBuilder())
                ->setTableName($this->getTableName())
                ->setConds($conds)
        );
    }

    /**
     * @param array $data
     *
     * @return CrudModelInterface
     */
    protected function dataToModel(array $data)
    {
        return $this->getModel()->fromArray($data);
    }

    /**
     * @param MysqlQueryIterator $cursor
     *
     * @return CrudModelInterface[]
     */
    protected function manyDataToModels(MysqlQueryIterator $cursor)
    {
        $models = [];

        foreach ($cursor as $data)
        {
            $models[] = $this->getModel()->fromArray($data);
        }

        return $models;
    }

    /**
     * @return Mysql
     */
    protected function getMysql()
    {
        return $this->mysql;
    }

    /**
     * @return CrudManager
     */
    protected function getCrud()
    {
        return $this->crud;
    }
}