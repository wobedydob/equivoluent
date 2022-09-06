<?php

// TODO: fix error/exception handling.

namespace Query;

use Module\Database;

class QuerySelect
{

    private string $query;
    private array $arguments = [];

    public function __construct(string $query)
    {
        $this->query = $query;
        return $this;
    }

    /** Adds a WHERE or AND condition to the query */
    public function where(string $key, mixed $value): static
    {

        if (empty($this->arguments)) {
            array_push($this->arguments, 'WHERE', [$key, $value]);
        } else {
            array_push($this->arguments, 'AND', [$key, $value]);
        }

        return $this;
    }

    /** Adds an OR condition to the query. */
    public function orWhere(string $key, string $value): static
    {

        if(empty($this->arguments)){
            return $this->where($key, $value);
        }

        array_push($this->arguments, 'OR', [$key, $value]);

        return $this;

    }

    /** Executes the query and returns all found data. */
    public function all(): bool|array
    {
        $conditions = new QueryCondition($this->arguments);
        $this->query .= $conditions->query . ';';

        return Database::getInstance()->bindAndExecute($this->query, $conditions->values)->fetchAll(\PDO::FETCH_ASSOC);
    }

    /** Executes the query and returns the first found data. */
    public function first(): bool|array
    {
        $conditions = new QueryCondition($this->arguments);
        $this->query .= $conditions->query . ';';

        return Database::getInstance()->bindAndExecute($this->query, $conditions->values)->fetch(\PDO::FETCH_ASSOC);
    }

}