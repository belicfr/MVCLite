<?php

namespace MvcLite\Models\Engine;

use JsonSerializable;
use MvcLite\Database\Engine\ORM\ORMSelection;
use MvcLite\Engine\Precepts\Naming;
use MvcLite\Models\Engine\Relationships\BelongsTo;
use MvcLite\Models\Engine\Relationships\HasMany;
use MvcLite\Models\Engine\Relationships\HasOne;

use Symfony\Component\String\Inflector\EnglishInflector;

class Model implements JsonSerializable
{
    /**
     * Public attributes that will be encoded
     * to JSON for View usage.
     */
    private array $publicAttributes;

    public function __construct()
    {
        $this->publicAttributes = [];
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

    /**
     * @return string Model table name
     */
    public static function getTableName(): string
    {
        $inflector = new EnglishInflector();

        return $inflector->pluralize(Naming::camelToSnake(Naming::getClassName(static::class)))[0];
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

    public static function select(string ...$columns): ORMSelection
    {
        if (!count($columns))
        {
            $columns = ['*'];
        }

        return new ORMSelection(static::class, $columns);
    }

    public static function getById(int $id, string ...$columns): ORMSelection
    {
        if (!count($columns))
        {
            $columns = ['*'];
        }

        $ormClause = new ORMSelection(static::class, $columns);
        $ormClause->where("id", $id);

        return $ormClause;
    }

    /*
     * ************ JSON SERIALIZATION ************
     */

    public function jsonSerialize(): mixed
    {
        return $this->getPublicAttributes();
    }
}