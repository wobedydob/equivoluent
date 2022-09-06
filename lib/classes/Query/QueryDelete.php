<?php

namespace Query;

use Exception;
use Module\Database;

class QueryDelete
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

        if (empty($this->arguments)) {
            return $this->where($key, $value);
        }

        array_push($this->arguments, 'OR', [$key, $value]);

        return $this;

    }

    /** Executes the PDO query. */
    public function execute(): bool
    {

        // Throws exception when arguments array is empty
        if (empty($this->arguments)) {
            throw new Exception('Query can\'t be executed without conditions');
        }

        $conditions = new QueryCondition($this->arguments);
        $this->query .= $conditions->query . ';';

        try {
            // TODO: add success message.
            Database::getInstance()->bindAndExecute($this->query, $conditions->values);
            $result = true;
        } catch (\PDOException $exception) {
            // TODO: implement ERROR/EXCEPTION handler.
            $result = false;
        }

        return $result;

    }


}