<?php

/*
 * routes.php
 * MVCLite framework by belicfr
 */


use MvcLite\Router\Engine\Router;

// Create your own routes!

Router::get("/", \MvcLite\Controllers\HelloController::class, "redirectToIndex");

Router::get("/age", \MvcLite\Controllers\HelloController::class, "render")
    ->setName("age");

Router::post("/age", \MvcLite\Controllers\HelloController::class, "ofAge")
    ->setName("post.age");