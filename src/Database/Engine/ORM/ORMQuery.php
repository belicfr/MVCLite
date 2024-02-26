<?php

namespace MvcLite\Database\Engine\ORM;

use MvcLite\Models\Engine\ModelCollection;

/**
 * Main MVCLite ORM class.
 *
 * Allows to create various ORM query types like selection,
 * insertion or deletion.
 *
 * @see ORMSelection
 * @author belicfr
 */
class ORMQuery
{
    /** Current model class. */
    private string $modelClass;

    /** Table columns used by query. */
    private array $columns;

    /** Generated SQL query. */
    private string $sql;

    public function __construct(string $modelClass, array $columns)
    {
        $this->modelClass = $modelClass;
        $this->columns = $columns;
        $this->sql = "";
    }

    /**
     * @return object Current model class
     */
    public function getModelClass(): string
    {
        return $this->modelClass;
    }

    /**
     * @return array Table columns used by query
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * @return string Imploded table columns used by query
     */
    protected function getImplodedColumns(): string
    {
        return implode(', ', $this->getColumns());
    }

    /**
     * @return string Generated SQL query
     */
    public function getSql(): string
    {
        return $this->sql;
    }

    /**
     * Appends to SQL query the given line.
     *
     * @param string $line
     * @return string Updated SQL query
     */
    public function addSql(string $line): string
    {
        if (strlen($this->getSql()))
        {
            $this->sql .= ' ';
        }

        $this->sql .= $line;

        return $this->getSql();
    }

    /**
     * Execute a null ORM query.
     *
     * Please use children class to get results.
     *
     * @see ORMSelection
     * @return ModelCollection Query execution result
     */
    public function execute(): ModelCollection
    {
        return new ModelCollection();
    }
}