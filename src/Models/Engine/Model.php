<?php

namespace MvcLite\Models\Engine;

use MvcLite\Database\Engine\ORM\ORMSelection;
use MvcLite\Engine\Precepts\Naming;
use MvcLite\Models\Engine\Relationships\BelongsTo;
use MvcLite\Models\Engine\Relationships\HasMany;
use MvcLite\Models\Engine\Relationships\HasOne;

use Symfony\Component\String\Inflector\EnglishInflector;

class Model
{
    /** Model table name. */
    private string $tableName;

    /**
     * Public attributes that will be encoded
     * to JSON for View usage.
     */
    private array $publicAttributes;

    public function __construct()
    {
        $inflector = new EnglishInflector();

        $this->tableName = $inflector->pluralize(Naming::camelToSnake(Naming::getClassNameByObject($this)))[0];
        $this->publicAttributes = [];
    }

    /**
     * @return string Model table name
     */
    public function getTableName(): string
    {
        return $this->tableName;
    }

    /**
     * @param string $tableName New model table name
     * @return string New model table name
     */
    public function setTableName(string $tableName): string
    {
        return $this->tableName = $tableName;
    }

    /**
     * @return array Current public attributes
     */
    public function getPublicAttributes(): array
    {
        return $this->publicAttributes;
    }

    /**
     * Adds a new public attribute.
     *
     * @param string $key
     * @param mixed $value
     * @return array Updated public attributes array
     */
    public function addPublicAttribute(string $key, mixed $value): array
    {
        $this->publicAttributes[$key] = $value;

        return $this->getPublicAttributes();
    }

    /*
     * ******  MVCLite MODELS RELATIONSHIPS  ******
     */

    public function belongsTo(string $model, ?string $customTableName = null): ?Model
    {
        return (new BelongsTo($this, $model, $customTableName))
            ->run();
    }

    public function hasOne(string $model, ?string $customTableName = null): ?Model
    {
        return (new HasOne($this, $model, $customTableName))
            ->run();
    }

    public function hasMany(string $model, ?string $customTableName = null): array
    {
        return (new HasMany($this, $model, $customTableName))
            ->run();
    }

    /*
     * ************  MVCLite ORM PART  ************
     */

    public function select(string ...$columns): ORMSelection
    {
        if (!count($columns))
        {
            $columns = ['*'];
        }

        return new ORMSelection($this, $columns);
    }
}