<?php

namespace MvcLite\Router\Engine\Exceptions;

use MvcLite\Engine\MvcLiteException;

class UndefinedRouteException extends MvcLiteException
{
    public function __construct()
    {
        parent::__construct();

        $this->code = "404";
        $this->message = null;

        $this->setTitle("404 Not Found");
    }
}