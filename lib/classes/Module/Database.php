<?php

namespace Module;

use Exceptions\InvalidTableException;
use PDO;
use PDOStatement;

class Database
{
    protected static ?Database $instance = null;
    protected PDO $pdo;

    private PDOStatement $statement;

    public function __construct()
    {

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHAR;
        $this->pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD, $options);

    }

    /** Singleton */
    /** @return Database */
    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    /** Prepares PDO query, binds the values to the query and executes it.  */
    public function bindAndExecute(string $query, array $values = []): PDOStatement
    {

        // Initialize database
        $this->statement = $this->pdo->prepare($query);

        // Binding all variables from attribute
        if (!empty($values)) {
            foreach ($values as $key => $value) {
                $this->statement->bindValue($key, $value);
            }
        }

        $this->statement->execute();

        return $this->statement;

    }

    /** Validates the given query */
    public function validateQuery(string $query, bool $exception_message = false): bool
    {

        try {
            $query = $this->pdo->query($query);
        } catch (\PDOException $exception) {

            if($exception_message) {
                throw new \PDOException($exception);
            }

            return false;

        }

        return (bool)$query;

    }

    /** Check if the given table exists in the database. */
    public function tableExists(string $table): bool
    {
        $query = 'SELECT 1 FROM ' . $table . ' LIMIT 1;';

        if (!$this->validateQuery($query)) {
            throw new InvalidTableException($table);
        }

        return true;
    }

    // TODO: implement validations for rows & columns

}