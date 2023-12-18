<?php

/*
 * Utilities router functions.
 */

use MvcLite\Router\Engine\Router;

/**
 * Returns route path from its name.
 *
 * @param string $name Route name
 * @return string Route path
 */
function route(string $name): string
{
    $route = Router::getRouteByName($name);

    return $route !== null
        ? $route->getPath()
        : "#";
}