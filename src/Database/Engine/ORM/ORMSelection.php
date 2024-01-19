<?php

namespace MvcLite\Database\Engine\ORM;

use MvcLite\Database\Engine\Database;
use MvcLite\Database\Engine\ORM\ORMQuery;
use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\Precepts\Naming;

/**
 * ORM selection query class.
 *
 * @author belicfr
 */
class ORMSelection extends ORMQuery
{
    private const BASE_SQL_QUERY_TEMPLATE
        = "SELECT %s FROM %s";

    public function __construct(object $modelObject, array $columns)
    {
        parent::__construct($modelObject, $columns);

        // Empty constructor.
    }

    /**
     * @return string Generated SQL query
     */
    public function getSqlQuery(): string
    {
        return sprintf(self::BASE_SQL_QUERY_TEMPLATE,
                       parent::getImplodedColumns(),
                       $this->getModelObject()->getTableName());
    }

    /**
     * @return array Query execution result
     */
    public function execute(): array
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
                $lineObject->$column = $line[$column];
            }

            $result[] = $lineObject;
        }

        return $result;
    }
}