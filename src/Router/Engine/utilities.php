<?php

/*
 * Utilities router functions.
 */

use MvcLite\Engine\InternalResources\Delivery;
use MvcLite\Router\Engine\Request;
use MvcLite\Router\Engine\Router;

/**
 * Returns route path from its name.
 *
 * @param string $name Route name
 * @return string Route path
 */
function route(string $name, array $parameters = []): string
{
    $route = Router::getRouteByName($name);

    return $route !== null
        ? $route->getPath() . $route->prepareParameters()
        : '#';
}

/**
 * @return Request Current Request object
 */
function request(): Request
{
    return Delivery::get()
        ->getRequest();
}

/**
 * @param string $key GET parameter key
 * @return string GET parameter value
 */
function get(string $key): string
{
    return request()->getParameter($key);
}

/**
 * @param string $key POST input key
 * @return string POST input value
 */
function post(string $key): string
{
    return request()->getInput($key);
}

/**
 * @return string Current URI
 */
function uri(): string
{
    return request()->getUri();
}