<?php

namespace MvcLite\Database\Engine\ORM;

use MvcLite\Database\Engine\Database;
use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Models\Engine\ModelCollection;

/**
 * ORM selection query class.
 *
 * Allows to create a new select query using MVCLite ORM.
 *
 * @see ORMQuery
 * @author belicfr
 */
class ORMSelection extends ORMQuery
{
    private const BASE_SQL_QUERY_TEMPLATE
        = "SELECT %s FROM %s";

    private const WHERE_CLAUSE_TEMPLATE
        = "WHERE %s";

    private const ORDER_BY_CLAUSE_TEMPLATE
        = "ORDER BY %s";

    /** Linked relationships. */
    private array $relationships;

    /** Given WHERE clauses. */
    private array $conditions;

    /** Given ORDER BY clauses. */
    private array $ordering;

    public function __construct(string $modelClass, array $columns)
    {
        parent::__construct($modelClass, $columns);

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
            ($this->getModelClass())::getTableName());

        if ($this->hasConditions())
        {
            $conditions = implode(" AND ", $this->getConditions());
            $clause = sprintf(self::WHERE_CLAUSE_TEMPLATE, $conditions);
            $sql .= " $clause";
        }

        if ($this->hasOrdering())
        {
            $ordering = implode(', ', $this->getOrdering())
            $clause = sprintf(self::ORDER_BY_CLAUSE_TEMPLATE, $ordering);
            $sql .= " $clause";
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
     * Includes relationships to current query.
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

    public function getOrdering(): array
    {
        return $this->ordering;
    }

    public function hasOrdering(): bool
    {
        return count($this->getOrdering());
    }

    /**
     * Add a where condition clause to current query.
     *
     * @param string $column Column concerned by condition
     * @param string $operatorOrValue Condition operator if there are three arguments;
     *                                else condition value
     * @param string|null $value Condition value if there are three arguments;
     *                           else NULL
     * @return $this Current ORM query instance
     */
    public function where(string $column, string $operatorOrValue, ?string $value = null): ORMSelection
    {
        $sqlWhereClause = $value === null
            ? "$column = $operatorOrValue"
            : "$column $operatorOrValue $value";

        $this->conditions[] = $sqlWhereClause;

        return $this;
    }

    /**
     * Add an order by clause to current query.
     *
     * @param string ...$columnsRules Ordering rules
     * @return $this Current ORM query instance
     */
    public function orderBy(string ...$columnsRules): ORMSelection
                            // column, ordtype
    {
        foreach ($columnsRules as $rule)
        {
            $this->ordering[] = $rule;
        }

        return $this;
    }

    /**
     * Send generated SQL query by using Database class.
     * It returns the SQL query results as a models collection object.
     *
     * @return ModelCollection Query execution result collection
     */
    public function execute(): ModelCollection
    {
        $query = Database::query($this->getSqlQuery());
        $result = [];

        while ($line = $query->get())
        {
            $lineObject = new ($this->getModelClass());
            $tableColumns = $this->getColumns();

            foreach ($line as $columnName => $columnValue)
            {
                $lineObject->addPublicAttribute($columnName, $columnValue);
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