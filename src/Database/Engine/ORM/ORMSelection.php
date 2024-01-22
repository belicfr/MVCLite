<?php

namespace MvcLite\Database\Engine\ORM;

use MvcLite\Database\Engine\Database;
use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Models\Engine\ModelCollection;

/**
 * ORM selection query class.
 *
 * @author belicfr
 */
class ORMSelection extends ORMQuery
{
    private const BASE_SQL_QUERY_TEMPLATE
        = "SELECT %s FROM %s";

    private const WHERE_CLAUSE_TEMPLATE
        = "WHERE %s";

    /** Linked relationships. */
    private array $relationships;

    /** Given WHERE clauses. */
    private array $conditions;

    public function __construct(object $modelObject, array $columns)
    {
        parent::__construct($modelObject, $columns);

        $this->relationships = [];
        $this->conditions = [];
    }

    /**
     * @return string Generated SQL query
     */
    public function getSqlQuery(): string
    {
        $sql = sprintf(self::BASE_SQL_QUERY_TEMPLATE,
            parent::getImplodedColumns(),
            $this->getModelObject()->getTableName());

        if ($this->hasConditions())
        {
            $sql .= " WHERE " . implode(" AND ", $this->getConditions());
        }

        return $sql;
    }

    /**
     * @return array Relationships to use
     */
    public function getRelationships(): array
    {
        return $this->relationships;
    }

    /**
     * Includes relationships to current request.
     *
     * @param string ...$relationships Relationships to use
     * @return $this
     */
    public function with(string ...$relationships): ORMSelection
    {
        $this->relationships = $relationships;

        return $this;
    }

    public function getConditions(): array
    {
        return $this->conditions;
    }

    public function hasConditions(): bool
    {
        return count($this->getConditions());
    }

    public function where(string $column, string $operatorOrValue, ?string $value = null): ORMSelection
    {
        $sqlWhereClause = $value === null
            ? "$column = $operatorOrValue"
            : "$column $operatorOrValue $value";

        $this->conditions[] = $sqlWhereClause;

        return $this;
    }

    /**
     * @return ModelCollection Query execution result
     */
    public function execute(): ModelCollection
    {
        $query = Database::query($this->getSqlQuery());
        $result = [];

        while ($line = $query->get())
        {
            $lineObject = new ($this->getModelObject());
            $tableColumns = $this->getColumns();

            foreach ($tableColumns !== ['*']
                         ? $this->getColumns()
                         : array_keys($line) as $column)
            {
                $lineObject->addPublicAttribute($column, $line[$column]);
            }

            foreach ($this->getRelationships() as $relationship)
            {
                $relationshipRunning = call_user_func([$lineObject, $relationship]);
                $lineObject->addPublicAttribute($relationship, $relationshipRunning);
            }

            $result[] = $lineObject;
        }

        return new ModelCollection($result);
    }
}