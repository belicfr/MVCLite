<?php

namespace MvcLite\Engine\InternalResources;

use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\InternalResources\Exceptions\InvalidResourceTypeException;
use MvcLite\Engine\InternalResources\Exceptions\NotFoundResourceException;

class Storage
{
    private const REGEX_CSS_FILE = "/(.*).css$/";

    private const REGEX_JS_FILE = "/(.*).js$/";

    public static function getEnginePath(): string
    {
        return $_SERVER['DOCUMENT_ROOT'] . "/src/Engine";
    }

    public static function getResourcesPath(): string
    {
        return $_SERVER['DOCUMENT_ROOT'] . "/src/Resources";
    }

    public static function include(string $relativePath, string $type = ""): string
    {
        $absolutePath = self::getResourcesPath() . $relativePath;
        $resourceFileContent = file_get_contents($absolutePath);

        $type = strtolower($type);

        if (!file_exists($absolutePath))
        {
            $error = new NotFoundResourceException($relativePath);
            $error->render();
        }

        if ($type == "css" || preg_match(self::REGEX_CSS_FILE, $relativePath))
        {
            $html = "<style>$resourceFileContent</style>";
        }
        else if ($type == "js" || preg_match(self::REGEX_JS_FILE, $relativePath))
        {
            $html = "<script>$resourceFileContent</script>";
        }
        else
        {
            $error = new InvalidResourceTypeException();
            $error->render();
        }

        echo $html;
        return $html;
    }
}