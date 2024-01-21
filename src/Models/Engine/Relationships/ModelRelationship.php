<?php

namespace MvcLite\Models\Engine\Relationships;

use MvcLite\Engine\Precepts\Naming;
use MvcLite\Models\Engine\Model;

class ModelRelationship
{
    private Model $leftModel;

    private string $rightModel;

    public function __construct(Model $leftModel, string $rightModel, ?string $customColumnName = null)
    {
        $this->leftModel = $leftModel;
        $this->rightModel = $rightModel;
    }

    public function getLeftModel(): Model
    {
        return $this->leftModel;
    }

    public function getRightModel(): string
    {
        return $this->rightModel;
    }
}