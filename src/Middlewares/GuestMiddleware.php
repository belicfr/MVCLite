<?php

namespace MvcLite\Middlewares;

use MvcliteCore\Engine\DevelopmentUtilities\Debug;
use MvcliteCore\Engine\Session\Session;
use MvcliteCore\Middlewares\Middleware;
use MvcliteCore\Router\Redirect;

class GuestMiddleware extends Middleware
{
    public function run(): bool
    {
        if (Session::isLogged())
        {
            Redirect::route("dashboard")
                ->redirect();

            return false;
        }

        return parent::run();
    }
}