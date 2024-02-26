<?php

namespace MvcLite\Database\Engine\ORM;

use MvcLite\Database\Engine\Database;
use MvcLite\Database\Engine\Exceptions\NegativeOrNullLimitException;
use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Models\Engine\Model;
use MvcLite\Models\Engine\ModelCollection;

/**
 * ORM deletion query class.
 *
 * Allows to delete an existing line using MVCLite ORM.
 *
 * @see ORMQuery
 * @author belicfr
 */
class ORMDeletion extends ORMQuery
{
    private const BASE_SQL_QUERY_TEMPLATE
        = "DELETE FROM ";

    private const SQL_VALUES_EXPRESSION_TEMPLATE
        = "(%s) VALUES (%s)";

    private array $values;

    public function __construct(string $modelClass, array $values)
    {
        parent::__construct($modelClass);

        $this->values = $values;

        $sqlQueryBase = sprintf(self::BASE_SQL_QUERY_TEMPLATE,
            ($this->getModelClass())::getTableName());

        $this->addSql($sqlQueryBase);

        $this->prepareSqlValuesExpression();
    }

    /**
     * @return array Values to insert
     */
    public function getValues(): array
    {
        return $this->values;
    }

    /**
     * @return bool If there are values to insert
     */
    public function hasValues(): bool
    {
        return count($this->getValues());
    }

    public function getColumns(): array
    {
        return array_keys($this->getValues());
    }

    public function getColumnsValues(): array
    {
        return array_values($this->getValues());
    }

    private function prepareSqlValuesExpression(): void
    {
        $expression = sprintf(self::SQL_VALUES_EXPRESSION_TEMPLATE,
                              implode(", ", $this->getColumns()),
                              $this->getAnonymousParametersByArray($this->getColumnsValues()));

        $this->addSql($expression);
    }

    private function getAnonymousParametersByArray(array $array): string
    {
        $expression = "";

        for ($_ = 0; $_ < count($array); $_++)
        {
            $expression .= $_ == 0
                ? "?"
                : ", ?";
        }

        return $expression;
    }

    /**
     * Send generated SQL query by using Database class.
     */
    public function execute(): Model
    {
        $query = Database::query($this->getSql(), ...$this->getColumnsValues());
        $lastId = Database::query("SELECT LAST_INSERT_ID() as lastId")
            ->get()["lastId"];

        return $this->getModelClass()::getById($lastId)
            ->execute()
            ->get(0);
    }
}