<?php

namespace Simplon\Mvc\Interfaces;

use Simplon\Form\FormBlock;
use Simplon\Form\FormView;

/**
 * Interface BrowserFormViewInterface
 * @package Simplon\Mvc\Interfaces
 */
interface BrowserFormViewInterface
{
    /**
     * @return FormView
     */
    public function build();

    /**
     * @return FormBlock[]
     */
    public function getBlocks();
}