<?php

namespace Simplon\Mvc\Store;

use Simplon\Mvc\Utils\SecurityUtil;
use Simplon\Mysql\Crud\CrudStoreInterface;

class StoreHelper
{
    /**
     * @param CrudStoreInterface $storage
     * @param int $length
     * @param string $prefix
     *
     * @return string
     */
    public static function getUniquePubToken(CrudStoreInterface $storage, $length = 12, $prefix = null)
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

    /**
     * @param CrudStoreInterface $storage
     *
     * @return string
     */
    public static function getUniqueInviteToken(CrudStoreInterface $storage)
    {
        $token = null;
        $isUnique = false;

        while ($isUnique === false)
        {
            $token = SecurityUtil::createRandomToken(6);
            $isUnique = $storage->crudReadOne(['invite_token' => $token]) === null;
        }

        return $token;
    }
}