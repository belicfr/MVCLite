<?php

use MvcLite\Router\Engine\Exceptions\NoneRouteException;
use MvcLite\Router\Engine\Router;

require_once "vendor/autoload.php";
require_once "src/Router/reserved.php";
require_once "src/Router/routes.php";

if (!isset($_GET["route"]))
{
    $error = new NoneRouteException();
    $error->render();
}

const ROUTE_PATH_PREFIX = '/';

$route = Router::getRouteByPath(ROUTE_PATH_PREFIX . $_GET["route"]);
Router::useRoute($route);