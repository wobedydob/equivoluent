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
    public static function select(string $table): bool|QuerySelect
    {
        self::validateTable($table);
        return new QuerySelect(self::SELECT . ' *  FROM ' . $table);
    }

    /** Returns Query\QueryInsert and handles MySQL INSERT statement */
    public static function insert(string $table): bool|QueryInsert
    {
        self::validateTable($table);
        return new QueryInsert(self::INSERT . ' ' . $table);
    }

    /** Returns Query\QueryUpdate and handles MySQL UPDATE statement */
    public static function update(string $table): bool|QueryUpdate
    {
        self::validateTable($table);
        return new QueryUpdate(self::UPDATE . ' ' . $table);
    }

    /** Returns Query\QueryDelete and handles MySQL DELETE statement */
    public static function delete(string $table): bool|QueryDelete
    {
        self::validateTable($table);
        return new QueryDelete(self::DELETE . ' ' . $table);
    }

    /** Validates the table */
    private static function validateTable(string $table): void
    {
        // Throws an InvalidTableException when table cannot be found.
        Database::getInstance()->tableExists($table);

    }

}