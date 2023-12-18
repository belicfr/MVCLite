<?php

namespace MvcLite\Engine\Security;

use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Router\Engine\Exceptions\UndefinedInputException;
use MvcLite\Router\Engine\Request;

/**
 * Validation class.
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

        $this->initializeRule("required");
        $this->initializeRule("confirmation");
    }

    /**
     * Returns if all given fields are filled:
     *  - not nulls
     *  - not empty strings
     *
     * @param array $values Values to validate
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
                $this->errors["required"][$input] = $error ?? $defaultError;
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

        Debug::dd($inputValue, $confirmationValue);

        $isConfirmed = $inputValue == $confirmationValue;

        if (!$isConfirmed)
        {
            $this->errors["confirmation"][$input] = $error ?? $defaultError;
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
        return count($this->getErrors());
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
}