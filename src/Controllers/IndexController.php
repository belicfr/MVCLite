<?php

namespace MvcLite\Controllers;

use MvcLite\Controllers\Engine\Controller;
use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Models\FirstModel;
use MvcLite\Models\User;
use MvcLite\Router\Engine\Redirect;
use MvcLite\Views\Engine\View;

class IndexController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        // Empty constructor.
    }

    public function redirectToIndex(): void
    {
        Redirect::route("index", [
            "age"   => 19,
        ])
            ->redirect();
    }

    public function render(): void
    {
        $users = (new User())
            ->select()
            ->execute()
            ->publish();

        View::render("Index", [
            "users" => $users,
        ]);
    }
}