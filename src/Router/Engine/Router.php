<?php

namespace MvcLite\Router\Engine;

use MvcLite\Router\Engine\Exceptions\UndefinedRouteException;

/**
 * Router main class.
 * Allows developer to create their own routes.
 *
 * @author belicfr
 */
class Router
{
    /** HTTP request method GET. */
    private const GET_METHOD = "GET";

    /** HTTP request method POST. */
    private const POST_METHOD = "POST";

    /** Registered routes. */
    private static $routes = [];

    /**
     * Create a GET route.
     *
     * @param string $path URL path used by route
     * @param string $controller Controller used by route
     * @param string $method Controller method called by route
     * @return Route Created route object
     */
    public static function get(string $path, string $controller, string $method): Route
    {
        return self::$routes[$path] = new Route(self::GET_METHOD, $path, $controller, $method);
    }

    /**
     * @return array Registered routes
     */
    public static function getRoutes(): array
    {
        return self::$routes;
    }

    /**
     * @param string $path
     * @return Route Route object linked with given path
     */
    public static function getRouteByPath(string $path): Route
    {
        if (!in_array($path, array_keys(self::getRoutes())))
        {
            $error = new UndefinedRouteException();
            $error->render();
        }
        return self::getRoutes()[$path];
    }

    /**
     * @param Route $route Used route object
     */
    public static function useRoute(Route $route): void
    {
        $controllerInstance = new ($route->getController());
        call_user_func([$controllerInstance, $route->getMethod()]);
    }
}