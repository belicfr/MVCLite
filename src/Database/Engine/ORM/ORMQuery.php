<?php

namespace MvcLite\Database\Engine\ORM;

use MvcLite\Models\Engine\ModelCollection;

/**
 * Internal MVCLite ORM main class.
 *
 * @author belicfr
 */
class ORMQuery
{
    /** Current model class. */
    private string $modelClass;

    /** Table columns used by query. */
    private array $columns;

    public function __construct(string $modelClass, array $columns)
    {
        $this->modelClass = $modelClass;
        $this->columns = $columns;
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
    public function getSqlQuery(): string
    {
        return "SELECT NULL";
    }

    /**
     * @return ModelCollection Query execution result
     */
    public function execute(): ModelCollection
    {
        return new ModelCollection();
    }
}