<?php

namespace MvcLite\Models\Engine;

use MvcLite\Database\Engine\ORM\ORMSelection;
use MvcLite\Engine\Precepts\Naming;

class Model
{
    /** Model table name. */
    private string $tableName;

    public function __construct()
    {
        $this->tableName = Naming::camelToSnake(Naming::getClassNameByObject($this));
    }

    /**
     * @return string Model table name
     */
    public function getTableName(): string
    {
        return $this->tableName;
    }

    /**
     * @param string $tableName New model table name
     * @return string New model table name
     */
    public function setTableName(string $tableName): string
    {
        return $this->tableName = $tableName;
    }

    /*
     * ************  MVCLite ORM PART  ************
     */

    public function select(string ...$columns): ORMSelection
    {
        if (!count($columns))
        {
            $columns = ['*'];
        }

        return new ORMSelection($this, $columns);
    }
}