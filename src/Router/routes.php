<?php

/*
 * routes.php
 * MVCLite framework by belicfr
 */


use MvcLite\Router\Engine\Router;

// Create your own routes!

Router::get("/", \MvcLite\Controllers\HelloController::class, "redirectToIndex");

Router::get("/index", \MvcLite\Controllers\HelloController::class, "render");