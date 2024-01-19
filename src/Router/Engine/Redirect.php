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
        //Debug::dd($parameters);

        $route = Router::getRouteByPath($path);

        $redirection = new RedirectResponse($route, $parameters);
        $redirection->redirect();

        return $redirection;
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

        $redirection = new RedirectResponse($route, $parameters);
        $redirection->redirect();

        return $redirection;
    }
}