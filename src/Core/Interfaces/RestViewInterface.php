<?php

namespace Simplon\Mvc\Core;

/**
 * Interface RestViewInterface
 * @package Simplon\Mvc\Core
 */
interface RestViewInterface
{
    /**
     * @param DataResponseInterface $data
     */
    public function __construct(DataResponseInterface $data);

    /**
     * @return string
     */
    public function getContent();
}