<?php

namespace Simplon\Mvc\Storages;

use Simplon\Mvc\Utils\CastAway;

/**
 * Class TimeAwareTrait
 * @package Simplon\Mvc\Storages
 */
trait TimeAwareTrait
{
    /**
     * @var int
     */
    protected $createdAt;

    /**
     * @var int
     */
    protected $updatedAt;

    /**
     * @return static
     */
    public function beforeSave()
    {
        $this->setCreatedAt(time())->setUpdatedAt(time());

        return $this;
    }

    /**
     * @return static
     */
    public function beforeUpdate()
    {
        $this->setUpdatedAt(time());

        return $this;
    }

    /**
     * @return int
     */
    public function getCreatedAt()
    {
        return CastAway::toInt($this->createdAt);
    }

    /**
     * @param int $createdAt
     *
     * @return static
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return int
     */
    public function getUpdatedAt()
    {
        return CastAway::toInt($this->updatedAt);
    }

    /**
     * @param int $updatedAt
     *
     * @return static
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}