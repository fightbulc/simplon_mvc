<?php

namespace Simplon\Mvc\App\Data\Config;

use Simplon\Mvc\Core\Data\Data;
use Simplon\Mvc\Core\Utils\CastAway;

/**
 * Class PathsConfigData
 * @package Simplon\Mvc\App\Data\Config
 */
class PathsConfigData extends Data
{
    /**
     * @var string
     */
    protected $src;

    /**
     * @var string
     */
    protected $public;

    /**
     * @return string
     */
    public function getSrc()
    {
        return CastAway::trimPath($this->src);
    }

    /**
     * @param string $src
     *
     * @return PathsConfigData
     */
    public function setSrc($src)
    {
        $this->src = $src;

        return $this;
    }

    /**
     * @return string
     */
    public function getPublic()
    {
        return CastAway::trimPath($this->public);
    }

    /**
     * @param string $public
     *
     * @return PathsConfigData
     */
    public function setPublic($public)
    {
        $this->public = $public;

        return $this;
    }
}