<?php

namespace Module;

class Query
{

    private const SELECT = 'SELECT * FROM';

    /** Validates query type */
    public function validateQueryType(string $query)
    {

        return match ($query) {
            'select' => self::SELECT,
            default => throw new \Exception('Invalid query type given:' . $query),
        };

    }

}