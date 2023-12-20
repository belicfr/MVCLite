<?php

namespace MvcLite\Engine\InternalResources;

use ArrayObject;
use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\Security\Validator;

/**
 * Delivery management class.
 *
 * @author belicfr
 */
class Delivery
{
    /** Key used to store delivery data in $_POST. */
    public const DELIVER_POST_KEY = "internal_delivery";

    /** Current validator object. */
    private ?Validator $validator;

    /** Current global properties array. */
    private array $props;

    /**
     * @return Delivery Current delivery object if exists;
     *                  else NULL
     */
    public static function get(): Delivery
    {
        return unserialize($_SESSION[self::DELIVER_POST_KEY]);
    }

    public function __construct(?Validator $validator = null)
    {
        $this->validator = $validator;
        $this->props = [];
    }

    /**
     * @return bool If there is a validator stored in
     */
    public function hasValidator(): bool
    {
        return $this->validator !== null;
    }

    /**
     * @return Validator|null Validator instance if exists;
     *                        else NULL
     */
    public function getValidator(): ?Validator
    {
        return $this->validator;
    }

    /**
     * Add global property to current delivery instance.
     *
     * @param string $key
     * @param mixed $value
     * @return $this Current delivery object
     */
    public function add(string $key, mixed $value): Delivery
    {
        $this->props[$key] = $value;

        return $this;
    }

    /**
     * @return array Global properties array
     */
    public function getProps(): array
    {
        return $this->props;
    }

    /**
     * Store in session variable the current delivery instance serialized.
     *
     * @return Delivery Current delivery object
     */
    public function save(): Delivery
    {
        $_SESSION[self::DELIVER_POST_KEY] = serialize($this);

        return $this;
    }
}