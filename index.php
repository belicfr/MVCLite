<?php

session_start();

use MvcLite\Plugins\PluginsManager;
use MvcliteCore\Engine\InternalResources\Delivery;
use MvcliteCore\Router\Exceptions\NoneRouteException;
use MvcliteCore\Router\Router;

require_once "vendor/autoload.php";

require_once "config.php";

PluginsManager::loadPlugins();

/* On Started Plugins Event */
PluginsManager::loadEvent("onStarted");

if (!isset($_SESSION[Delivery::DELIVER_POST_KEY]))
{
    (new Delivery())
        ->save();
}

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

/* Before Router Plugins Event */
PluginsManager::loadEvent("beforeRouter");

$route = Router::getRouteByPath('/' . trim($routePath));
Router::useRoute($route);

(new Delivery())
    ->save();