<?php

namespace MvcLite\Database\Engine\Exceptions;

use MvcLite\Engine\MvcLiteException;

class NegativeOrNullStackException extends MvcLiteException
{
    public function __construct()
    {
        parent::__construct();

        $this->code = "MVCLITE_NEGATIVE_OR_NULL_DATABASE_STACKING";
        $this->message = "Database stacking requires a positive integer (>= 1).";
    }
}