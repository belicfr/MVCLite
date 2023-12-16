<?php

namespace MvcLite\Controllers\InternalControllers;

use MvcLite\Engine\InternalResources\Storage;

/**
 * Controller used by core exceptions.
 *
 * @author belicfr
 */
class DebugCoreController
{
    public function __construct()
    {
        // Empty constructor.
    }

    /**
     * Render MVCLite exception dialog CSS file.
     */
    public function ddRenderingCss()
    {
        $cssFilePath = Storage::getEnginePath() . "/DevelopmentUtilities/DebugRendering/dd.css";
        include_once $cssFilePath;
    }
}