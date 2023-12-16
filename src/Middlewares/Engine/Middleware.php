<?php

namespace MvcLite\Middlewares\Engine;

class Middleware
{
    public function __construct()
    {
        // Empty constructor.
    }

    public function run(): mixed
    {
        return true;
    }
}