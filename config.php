<?php

const ROUTE_PATH_PREFIX = '/';

const DATABASE_CREDENTIALS = [

    "dbms"      =>  "mysql",

    "host"      =>  "localhost",
    "port"      =>  "3306",
    "charset"   =>  "utf8mb4",
    "name"      =>  "mvclite_test",
    "user"      =>  "root",
    "password"  =>  "",

];

const AUTHENTIFICATION_COLUMNS = [

    "table"     => "users",

    "id"        => "id_user",
    "login"     => "name",
    "password"  => "password",

];