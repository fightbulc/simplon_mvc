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
}