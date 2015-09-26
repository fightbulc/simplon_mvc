<?php

namespace Simplon\Mvc\Core;

/**
 * Interface StorageInterface
 * @package Simplon\Mvc\Core
 */
interface StorageInterface
{
    /**
     * @param array $conds
     *
     * @return ModelInterface[]
     */
    public function read(array $conds);

    /**
     * @param ModelInterface $model
     *
     * @return ModelInterface
     */
    public function create(ModelInterface $model);

    /**
     * @param array $conds
     * @param ModelInterface $model
     *
     * @return ModelInterface
     */
    public function update(array $conds, ModelInterface $model);

    /**
     * @param array $conds
     * @param bool $validate
     *
     * @return bool
     */
    public function delete(array $conds, $validate = false);
}