<?php

namespace MvcLite\Models;

use MvcLite\Models\Engine\Model;

class FirstModel extends Model
{
    public const GETTERS = [
        "id",
    ];

    public const SETTERS = [
        // None setter.
    ];

    public function __construct()
    {
        parent::__construct();
    }

    // Create your own methods.
}