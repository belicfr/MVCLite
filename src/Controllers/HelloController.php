<?php

namespace MvcLite\Controllers;

use MvcLite\Controllers\Engine\Controller;
use MvcLite\Middlewares\TestMiddleware;

class HelloController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        // Empty constructor.
    }

    // Create your own methods!
}