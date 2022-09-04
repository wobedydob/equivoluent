<?php

namespace Builder;

class QueryCondition
{

    public string $query;
    public array $values = [];

    /** Build a condition query from attributes. */
    public function __construct($conditions)
    {
        // basic declarations
        $query = '';
        $values = [];

        foreach ($conditions as $key => $condition) if ($condition == 'WHERE' || $condition === 'AND' || $condition === 'OR') {

            // retrieves AND indexes

            // maps ID for query
            $id = $conditions[$key + 1][0];

            // maps PDO key for bindValue()
            $placeholder = ':' . $id . $key;

            // maps values indexed by placeholder with value of conditions after AND statement
            $values[$placeholder] = $conditions[$key + 1][1];

            // adds condition to PDO query
            $query .= ' ' . $condition . ' ' . '`' . $id . '`' . ' = ' . $placeholder;
        }

        // maps query
        $this->query = $query;

        // maps values for PDO bindValue()
        $this->values = $values;

    }

}