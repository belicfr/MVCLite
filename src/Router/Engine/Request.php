<?php

namespace MvcLite\Router\Engine;

use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Router\Engine\Exceptions\UndefinedInputException;
use MvcLite\Router\Engine\Exceptions\UndefinedParameterException;

/**
 * Request manager class.
 *
 * @author belicfr
 */
class Request
{
    /** Current request URI. */
    private string $uri;

    /** Current request inputs. */
    private array $inputs;

    /** Current request parameters. */
    private array $parameters;

    public function __construct()
    {
        $this->uri = $_SERVER["REQUEST_URI"];

        $this->saveInputs();
        $this->saveParameters();
    }

    /**
     * Gets $_POST values and returns its neutralized version.
     *
     * @return array Inputs array
     */
    private function saveInputs(): array
    {
        $inputs = [];

        foreach ($_POST as $inputKey => $inputValue)
        {
            $inputs[$inputKey] = htmlspecialchars($inputValue);
        }

        return $this->inputs = $inputs;
    }

    /**
     * @return array Current request inputs
     */
    public function getInputs(): array
    {
        return $this->inputs;
    }

    /**
     * @param string $key Input key
     * @param bool $neutralize If input value must be neutralized
     * @return string Input value
     */
    public function getInput(string $key, bool $neutralize = true): string
    {
        if (!in_array($key, array_keys($this->getInputs())))
        {
            $error = new UndefinedInputException($key);
            $error->render();
        }

        $input = $this->getInputs()[$key];

        return $neutralize
            ? $input
            : htmlspecialchars_decode($input);
    }

    /**
     * @return string Decoded current request URI
     */
    public function getUri(): string
    {
        return urldecode($this->uri);
    }

    /**
     * Gets $_GET values and returns them.
     *
     * @return array Parameters array
     */
    private function saveParameters(): array
    {
        return $this->parameters = $_GET;
    }

    /**
     * @return array Current request parameters
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @param string $key Parameter key
     * @return string Parameter value
     */
    public function getParameter(string $key): string
    {
        if (!in_array($key, array_keys($this->getParameters())))
        {
            $error = new UndefinedParameterException($key);
            $error->render();
        }

        return $this->getParameters()[$key];
    }
}