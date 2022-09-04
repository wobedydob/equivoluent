<?php

namespace Module;

class Query
{

    private const SELECT = 'SELECT * FROM';
    private const INSERT = 'INSERT INTO';

    /** Validates query type */
    public function validateQueryType(string $query)
    {

        return match ($query) {
            'select' => self::SELECT,
            'insert' => self::INSERT,
            default => throw new \Exception('Invalid query type given:' . $query),
        };

    }

}