<?php

namespace MvcLite\Controllers;

class TestController
{
    public function __construct()
    {
        // Empty constructor.
    }

    public function renderPage(): void
    {
        echo "Hello, World";
    }
}