<?php

namespace MvcLite\Router\Engine;

use MvcLite\Engine\DevelopmentUtilities\Debug;

/**
 * Redirection management class.
 *
 * @author belicfr
 */
class Redirect
{
    /**
     * Redirection by route path.
     *
     * @param string $path Route path
     * @return RedirectResponse Redirect object
     */
    public static function to(string $path, array $parameters = []): RedirectResponse
    {
        $route = Router::getRouteByPath($path);

        return new RedirectResponse($route, $parameters);
    }

    /**
     * Redirection by route name.
     *
     * @param string $name Route name
     * @return RedirectResponse Redirect object
     */
    public static function route(string $name, array $parameters = []): RedirectResponse
    {
        $route = Router::getRouteByName($name);

        return new RedirectResponse($route, $parameters);
    }
}