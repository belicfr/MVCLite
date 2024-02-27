<?php

namespace MvcLite\Controllers;

use MvcliteCore\Controllers\Controller;
use MvcliteCore\Controllers\ApiController;
use MvcliteCore\Router\Request;

class TestApiController extends Controller 
{
    public function __construct() 
    {
        parent::__construct();
    }
    
    public function run(Request $request): void
    {
        // TODO: api script
    }
}