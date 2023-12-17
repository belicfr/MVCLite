<?php

namespace MvcLite\Engine\InternalResources\Exceptions;

use MvcLite\Engine\MvcLiteException;

class InvalidResourceTypeException extends MvcLiteException
{
    public function __construct()
    {
        parent::__construct();

        $this->code = "MVCLITE_INVALID_RESOURCE_TYPE";
        $this->message = "This resource type cannot be defined. 
                          You can define manually a type in include function calling.";
    }
}