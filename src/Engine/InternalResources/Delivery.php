<?php

namespace MvcLite\Engine\InternalResources;

use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\Security\Validator;
use MvcLite\Router\Engine\Request;

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

    /** Current request object. */
    private ?Request $request;

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

    public function __construct()
    {
        $this->request = new Request();
        $this->validator = new Validator($this->getRequest());
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
     * @param Validator $validator Validator instance
     */
    public function setValidator(Validator $validator): Delivery
    {
        $this->validator = $validator;

        return $this;
    }

    /**
     * Add global property to current delivery instance.
     *
     * @param string $key
     * @param mixed $value
     * @return Delivery Current delivery object
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
     * @return Request|null Current request object if exists;
     *                      else NULL
     */
    public function getRequest(): ?Request
    {
        return $this->request;
    }

    /**
     * @param Request $request Request instance
     */
    public function setRequest(Request $request): Delivery
    {
        $this->request = $request;

        return $this;
    }

    /**
     * @return bool If there is a request object
     */
    public function hasRequest(): bool
    {
        return $this->getRequest() !== null;
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