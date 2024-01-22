<?php

namespace MvcLite\Models\Engine\Relationships;

use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\Precepts\Naming;
use MvcLite\Models\Engine\Model;
use MvcLite\Models\Engine\Relationships\ModelRelationship;

class HasOne extends ModelRelationship
{
    /** Relationship child. */
    private ?Model $child;

    /** Foreign key column name. */
    private string $foreignKeyColumnName;

    public function __construct(Model $leftModel, string $rightModel, ?string $customColumnName = null)
    {
        parent::__construct($leftModel, $rightModel, $customColumnName);

        $this->foreignKeyColumnName
            = $customColumnName ?? "id_" . Naming::camelToSnake(Naming::getClassName($leftModel::class));
    }

    /**
     * @return Model|null Relationship child
     */
    public function getChild(): ?Model
    {
        return $this->child;
    }

    /**
     * @return string Foreign key column name
     */
    public function getForeignKeyColumnName(): string
    {
        return $this->foreignKeyColumnName;
    }

    /**
     * Returns relationship child.
     *
     * @return Model|null
     */
    public function run(): ?Model
    {
        $related = (new (parent::getRightModel()))
            ->select()
            ->where($this->getForeignKeyColumnName(), parent::getLeftModel()->getPublicAttributes()["id"])
            ->execute()
            ->asArray();

        return $this->child = $related[0] ?? null;
    }
}