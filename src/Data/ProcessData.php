<?php

namespace Simplon\Mvc\Data;

use Simplon\Mvc\Interfaces\ProcessDataInterface;

/**
 * Class ProcessData
 * @package Simplon\Mvc\Data
 */
abstract class ProcessData extends Data implements ProcessDataInterface
{
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