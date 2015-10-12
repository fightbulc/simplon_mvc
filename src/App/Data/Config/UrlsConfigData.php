<?php

namespace Simplon\Mvc\App\Data\Config;

use Simplon\Mvc\Core\Data\Data;
use Simplon\Mvc\Core\Utils\CastAway;

/**
 * Class UrlsConfigData
 * @package Simplon\Mvc\App\Data\Config
 */
class UrlsConfigData extends Data
{
    /**
     * @var string
     */
    protected $backoffice;

    /**
     * @var string
     */
    protected $api;

    /**
     * @return string
     */
    public function getBackoffice()
    {
        return CastAway::trimUrl($this->backoffice);
    }

    /**
     * @param string $backoffice
     *
     * @return UrlsConfigData
     */
    public function setBackoffice($backoffice)
    {
        $this->backoffice = $backoffice;

        return $this;
    }

    /**
     * @return string
     */
    public function getApi()
    {
        return CastAway::trimUrl($this->api);
    }

    /**
     * @param string $api
     *
     * @return UrlsConfigData
     */
    public function setApi($api)
    {
        $this->api = $api;

        return $this;
    }
}