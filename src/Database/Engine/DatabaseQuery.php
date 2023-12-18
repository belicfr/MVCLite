<?php

namespace MvcLite\Database\Engine;

use MvcLite\Database\Engine\Exceptions\FailedConnectionToDatabaseException;
use MvcLite\Engine\DevelopmentUtilities\Debug;
use PDOException;
use PDOStatement;

class DatabaseQuery
{
    /** Current SQL query. */
    private string $sqlQuery;

    /** Current SQL query parameters. */
    private array $parameters;

    /** Current SQL query preparation. */
    private ?PDOStatement $preparation;

    /** Current SQL query execution state. */
    private ?bool $executionState;

    public function __construct(string $sqlQuery, array $parameters)
    {
        $this->sqlQuery = $sqlQuery;
        $this->parameters = $parameters;

        $this->preparation = null;
        $this->executionState = null;

        try
        {
            $this->prepareQuery();
            $this->executeQuery();
        }
        catch (PDOException $e)
        {
            $error = new FailedConnectionToDatabaseException($e->getMessage());
            $error->render();
        }
    }

    /**
     * Prepare SQL query.
     *
     * @return PDOStatement Prepared SQL query PDO object
     */
    private function prepareQuery(): PDOStatement
    {
        global $db;

        return $this->preparation = $db->prepare($this->sqlQuery);
    }

    /**
     * Execute SQL query.
     *
     * @return bool PDO execution state
     */
    private function executeQuery(): bool
    {
        global $db;

        return $this->executionState = $this->preparation
                                            ->execute($this->parameters);
    }

    /**
     * @return array All SQL query results
     */
    public function getAll(): array
    {
        return $this->preparation->fetchAll();
    }

    /**
     * @return array|false Current cursor line if exists;
     *                     else FALSE
     */
    public function get(): array|false
    {
        return $this->preparation->fetch();
    }

    /**
     * @return bool|null SQL query execution state if executed;
     *                   else NULL
     */
    public function getExecutionState(): ?bool
    {
        return $this->executionState;
    }
}