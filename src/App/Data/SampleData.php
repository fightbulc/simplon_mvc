<?php

namespace Simplon\Mvc\App\Data;

use Simplon\Mvc\App\Storages\Models\AuthUsersModel;
use Simplon\Mvc\Core\Data\Data;

/**
 * Class SampleData
 * @package Simplon\Mvc\App\Data
 */
class SampleData extends Data
{
    /**
     * @var AuthUsersModel
     */
    protected $model;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $foo;

    /**
     * @return string
     */
    public function getFoo()
    {
        return $this->foo;
    }

    /**
     * @param string $foo
     *
     * @return SampleData
     */
    public function setFoo($foo)
    {
        $this->foo = $foo;

        return $this;
    }

    /**
     * @return AuthUsersModel
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param AuthUsersModel $model
     *
     * @return SampleData
     */
    public function setModel(AuthUsersModel $model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return SampleData
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }
}