<?php

namespace Module;

use Builder\QueryCondition;

class Model
{

    private string $query;
    private array $arguments = [];
    private array $values = [];

    /** Initializes new Module/Model() instance and validates given Model type. */
    private static function init(): Model
    {

        // initialize Mappers
        $modelMapper = new ModelMapper();
        $queryMapper = new Query();

        // map Model
        $model = $modelMapper->map(get_called_class());

        // initialize new Model and map child to $model
        $module = new self;
        $module->query = $queryMapper->validateQueryType($model::QUERY_TYPE) . ' ' . $model::TABLE_NAME;

        return $module;

    }

    /** Executes a blank query based on called Model query. */
    public static function all(): bool|array
    {

        // initialize
        $module = self::init();

        return Database::getInstance()->bindAndExecute($module->query)->fetchAll();

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

}