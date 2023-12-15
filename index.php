<?php

use MvcLite\Router\Engine\Router;

require_once "vendor/autoload.php";
require_once "src/Router/routes.php";

if (!isset($_GET["route"]))
{
    echo "<strong>MVCLite Fatal Error:</strong>&nbsp;No one route is used.";
    die;
}

const ROUTE_PATH_PREFIX = '/';

$route = Router::getRouteByPath(ROUTE_PATH_PREFIX . $_GET["route"]);
Router::useRoute($route);