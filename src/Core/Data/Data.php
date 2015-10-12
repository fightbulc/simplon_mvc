<?php

namespace Simplon\Mvc\Core\Data;

use Simplon\Mvc\Core\Interfaces\DataInterface;
use Simplon\Mvc\Core\Utils\SerializationTrait;

/**
 * Class Data
 * @package Simplon\Mvc\Core\Data
 */
abstract class Data implements DataInterface
{
    use SerializationTrait;
}