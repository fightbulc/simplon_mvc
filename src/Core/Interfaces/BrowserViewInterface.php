<?php

namespace Simplon\Mvc\Core;

/**
 * Interface BrowserViewInterface
 * @package Simplon\Mvc\Core
 */
interface BrowserViewInterface
{
    /**
     * @param DataResponseInterface $data
     */
    public function __construct(DataResponseInterface $data = null);

    /**
     * @return BrowserViewInterface
     */
    public function build();

    /**
     * @return DataResponseInterface
     */
    public function getDataRespones();

    /**
     * @return string
     */
    public function getContent();
}