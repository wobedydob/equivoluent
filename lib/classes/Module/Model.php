<?php

namespace Module;

use Builder\QueryCondition;

class Model
{

    private string $query;
    private array $arguments = [];
    private array $values = [];

    /** Initializes new Module/Model() instance and validates given Model type. */
    private static function init(?string $queryType = null): Model
    {

        // initialize Mappers
        $modelMapper = new ModelMapper();
        $queryMapper = new Query();

        // map Model
        $model = $modelMapper->map(get_called_class());

        // initialize new Model and map child to $model
        $module = new self;

        // determine query type
        $type = $model::QUERY_TYPE;
        if ($queryType) {
            $type = $queryType;
        }

        $module->query = $queryMapper->validateQueryType($type) . ' ' . $model::TABLE_NAME;

        return $module;

    }

    // region SELECT

    /** Executes a blank query based on called Model query. */
    public static function all(): bool|array
    {

        // initialize
        $module = self::init();

        return Database::getInstance()->bindAndExecute($module->query . ';')->fetchAll();

    }

    /** Adds a WHERE condition to the query */
    public static function where(string $key, mixed $value): Model
    {

        // initialize
        $module = self::init();

        // add where argument
        if (empty($module->arguments)) {
            array_push($module->arguments, 'WHERE', [$key, $value]);
        }

        return $module;

    }

    /** Adds an AND condition to the query. */
    public function andWhere(string $key, string $value): static
    {

        array_push($this->arguments, 'AND', [$key, $value]);

        return $this;

    }

    /** Adds an OR condition to the query. */
    public function orWhere(string $key, string $value): static
    {

        array_push($this->arguments, 'OR', [$key, $value]);

        return $this;

    }

    /** Executes query and fetches all found data. */
    public function get(): bool|array
    {

        $conditions = new QueryCondition($this->arguments);
        $this->query .= $conditions->query . ';';
        $this->values = $conditions->values;

        // TODO: map to proper Model instance

        return Database::getInstance()->bindAndExecute($this->query, $this->values)->fetchAll(\PDO::FETCH_ASSOC);

    }

    /** Executes query and fetches the first found data.  */
    public function first(): bool|array
    {

        $conditions = new QueryCondition($this->arguments);
        $this->query .= $conditions->query . ';';
        $this->values = $conditions->values;

        // TODO: map to proper Model instance

        return Database::getInstance()->bindAndExecute($this->query, $this->values)->fetch(\PDO::FETCH_ASSOC);

    }

    // endregion

    // region INSERT

    /** Executes an INSERT query. */
    protected static function add(array $data): bool
    {

        $module = self::init('insert');

        $insert = $module->query . '(';
        $values = ' VALUES(';

        $pdoValues = [];

        $count = 0;

        foreach ($data as $key => $value) {

            $pdoKey = ':' . $key . $count;

            $insert .= $key;
            $values .= $pdoKey;

            $pdoValues[$pdoKey] = $value;

            if ($key === array_key_last($data)) {
                continue;
            }

            $insert .= ', ';
            $values .= ', ';

            $count++;

        }

        $insert .= ')';
        $values .= ')';

        $query = $insert . $values . ';';

        try {
            Database::getInstance()->bindAndExecute($query, $pdoValues);
            return true;
        } catch (\PDOException $exception) {

            // TODO: implement ERROR/EXCEPTION handler.

            return false;
        }

    }

    // endregion

}