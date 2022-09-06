<?php

namespace Query;

use Module\Database;

class QueryUpdate
{

    private string $query;
    private array $arguments = [];
    private array $values = [];

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
    public function orWhere(string $key, mixed $value): static
    {

        if (empty($this->arguments)) {
            return $this->where($key, $value);
        }

        array_push($this->arguments, 'OR', [$key, $value]);

        return $this;

    }

    /** Adds the SET values to the query. */
    public function set(array $values): void
    {

        $this->query .= ' SET ';

        // TODO: implement value column validation.

        // is added to the PDO key to prevent duplicate ID's.
        $count = 0;
        foreach ($values as $key => $value) {

            $pdoKey = ':' . $count . $key;
            $this->values[$pdoKey] = $value;

            $this->query .= $key . ' = ' . $pdoKey;

            if ($key === array_key_last($values)) {
                continue;
            }

            $this->query .= ', ';
            $count++;
        }

        $this->execute();

    }

    /** Executes the PDO query. */
    private function execute(): bool
    {

        $conditions = new QueryCondition($this->arguments);
        $this->query .= $conditions->query . ';';

        $this->values = array_merge($this->values, $conditions->values);

        try {
            // TODO: add success message.
            Database::getInstance()->bindAndExecute($this->query, $this->values);
            $result = true;
        } catch (\PDOException $exception) {
            // TODO: implement ERROR/EXCEPTION handler.
            $result = false;
        }

        return $result;

    }

}























