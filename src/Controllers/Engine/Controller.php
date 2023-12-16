<?php

namespace MvcLite\Controllers\Engine;

use MvcLite\Middlewares\Engine\Middleware;

class Controller
{
    public function __construct()
    {
        // Empty constructor.
    }

    /**
     * @param string $middleware Middleware class
     */
    protected function middleware(string $middleware): void
    {
        $middlewareInstance = new $middleware();
        $middlewareInstance->run();
    }
}