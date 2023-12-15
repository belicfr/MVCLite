<?php

/*
 * routes.php
 * MVCLite framework by belicfr
 */


use MvcLite\Controllers\TestController;
use MvcLite\Router\Engine\Router;

Router::get("/test", TestController::class, "renderPage");