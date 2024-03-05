<?php

/*
 * connection.php
 * MVCLite by belicfr
 *
 * Please edit the connection information
 * to use your database properly.
 */

use MvcliteCore\Database\Database;
use MvcliteCore\Database\Exceptions\FailedConnectionToDatabaseException;

const DATABASE_CONNECTION_ERROR = "Database connection error";

$db = (new Database(DATABASE_CREDENTIALS))
    ->attemptConnection();

if (!$db)
{
    $error = new FailedConnectionToDatabaseException(DATABASE_CONNECTION_ERROR);

    if (isset($argc))
    {
        echo $error->getMessage();
        die;
    }

    $error->render();
}