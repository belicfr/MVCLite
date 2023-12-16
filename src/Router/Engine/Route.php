<?php

namespace MvcLite\Router\Engine;

use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Router\Engine\Exceptions\AlreadyUsedRouteNameException;

/**
 * Class that represents a route and its own information.
 *
 * @author belicfr
 */
class Route
{
    /** HTTP request method: POST | GET */
    private string $httpMethod;

    /** URL path linked to current route. */
    private string $path;

    /** Controller used by current route. */
    private string $controller;

    /** Controller method called by current route. */
    private string $method;

    /** Route name. */
    private ?string $name;

    public function __construct(string $httpMethod,
                                string $path,
                                string $controller,
                                string $method)
    {
        $this->httpMethod = $httpMethod;
        $this->path = $path;
        $this->controller = $controller;
        $this->method = $method;
        $this->name = null;
    }

    /**
     * @return string Used HTTP method
     */
    public function getHttpMethod(): string
    {
        return $this->httpMethod;
    }

    /**
     * @return string Defined path
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return string Used controller class
     */
    public function getController(): string
    {
        return $this->controller;
    }

    /**
     * @return string Called controller method
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string|null Route name
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name Route name
     */
    public function setName(string $name): void
    {
        if (Router::getRouteByName($name) !== null)
        {
            $error = new AlreadyUsedRouteNameException($name);
            $error->render();
        }

        $this->name = $name;
    }
}