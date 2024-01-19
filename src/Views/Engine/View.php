<?php

namespace MvcLite\Views\Engine;

use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\InternalResources\Delivery;
use MvcLite\Router\Engine\Request;
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
        $props = Delivery::get();

        echo "<noscript>
                  Veuillez activer le JavaScript.
                  <meta http-equiv=\"refresh\" content=\"0; url=" . ROUTE_PATH_PREFIX . "nojs.php\" />
              </noscript>";

        include_once $absoluteViewPath;
    }
}