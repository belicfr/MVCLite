<?php

namespace MvcLite\Database\Engine;

use Exception;
use PDO;

/**
 * Database manager class.
 *
 * @author belicfr
 */
class Database
{
    /** Database credentials. */
    private array $credentials;

    public function __construct(array $credentials)
    {
        $this->credentials = $credentials;
    }

    /**
     * Try to connect to database with given credentials.
     *
     * @return bool|PDO PDO object if attempt is successful;
     *                  else FALSE
     */
    public function attemptConnection(): bool|PDO
    {
        $database = null;

        try
        {
            $databaseInformation = $this->credentials["dbms"]
                                 . ":host="
                                 . $this->credentials["host"]
                                 . ";port="
                                 . $this->credentials["port"]
                                 . ";dbname="
                                 . $this->credentials["name"];

            $database = new PDO($databaseInformation,
                                $this->credentials["user"],
                                $this->credentials["password"]);

            $state = true;
        }
        catch (Exception $e)
        {
            $state = false;
        }

        return $state
            ? $database
            : false;
    }

    /**
     * Returns a new DatabaseQuery instance with given SQL query.
     *
     * @param string $sqlQuery
     * @return DatabaseQuery
     */
    public static function query(string $sqlQuery, mixed ...$parameters): DatabaseQuery
    {
        return new DatabaseQuery($sqlQuery, $parameters);
    }
}