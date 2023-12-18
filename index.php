<?php

session_start();

use MvcLite\Engine\InternalResources\Storage;
use MvcLite\Router\Engine\Exceptions\NoneRouteException;
use MvcLite\Router\Engine\Router;

require_once "vendor/autoload.php";

const ROUTE_PATH_PREFIX = '/';

$debugCss = file_get_contents(Storage::getEnginePath()
    . "/DevelopmentUtilities/DebugRendering/rendering.css");

$exceptionsCss = file_get_contents(Storage::getEnginePath()
    . "/InternalResources/ExceptionRendering/rendering.css");

echo "<style>$exceptionsCss $debugCss</style>";

require_once "src/Database/connection.php";
require_once "src/Database/authentication.php";

require_once "src/Router/reserved.php";
require_once "src/Router/routes.php";
require_once "src/Router/Engine/utilities.php";

if (!isset($_GET["route"]))
{
    $error = new NoneRouteException();
    $error->render();
}

$route = Router::getRouteByPath(ROUTE_PATH_PREFIX . $_GET["route"]);
Router::useRoute($route);

