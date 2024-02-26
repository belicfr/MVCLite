<?php

namespace MvcLite\Controllers\InternalControllers;

use MvcliteCore\Engine\InternalResources\Storage;

/**
 * Controller used by core exceptions.
 *
 * @author belicfr
 */
class ExceptionsCoreController
{
    public function __construct()
    {
        // Empty constructor.
    }

    /**
     * Render MVCLite exception dialog CSS file.
     */
    public function renderingCss()
    {
        $cssFilePath = Storage::getEnginePath() . "/InternalResources/ExceptionRendering/rendering.css";
        include_once $cssFilePath;
    }
}