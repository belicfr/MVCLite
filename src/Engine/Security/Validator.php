<?php

namespace MvcLite\Engine\Security;

use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Router\Engine\Exceptions\UndefinedInputException;
use MvcLite\Router\Engine\Request;

/**
 * Validation class.
 *
 * This class allows developer to validate POST
 * inputs following established and punctual rules.
 *
 * @author belicfr
 */
class Validator
{
    /** Current request object. */
    private Request $request;

    /** Current rules validation state. */
    private bool $validationState;

    /** Current rules validation error messages. */
    private array $errors;

    public function __construct(Request $request)
    {
        $this->request = $request;

        $this->validationState = true;
        $this->errors = [];

        /*
        $this->initializeRule("required");
        $this->initializeRule("confirmation");
        */
    }

    /**
     * Returns if all given fields are filled:
     *  - not nulls
     *  - not empty strings
     *
     * @param array $inputs Values to validate
     * @param string|null $error Custom error message
     * @return Validator Current validator object
     */
    public function required(array $inputs, ?string $error = null): Validator
    {
        $defaultError = " input is required.";

        foreach ($inputs as $input)
        {
            $inputValue = $this->request->getInput($input);

            if ($inputValue === null)
            {
                $error = new UndefinedInputException($input);
                $error->render();
            }

            $isFilled = $inputValue !== null && strlen($inputValue);

            if (!$isFilled)
            {
                $this->addError("required", $input, $error ?? $defaultError);
            }

            $this->validationState &= $isFilled;
        }

        return $this;
    }

    /**
     * Returns if given inputs match.
     *
     * @param string $input Input to confirm
     * @param string|null $error Custom error message
     * @return Validator Current validator object
     */
    public function confirmation(string $input, ?string $error = null): Validator
    {
        $defaultError =  "Passwords does not match.";

        $inputValue = $this->request->getInput($input);
        $confirmationValue = $this->request->getInput($input . "_confirmation");

        $isConfirmed = $inputValue == $confirmationValue;

        if (!$isConfirmed)
        {
            $this->addError("confirmation", $input, $error ?? $defaultError);
        }

        $this->validationState &= $isConfirmed;

        return $this;
    }

    /**
     * @return array Error messages
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return bool If there are errors
     */
    public function hasFailed(): bool
    {
        $errorsCount = 0;
        
        foreach ($this->errors as $rule)
        {
            $errorsCount += count($rule);
        }
        
        return $errorsCount;
    }

    /**
     * Add a custom error to validator object.
     *
     * @param string $rule Rule name
     * @param string $input Input name
     * @param string $message Error message
     * @return $this Current validator object
     */
    public function addError(string $rule, string $input, string $message): Validator
    {
        $this->errors[$input][$rule][] = $message;

        return $this;
    }

    /**
     * Validator rule initialization.
     *
     * @param string $rule Rule name
     */
    private function initializeRule(string $rule): void
    {
        $this->errors[$rule] = [];
    }

    /**
     * @return Request Stored Request object
     */
    public function getRequest(): Request
    {
        return $this->request;
    }
}