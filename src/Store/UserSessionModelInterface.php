<?php

namespace Simplon\Mvc\Store;

/**
 * Interface UserSessionModelInterface
 * @package Store
 */
interface UserSessionModelInterface
{
    /**
     * @return string
     */
    public function getSessionId();

    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getPubToken();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @return string
     */
    public function getRole();

    /**
     * @return int
     */
    public function getRolePrio();

}