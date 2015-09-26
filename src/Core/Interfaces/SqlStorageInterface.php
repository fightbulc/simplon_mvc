<?php

namespace Simplon\Mvc\Core;

use Simplon\Mysql\Mysql;

/**
 * Interface SqlStorageInterface
 * @package Simplon\Mvc\Core
 */
interface SqlStorageInterface
{
    /**
     * SqlStorageInterface constructor.
     *
     * @param Mysql $connection
     */
    public function __construct(Mysql $connection);

    /**
     * @return string
     */
    public function getTableName();

    /**
     * @return ModelInterface
     */
    public function getModel();
}