<?php

namespace Simplon\Mvc\Storages;

use Simplon\Mvc\Utils\SecurityUtil;
use Simplon\Mysql\Crud\CrudStorageInterface;

class StorageHelper
{
    /**
     * @param CrudStorageInterface $storage
     * @param int $length
     * @param string $prefix
     *
     * @return string
     */
    public static function getUniquePubToken(CrudStorageInterface $storage, $length = 12, $prefix = null)
    {
        $token = null;
        $isUnique = false;
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        while ($isUnique === false)
        {
            $token = SecurityUtil::createRandomToken($length, $prefix, $characters);
            $isUnique = $storage->crudReadOne(['pub_token' => $token]) === null;
        }

        return $token;
    }
}