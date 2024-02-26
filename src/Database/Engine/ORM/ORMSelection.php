<?php

namespace MvcLite\Database\Engine\ORM;

use MvcLite\Database\Engine\Database;
use MvcLite\Database\Engine\Exceptions\NegativeOrNullLimitException;
use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Models\Engine\Model;
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

    /** Given LIMIT clause. */
    private ?int $limit;

    public function __construct(string $modelClass, array $columns)
    {
        parent::__construct($modelClass, $columns);

        $sqlQueryBase = sprintf(self::BASE_SQL_QUERY_TEMPLATE,
            parent::getImplodedColumns(),
            ($this->getModelClass())::getTableName());

        $this->addSql($sqlQueryBase);

        $this->relationships = [];
        $this->conditions = [];
        $this->ordering = [];
        $this->limit = null;
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

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function hasLimit(): bool
    {
        return $this->limit !== null;
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
        $sqlWhereClause = $this->prepareWhereClauseLine($column, $operatorOrValue, $value);
        $sqlWhereClause = $this->hasConditions()
            ? "AND $sqlWhereClause"
            : "WHERE $sqlWhereClause";

        $this->addSql($sqlWhereClause);
        $this->conditions[] = $sqlWhereClause;

        return $this;
    }

    public function orWhere(string $column, string $operatorOrValue, ?string $value = null): ORMSelection
    {
        $sqlWhereClause = $this->prepareWhereClauseLine($column, $operatorOrValue, $value);
        $sqlWhereClause = $this->hasConditions()
            ? "OR $sqlWhereClause"
            : "WHERE $sqlWhereClause";

        $this->addSql($sqlWhereClause);
        $this->conditions[] = $sqlWhereClause;

        return $this;
    }

    private function prepareWhereClauseLine(string $column, $operatorOrValue, ?string $value = null): string
    {
        return $sqlWhereClause = $value === null
            ? "$column = $operatorOrValue"
            : "$column $operatorOrValue $value";
    }

    /**
     * Add an order by clause to current query.
     *
     * @param string $column
     * @param string $order
     * @return $this Current ORM query instance
     */
    public function orderBy(string $column, string $order = "ASC"): ORMSelection
    {
        $order = strtoupper($order);

        $orderingClause = $this->hasOrdering()
            ? ", $column $order"
            : "ORDER BY $column $order";

        $this->addSql($orderingClause);
        $this->ordering[] = $orderingClause;

        return $this;
    }

    /**
     * Add a limit clause to current query.
     *
     * @param int $limit Maximum lines to return
     * @return $this Current ORM query instance
     * @throws NegativeOrNullLimitException If given limit value is
     *                                      <= 0
     */
    public function limit(int $limit): ORMSelection
    {
        if ($limit <= 0)
        {
            throw new NegativeOrNullLimitException($this->getSqlQuery());
        }

        $this->limit = $limit;

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
        $query = Database::query($this->getSql());
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