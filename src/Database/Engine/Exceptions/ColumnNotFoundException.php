<?php

namespace MvcLite\Database\Engine\Exceptions;

use MvcLite\Engine\MvcLiteException;

class ColumnNotFoundException extends MvcLiteException
{
    public function __construct(string $column, string $query)
    {
        parent::__construct();

        $this->code = "MVCLITE_DB_COLUMN_NOT_FOUND";
        $this->message = "<strong>Database Error:</strong> $column column does not exist.<br />
                          <strong>Query:</strong> $query";
    }
}