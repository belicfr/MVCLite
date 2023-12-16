<?php

namespace MvcLite\Router\Engine;

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
     */
    public static function to(string $path): Redirect
    {
        $route = Router::getRouteByPath($path);

        $redirection = new Redirect($route);
        $redirection->redirect();

        return $redirection;
    }

    /** Redirection route. */
    private Route $route;

    private function __construct(Route $route)
    {
        $this->route = $route;
    }

    private function redirect(): void
    {
        header("Location: " . $this->route->getPath());
    }
}