<?php

namespace Module;

use Query\QueryDelete;
use Query\QueryInsert;
use Query\QuerySelect;
use Query\QueryUpdate;

class Query
{

    private const SELECT = 'SELECT';
    private const INSERT = 'INSERT INTO';
    private const UPDATE = 'UPDATE';
    private const DELETE = 'DELETE FROM';

    /** Returns Query\QuerySelect and handles MySQL SELECT statement */
    public static function select(string $table, string $columns = '*'): bool|QuerySelect
    {
        return self::validate($table) ? new QuerySelect(self::SELECT . ' ' . $columns . ' FROM ' . $table) : false;
    }

    /** Returns Query\QueryInsert and handles MySQL INSERT statement */
    public static function insert(string $table): bool|QueryInsert
    {
        // TODO: row & value validation
        return self::validate($table) ? new QueryInsert(self::INSERT . ' ' . $table) : false;
    }

    /** Returns Query\QueryUpdate and handles MySQL UPDATE statement */
    public static function update(string $table): bool|QueryUpdate
    {
        return self::validate($table) ? new QueryUpdate(self::UPDATE . ' ' . $table) : false;
    }

    /** Returns Query\QueryDelete and handles MySQL DELETE statement */
    public static function delete(string $table): bool|QueryDelete
    {
        // TODO: record validation
        return self::validate($table) ? new QueryDelete(self::DELETE . ' ' . $table) : false;
    }

    // TODO: implement row & column validation

    /** Validates the table */
    private static function validate(string $table): bool
    {

        if (!Database::getInstance()->tableExists($table)) {
            throw new \Exception('Unexpected given table: "' . $table . '"');
        }

        return true;

    }

}