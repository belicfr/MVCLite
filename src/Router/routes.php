<?php

/*
 * routes.php
 * MVCLite framework by belicfr
 */


use MvcLite\Router\Engine\Router;

// Create your own routes!

Router::get("/", \MvcLite\Controllers\AgeController::class, "redirectToIndex");

Router::get("/age", \MvcLite\Controllers\AgeController::class, "render")
    ->setName("age");

Router::post("/age", \MvcLite\Controllers\AgeController::class, "ofAge")
    ->setName("post.age");