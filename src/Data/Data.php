<?php

namespace Simplon\Mvc\Data;

use Simplon\Mvc\Interfaces\DataInterface;
use Simplon\Mvc\Utils\SerializationTrait;

/**
 * Class Data
 * @package Simplon\Mvc\Data
 */
abstract class Data implements DataInterface
{
    use SerializationTrait;

    /**
     * @var bool
     */
    protected $isProcessed;

    /**
     * @return boolean
     */
    public function isProcessed()
    {
        return $this->isProcessed;
    }

    /**
     * @param boolean $isProcessed
     *
     * @return static
     */
    public function setIsProcessed($isProcessed)
    {
        $this->isProcessed = $isProcessed === true;

        return $this;
    }
}