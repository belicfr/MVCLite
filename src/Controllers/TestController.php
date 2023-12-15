<?php

namespace MvcLite\Controllers;

use MvcLite\Views\Engine\View;

class TestController
{
    public function __construct()
    {
        // Empty constructor.
    }

    public function renderPage(): void
    {
        View::render("HelloWorld", [ "test" => 1 ]);
    }
}