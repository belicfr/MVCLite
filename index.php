<?php

session_start();

use MvcliteCore\Engine\InternalResources\Delivery;
use MvcliteCore\Router\Exceptions\NoneRouteException;
use MvcliteCore\Router\Router;

require_once "vendor/autoload.php";

require_once "config.php";

if (!isset($_SESSION[Delivery::DELIVER_POST_KEY]))
{
    (new Delivery())
        ->save();
}

\MvcliteCore\Engine\DevelopmentUtilities\Debug::dump(Delivery::get());

require_once "src/Database/connection.php";

require_once "src/Router/reserved.php";
require_once "src/Router/routes.php";
require_once "vendor/belicfr/mvclite-core/src/Router/utilities.php";

if (!isset($_GET["route"]))
{
    $error = new NoneRouteException();
    $error->render();
}

$routePath = filter_var($_GET["route"], FILTER_SANITIZE_URL);
$routePathLength = strlen($routePath);

if ($routePathLength)
{
    $routePathLastCharacter = $routePath[$routePathLength - 1];

    if ($routePathLastCharacter == '/') {
        $routePath[strlen($routePath) - 1] = " ";
    }
}

$route = Router::getRouteByPath('/' . trim($routePath));
$routeUsing = Router::useRoute($route);

(new Delivery())
    ->save();