<?php

namespace Query;

use Module\Database;

class QueryInsert
{

    private string $query;
    private array $values;

    public function __construct(string $query)
    {
        $this->query = $query;
        return $this;
    }

    /** Adds the VALUES condition to the query. */
    public function values(array $values): void
    {
        // TODO: implement value column validation.
        $arguments = $values;

        // makes two halves of the query
        $this->query .= '(';
        $values = ' VALUES(';

        // is added to the PDO key to prevent duplicate ID's.
        $count = 0;

        foreach ($arguments as $key => $value) {

            // maps the named PDO variable
            $pdoKey = ':' . $key . $count;

            // adds to key to query
            $this->query .= $key;

            // adds PDO key to the VALUES query
            $values .= $pdoKey;

            // maps PDO variables and values
            $this->values[$pdoKey] = $value;

            // stop loop when value is the last item
            if ($key === array_key_last($arguments)) {
                continue;
            }

            $this->query .= ', ';
            $values .= ', ';

            $count++;

        }

        $this->query .= ')';
        $values .= ')';

        $this->query .= $values . ';';

        $this->execute();

    }

    /** Executes the PDO query. */
    private function execute(): bool
    {

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