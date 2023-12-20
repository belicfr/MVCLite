<?php

namespace MvcLite\Router\Engine;

use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\InternalResources\Delivery;
use MvcLite\Engine\Security\Validator;

/**
 * Redirection management class.
 *
 * @author belicfr
 */
class RedirectResponse
{
    /** Redirection route. */
    private Route $route;

    public function __construct(Route $route)
    {
        $this->route = $route;
    }

    public function withValidator(Validator $validator): RedirectResponse
    {
        (new Delivery($validator))
            ->save();

        return $this;
    }

    public function redirect(): void
    {
        header("Location: " . $this->route->getCompletePath());
    }
}