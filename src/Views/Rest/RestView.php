<?php

namespace Simplon\Mvc\Views\Rest;

use Simplon\Locale\Locale;
use Simplon\Mvc\Interfaces\RestViewInterface;

/**
 * Class RestView
 * @package Simplon\Mvc\Views\Rest
 */
abstract class RestView implements RestViewInterface
{
    /**
     * @var Locale
     */
    private $locale;

    /**
     * @var array
     */
    protected $result = [];

    /**
     * @return Locale
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @return string
     */
    public function getLocaleCode()
    {
        return $this->locale->getCurrentLocale();
    }

    /**
     * @param Locale $locale
     *
     * @return RestViewInterface
     */
    public function setLocale(Locale $locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * @return array
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param array $result
     *
     * @return static
     */
    protected function setResult(array $result)
    {
        $this->result = $result;

        return $this;
    }
}