<?php

namespace MvcLite\Router\Engine\Exceptions;

use MvcLite\Engine\MvcLiteException;

class UndefinedInputException extends MvcLiteException
{
    public function __construct(string $inputKey)
    {
        parent::__construct();

        $this->code = "MVCLITE_UNDEFINED_INPUT";
        $this->message = "$inputKey input does not longer exist.";
    }
}