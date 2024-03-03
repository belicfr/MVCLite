<?php

const ROUTE_PATH_PREFIX = '/';

const DATABASE_CREDENTIALS = [

    "dbms"      =>  "mysql",

    "host"      =>  "localhost",
    "port"      =>  "3306",
    "charset"   =>  "utf8mb4",
    "name"      =>  "",
    "user"      =>  "",
    "password"  =>  ""

];

const AUTHENTIFICATION_COLUMNS = [

    "table"     => "users",

    "login"     => "name",
    "password"  => "password",

];

const API_COLUMNS = [

    "keys_table"    => "api_keys",

];

const PREFERENCES = [

    "render_mvclite_exceptions"     => true,

];