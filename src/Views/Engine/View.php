<?php

namespace MvcLite\Views\Engine;

use MvcLite\Views\Engine\Exceptions\NotFoundViewException;

class View
{
    public static function render(string $viewPath, array $props = [])
    {
        $absoluteViewPath = "./src/Views/$viewPath.php";

        if (!file_exists($absoluteViewPath))
        {
            $error = new NotFoundViewException();
            $error->render();
        }

        extract($props);

        include_once $absoluteViewPath;
    }
}