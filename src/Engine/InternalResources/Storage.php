<?php

namespace MvcLite\Engine\InternalResources;

class Storage
{
    public static function getEngineInternalResourcesPath(): string
    {
        return $_SERVER['DOCUMENT_ROOT'] . "/src/Engine/InternalResources";
    }
}