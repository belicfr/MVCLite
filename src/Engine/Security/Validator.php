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
     * @param array $inputs Key of the inputs to validate
     * @param string|null $error Custom error message
     * @return Validator Current validator object
     */
    public function required(array $inputs, ?string $error = null): Validator
    {
        $defaultError = "This input is required.";

        foreach ($inputs as $input)
        {
            $inputValue = $this->getRequest()->getInput($input);

            if ($inputValue === null)
            {
                $error = new UndefinedInputException($input);
                $error->render();
            }

            $isFilled = $inputValue !== null && strlen(trim($inputValue));

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
     * @param string $input Key of the input to confirm
     * @param string|null $error Custom error message
     * @return Validator Current validator object
     */
    public function confirmation(string $input, ?string $error = null): Validator
    {
        $defaultError =  "Passwords does not match.";

        $inputValue = $this->getRequest()->getInput($input);
        $confirmationValue = $this->getRequest()->getInput($input . "_confirmation");

        if ($inputValue === null)
        {
            $error = new UndefinedInputException($input);
            $error->render();
        }

        if ($confirmationValue === null)
        {
            $error = new UndefinedInputException($input . "confirmation");
            $error->render();
        }

        $isConfirmed = $inputValue == $confirmationValue;

        if (strlen($inputValue) && strlen($confirmationValue) && !$isConfirmed)
        {
            $this->addError("confirmation", $input, $error ?? $defaultError);
        }

        $this->validationState &= $isConfirmed;

        return $this;
    }

    /**
     * @param string $input Key of the input to validate
     * @param int $minLength Min length to apply
     * @param string|null $error Optional custom error message
     * @return $this Current validator instance
     */
    public function minLength(string $input, int $minLength, ?string $error = null): Validator
    {
        $defaultError = "This field must contain at least $minLength characters.";

        $inputValue = $this->getRequest()->getInput($input);

        if ($inputValue === null)
        {
            $error = new UndefinedInputException($input);
            $error->render();
        }

        $isRespectingGivenLength = strlen($inputValue) >= $minLength;

        if (strlen($inputValue) && !$isRespectingGivenLength)
        {
            $this->addError("minLength", $input, $error ?? $defaultError);
        }

        $this->validationState &= $isRespectingGivenLength;

        return $this;
    }

    /**
     * @param string $input Key of the input to validate
     * @param int $maxLength Max length to apply
     * @param string|null $error Optional custom error message
     * @return $this Current validator instance
     */
    public function maxLength(string $input, int $maxLength, ?string $error = null): Validator
    {
        $defaultError = "This field must contain at most $maxLength characters.";

        $inputValue = $this->getRequest()->getInput($input);

        if ($inputValue === null)
        {
            $error = new UndefinedInputException($input);
            $error->render();
        }

        $isRespectingGivenLength = strlen($inputValue) <= $maxLength;

        if (!$isRespectingGivenLength)
        {
            $this->addError("maxLength", $input, $error ?? $defaultError);
        }

        $this->validationState &= $isRespectingGivenLength;

        return $this;
    }

    /**
     * @param string $input Key of the input to validate
     * @param string $pattern RegEx to apply
     * @param string|null $error Optional custom error message
     * @return $this Current validator instance
     */
    public function matches(string $input, string $pattern, ?string $error = null): Validator
    {
        $defaultError = "This input is not valid.";

        $inputValue = $this->getRequest()->getInput($input);

        if ($inputValue === null)
        {
            $error = new UndefinedInputException($input);
            $error->render();
        }

        $isMatchingPattern = preg_match($pattern, $inputValue);

        if (!$isMatchingPattern)
        {
            $this->addError("matches", $input, $error ?? $defaultError);
        }

        $this->validationState &= $isMatchingPattern;

        return $this;
    }

    /**
     * @param string $input Key of the input to validate
     * @param string|null $error Optional custom error message
     * @return $this Current validator instance
     */
    public function email(string $input, ?string $error = null): Validator
    {
        $defaultError = "This email address is not valid.";

        $inputValue = $this->getRequest()->getInput($input);

        if ($inputValue === null)
        {
            $error = new UndefinedInputException($input);
            $error->render();
        }

        $isValidEmailAddress = filter_var($inputValue, FILTER_VALIDATE_EMAIL) == $inputValue;

        if (strlen($inputValue) && !$isValidEmailAddress)
        {
            $this->addError("email", $input, $error ?? $defaultError);
        }

        $this->validationState &= $isValidEmailAddress;

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
        $this->errors[$input][$rule] = $message;
        return $this;
    }

    /**
     * @param string $input
     * @param string $rule
     * @return bool If given input does not respect given
     *              rule.
     */
    public function hasError(string $input, string $rule): bool
    {
        return isset($this->getErrors()[$input][$rule]);
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