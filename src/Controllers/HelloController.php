<?php

namespace MvcLite\Controllers;

use MvcLite\Controllers\Engine\Controller;
use MvcLite\Database\Engine\Database;
use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\InternalResources\Storage;
use MvcLite\Engine\Security\Password;
use MvcLite\Engine\Session\Session;
use MvcLite\Middlewares\GuestMiddleware;
use MvcLite\Router\Engine\Redirect;
use MvcLite\Router\Engine\Request;
use MvcLite\Views\Engine\View;

class HelloController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        // Empty constructor.
    }

    // Create your own methods!.

    public function redirectToIndex(): void
    {
        Redirect::to("/index");
    }

    public function render(Request $request): void
    {
        View::render("HelloWorld");
    }
}