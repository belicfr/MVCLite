<?php

namespace MvcLite\Router\Engine;

use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Router\Engine\Exceptions\UndefinedInputException;

/**
 * Request manager class.
 *
 * @author belicfr
 */
class Request
{
    /**
     * Gets $_POST values and returns its neutralized version.
     *
     * @return array
     */
    public static function getInputs(): array
    {
        $inputs = [];

        foreach ($_POST as $inputKey => $inputValue)
        {
            $inputs[$inputKey] = htmlspecialchars($inputValue);
        }

        return $inputs;
    }

    public static function getInput(string $key, bool $neutralize = true): string
    {
        $input = self::getInputs()[$key];

        if ($input === null)
        {
            $error = new UndefinedInputException($key);
            $error->render();
        }

        return $neutralize
            ? $input
            : htmlspecialchars_decode($input);
    }
}