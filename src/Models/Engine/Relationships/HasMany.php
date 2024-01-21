<?php

namespace MvcLite\Models\Engine\Relationships;

use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\Precepts\Naming;
use MvcLite\Models\Engine\Model;
use MvcLite\Models\Engine\Relationships\ModelRelationship;

class HasMany extends ModelRelationship
{
    /** Relationship children. */
    private array $children;

    /** Foreign key column name. */
    private string $foreignKeyColumnName;

    public function __construct(Model $leftModel, string $rightModel, ?string $customTableName = null)
    {
        parent::__construct($leftModel, $rightModel, $customTableName);

        $this->foreignKeyColumnName
            = $customColumnName ?? "id_" . Naming::camelToSnake(Naming::getClassName($leftModel::class));
    }

    /**
     * @return array Relationship children
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    /**
     * @return string Foreign key column name
     */
    public function getForeignKeyColumnName(): string
    {
        return $this->foreignKeyColumnName;
    }

    /**
     * Returns relationship children.
     *
     * @return array
     */
    public function run(): array
    {
        $related = (new (parent::getRightModel()))
            ->select()
            ->where($this->getForeignKeyColumnName(), parent::getLeftModel()->id)
            ->execute();

        return $this->children = $related;
    }
}