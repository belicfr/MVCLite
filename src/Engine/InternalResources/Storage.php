<?php

namespace MvcLite\Engine\InternalResources;

use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\InternalResources\Exceptions\InvalidResourceTypeException;
use MvcLite\Engine\InternalResources\Exceptions\NotFoundResourceException;

class Storage
{
    /** RegEx for .css files. */
    private const REGEX_CSS_FILE = "/(.*).css$/";

    /** RegEx for .js files. */
    private const REGEX_JS_FILE = "/(.*).js$/";

    /**
     * @return string /src/Engine/ folder path
     */
    public static function getEnginePath(): string
    {
        return $_SERVER['DOCUMENT_ROOT'] . ROUTE_PATH_PREFIX . "/src/Engine";
    }

    /**
     * @return string /src/Resources/ folder path
     */
    public static function getResourcesPath(): string
    {
        return $_SERVER['DOCUMENT_ROOT'] . ROUTE_PATH_PREFIX . "/src/Resources";
    }

    /**
     * @return string /src/Views/Components/ folder path
     */
    public static function getComponentsPath(): string
    {
        return $_SERVER["DOCUMENT_ROOT"] . ROUTE_PATH_PREFIX . "/src/Views/Components";
    }

    /**
     * Attempt to include a supported file in a view.
     *
     * @param string $relativePath Relative path to file
     * @param string $type Optional file type (by default
     *                     automatically defined)
     * @return string Generated HTML content
     */
    public static function include(string $relativePath, string $type = ""): string
    {
        $pathPrefix = ROUTE_PATH_PREFIX[strlen(ROUTE_PATH_PREFIX) - 1] == '/'
            ? substr(ROUTE_PATH_PREFIX, 0, strlen(ROUTE_PATH_PREFIX) - 1)
            : ROUTE_PATH_PREFIX;

        $relativePath = $relativePath[0] == '/'
            ? $relativePath
            : '/' . $relativePath;

        $absolutePath = self::getResourcesPath() . $relativePath;

        $type = strtolower($type);
        $html = "";

        if (!file_exists($absolutePath))
        {
            $error = new NotFoundResourceException($relativePath);
            $error->render();
        }

        if ($type == "css" || preg_match(self::REGEX_CSS_FILE, $relativePath))
        {
            $html = "<link rel='stylesheet' href='$pathPrefix/src/Resources$relativePath' />";
        }
        else if ($type == "js" || preg_match(self::REGEX_JS_FILE, $relativePath))
        {
            $html = "<script src='$pathPrefix/src/Resources/$relativePath'></script>";
        }
        else
        {
            $error = new InvalidResourceTypeException();
            $error->render();
        }

        echo $html;

        return $html;
    }

    public static function component(string $name, array $props = []): void
    {
        $props["props"] = Delivery::get();
        extract($props);

        include "src/Views/Components/$name.php";
    }
}