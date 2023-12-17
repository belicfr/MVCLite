<?php

session_start();

use MvcLite\Engine\InternalResources\Storage;
use MvcLite\Router\Engine\Exceptions\NoneRouteException;
use MvcLite\Router\Engine\Router;

require_once "vendor/autoload.php";

$debugCss = file_get_contents(Storage::getEnginePath()
    . "/DevelopmentUtilities/DebugRendering/rendering.css");

$exceptionsCss = file_get_contents(Storage::getEnginePath()
    . "/InternalResources/ExceptionRendering/rendering.css");

echo "<style>$exceptionsCss $debugCss</style>";

require_once "src/Database/connection.php";
require_once "src/Database/authentification.php";

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

