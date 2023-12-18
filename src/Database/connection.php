<?php

/*
 * connection.php
 * MVCLite by belicfr
 *
 * Please edit the connection information
 * to use your database properly.
 */

use MvcLite\Database\Engine\Database;
use MvcLite\Database\Engine\Exceptions\FailedConnectionToDatabaseException;

const DATABASE_CREDENTIALS = [

    "dbms"          =>  "mysql",

    "host"          =>  "localhost",
    "port"          =>  "3306",
    "name"          =>  "",
    "user"          =>  "",
    "password"      =>  ""

];


$db = (new Database(DATABASE_CREDENTIALS))->attemptConnection();

if (!$db)
{
    $error = new FailedConnectionToDatabaseException("Failed to connect to database.");
    $error->render();
}