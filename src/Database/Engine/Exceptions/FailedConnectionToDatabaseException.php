<?php

namespace MvcLite\Database\Engine\Exceptions;

use MvcLite\Engine\MvcLiteException;

class FailedConnectionToDatabaseException extends MvcLiteException
{
    public function __construct()
    {
        parent::__construct();

        $this->code = "MVCLITE_DB_FAILED_CONNECTION";
        $this->message = "Failed connection attempt to database.";
    }
}