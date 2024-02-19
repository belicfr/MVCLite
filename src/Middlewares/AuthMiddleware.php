<?php

namespace MvcLite\Middlewares;

use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\Session\Session;
use MvcLite\Middlewares\Engine\Middleware;
use MvcLite\Router\Engine\Redirect;

class AuthMiddleware extends Middleware
{
    public function run(): bool
    {
        if (!Session::isLogged())
        {
            Redirect::route("home")
                ->redirect();

            return false;
        }

        return parent::run();
    }
}