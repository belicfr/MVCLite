<?php

namespace MvcLite\Plugins\Test;

use MvcliteCore\Engine\DevelopmentUtilities\Debug;
use MvcliteCore\Plugins\Plugin;

class TestPlugin extends Plugin
{
    public function __construct()
    {
        parent::__construct();

        $this->name = "Test";
    }

    public function onStarted()
    {
        Debug::dd("Application started!");
    }

    public function onBeforeRouter()
    {
        // TODO: Implement onBeforeRouter() method.
    }

    public function onRouteRetrieving()
    {
        // TODO: Implement onRouteRetrieving() method.
    }

    public function onRouteFound()
    {
        // TODO: Implement onRouteFound() method.
    }

    public function onRouteNotFound()
    {
        // TODO: Implement onRouteNotFound() method.
    }
}