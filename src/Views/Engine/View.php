<?php

namespace MvcLite\Views\Engine;

use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\InternalResources\Delivery;
use MvcLite\Router\Engine\Request;
use MvcLite\Views\Engine\Exceptions\NotFoundViewException;
use Twig\Environment;
use Twig\Loader\ArrayLoader;
use Twig\Loader\FilesystemLoader;

class View
{
    public static function render(string $viewPath, array $props = [])
    {
        $absoluteViewPath = "./src/Views/$viewPath.twig";

        if (!file_exists($absoluteViewPath))
        {
            $error = new NotFoundViewException();
            $error->render();
        }

        $props["delivery"] = Delivery::get();

        echo "<noscript>
                  Veuillez activer le JavaScript.
                  <meta http-equiv=\"refresh\" content=\"0; url=" . ROUTE_PATH_PREFIX . "nojs.php\" />
              </noscript>";

        $html = file_get_contents($absoluteViewPath);

        $twigLoader = new FilesystemLoader("./src/Views");
        $twigEnvironment = new Environment($twigLoader);

        echo $twigEnvironment->render("$viewPath.twig", $props);
    }

    public static function nativeRender(string $viewPath, array $props = [])
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

        include $absoluteViewPath;
    }
}