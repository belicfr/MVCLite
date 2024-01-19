<?php

namespace MvcLite\Database\Engine\Exceptions;

use MvcLite\Engine\MvcLiteException;

class FailedDatabaseQueryException extends MvcLiteException
{
    public function __construct(string $query)
    {
        parent::__construct();

        $this->code = "MVCLITE_DB_FAILED_QUERY";
        $this->message = "<strong>Database Error:</strong> Failed to run database query.<br />
                          <strong>Query:</strong> $query";
    }
}