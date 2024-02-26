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

    /** Generated SQL query. */
    private string $sql;

    public function __construct(string $modelClass)
    {
        $this->modelClass = $modelClass;
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
}