<?php

namespace MvcLite\Engine\InternalResources;

class Storage
{
    public static function getEnginePath(): string
    {
        return $_SERVER['DOCUMENT_ROOT'] . "/src/Engine";
    }
}