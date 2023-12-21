<?php

namespace MvcLite\Controllers;

use MvcLite\Controllers\Engine\Controller;
use MvcLite\Router\Engine\Redirect;
use MvcLite\Router\Engine\Request;
use MvcLite\Views\Engine\View;

class AgeController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        // Empty constructor.
    }

    public function render(): void
    {
        View::render("AgeForm");
    }

    public function ofAge(Request $request): void
    {
        View::render("OfAgeResponse", [
            "isOfAge" => $request->getInput("age") >= 18,
        ]);
    }
}