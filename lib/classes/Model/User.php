<?php

namespace Model;

use Module\Model;

class User extends Model
{

    public const TABLE_NAME = 'users';
    public const QUERY_TYPE = 'select';

    /** Allows insert query */
    public static function add(array $data): bool
    {
        return parent::add($data);
    }

}