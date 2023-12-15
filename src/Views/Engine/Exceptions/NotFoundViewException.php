<?php

namespace MvcLite\Views\Engine\Exceptions;

use MvcLite\Engine\MvcLiteException;

class NotFoundViewException extends MvcLiteException
{
    public function __construct()
    {
        parent::__construct();

        $this->code = "0x1001";
        $this->message = "No one view is located to given path.";
    }
}