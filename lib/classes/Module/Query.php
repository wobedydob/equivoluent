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
    public static function select(string $table, string $columns = '*'): QuerySelect
    {
        // TODO: table & column validation
        return new QuerySelect(self::SELECT . ' ' . $columns . ' FROM ' . $table);
    }

    /** Returns Query\QueryInsert and handles MySQL INSERT statement */
    public static function insert(string $table): QueryInsert
    {
        // TODO: table & column validation
        // TODO: row & value validation
        return new QueryInsert(self::INSERT . ' ' . $table);
    }

    /** Returns Query\QueryUpdate and handles MySQL UPDATE statement */
    public static function update(string $table): QueryUpdate
    {
        // TODO: table & column validation
        return new QueryUpdate(self::UPDATE . ' ' . $table);
    }

    // TODO: implement sql DELETE functionality
    /** Returns Query\QueryDelete and handles MySQL DELETE statement */
    public static function delete(string $table): QueryDelete
    {
        // TODO: record validation
        return new QueryDelete(self::DELETE . ' ' . $table);
    }

}