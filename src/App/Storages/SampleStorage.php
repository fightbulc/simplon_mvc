<?php

namespace Simplon\Mvc\App\Storages;

use Simplon\Mvc\App\Constants\SqlStorageConstants;
use Simplon\Mvc\App\Models\SampleModel;
use Simplon\Mvc\Core\Storages\SqlStorage;

/**
 * Class SampleStorage
 * @package Simplon\Mvc\App\Storages
 */
class SampleStorage extends SqlStorage
{
    /**
     * @return string
     */
    public function getTableName()
    {
        return SqlStorageConstants::TABLE_SAMPLE;
    }

    /**
     * @return SampleModel
     */
    public function getModel()
    {
        return new SampleModel();
    }

    /**
     * @param array $conds
     *
     * @return null|SampleModel[]
     */
    public function read(array $conds)
    {
        $query = $this
            ->getQueryBuilder()
            ->setConditions($conds);

        $result = $this
            ->getManager()
            ->fetchRowMany($query);

        if ($result === false)
        {
            return null;
        }

        /** @var SampleModel[] $models */
        $models = $this->manyDataToModels($result);

        return $models;
    }
}