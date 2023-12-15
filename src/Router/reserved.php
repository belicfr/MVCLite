<?php

/*
 * reserved.php
 * MVCLite framework by belicfr
 */

use MvcLite\Controllers\InternalControllers\ExceptionsCoreController;
use MvcLite\Router\Engine\Router;

Router::get("/core/exceptions/css/rendering", ExceptionsCoreController::class, "renderingCss");