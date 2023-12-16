<?php

namespace MvcLite\Router\Engine;

/**
 * Redirection management class.
 *
 * @author belicfr
 */
class Redirect
{
    public static function to(string $path): void
    {
        header("Location: $path");
    }
}