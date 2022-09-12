<?php

namespace Module;

use Model\User;

class Model
{

    private static string $table;

    private static function init()
    {
        $child = get_called_class();

        switch($child){
            case User::class:
                $model = new User();
                break;
            case self::class:
                // TODO: find better alternative for this error if necessary.
                throw new \Exception('Cannot use Model class without a child object');
            default:
                throw new \Exception('Unexpected Model "' . $child . '"');
        }

        self::$table = $model::TABLE_NAME;

    }

    /** Allows SELECT queries for User */
    public static function get(): \Query\QuerySelect
    {
        self::init();
        return Query::select(self::$table);
    }

    /** Allows INSERT queries for User */
    protected static function add(array $values): void
    {
        self::init();
        Query::insert(self::$table)->values($values);
    }

    protected static function edit(): \Query\QueryUpdate
    {
        self::init();
        return Query::update(self::$table);
    }

    protected static function remove(int $id): void
    {
        self::init();
        Query::delete(self::$table)->where('id', $id)->execute();
    }

}