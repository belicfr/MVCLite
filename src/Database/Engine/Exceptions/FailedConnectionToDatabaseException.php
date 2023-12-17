<?php

namespace MvcLite\Database\Engine\Exceptions;

use MvcLite\Engine\MvcLiteException;

class FailedConnectionToDatabaseException extends MvcLiteException
{
    public function __construct(string $pdoExceptionMessage)
    {
        parent::__construct();

        $this->code = "MVCLITE_DB_FAILED_CONNECTION";
        $this->message = "<strong>Database Error:</strong> $pdoExceptionMessage.";
    }
}