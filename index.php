<?php

session_start();

require_once "vendor/autoload.php";

use MvcLite\Plugins\PluginsManager;
use MvcliteCore\Engine\InternalResources\Delivery;
use MvcliteCore\Router\Exceptions\NoneRouteException;
use MvcliteCore\Router\Router;

PluginsManager::loadEvent("onStarted");

PluginsManager::loadEvent("onBeforeConfigLoad");

require_once "config.php";

PluginsManager::loadEvent("onAfterConfigLoad");

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

PluginsManager::loadEvent("onBeforeRouter");

$route = Router::getRouteByPath('/' . trim($routePath));

PluginsManager::loadEvent("onAfterRouter");

Router::useRoute($route);

PluginsManager::loadEvent("onBeforeDeliveryReset");

(new Delivery())
    ->save();

PluginsManager::loadEvent("onAfterDeliveryReset");