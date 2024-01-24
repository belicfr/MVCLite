<?php

namespace MvcLite\Database\Engine\Exceptions;

use MvcLite\Database\Engine\Database;
use MvcLite\Engine\MvcLiteException;

/**
 * MVCLite core exception.
 *
 * This exception must be thrown if database connection
 * attempt failed during database connection attempt or
 * SQL query running.
 *
 * @see Database
 * @author belicfr
 */
class FailedConnectionToDatabaseException extends MvcLiteException
{
    public function __construct(string $pdoExceptionMessage)
    {
        parent::__construct();

        $this->code = "MVCLITE_DB_FAILED_CONNECTION";
        $this->message = "<strong>Database Error:</strong> $pdoExceptionMessage.";
    }
}