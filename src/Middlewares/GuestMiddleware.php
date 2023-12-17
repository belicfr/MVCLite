<?php

namespace MvcLite\Middlewares;

use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\Session\Session;
use MvcLite\Middlewares\Engine\Middleware;
use MvcLite\Router\Engine\Redirect;

class GuestMiddleware extends Middleware
{
    public function __construct()
    {
        parent::__construct();

        // Empty constructor.
    }

    public function run(): bool|Redirect
    {
        if (Session::isLogged())
        {
            echo "YOU MUST BE DISCONNECTED.";
            die;
        }

        return parent::run();
    }
}