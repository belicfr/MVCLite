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
    /** Current model class object. */
    private object $modelObject;

    /** Table columns used by query. */
    private array $columns;

    public function __construct(object $modelObject, array $columns)
    {
        $this->modelObject = $modelObject;
        $this->columns = $columns;
    }

    /**
     * @return object Current model class object
     */
    public function getModelObject(): object
    {
        return $this->modelObject;
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