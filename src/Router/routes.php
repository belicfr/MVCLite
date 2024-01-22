<?php

/*
 * routes.php
 * MVCLite framework by belicfr
 */


use MvcLite\Controllers\IndexController;
use MvcLite\Router\Engine\Router;

// Create your own routes!

Router::get("/", IndexController::class, "redirectToIndex");


Router::get("/index/php", IndexController::class, "renderPhp")
    ->setName("index.php");

Router::get("/index/twig", IndexController::class, "renderTwig")
    ->setName("index.twig");