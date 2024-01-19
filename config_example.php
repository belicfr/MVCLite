<?php

const ROUTE_PATH_PREFIX = '/website/';

const DATABASE_CREDENTIALS = [

    "dbms"      =>  "mysql",

    "host"      =>  "localhost",
    "port"      =>  "3306",
    "charset"   =>  "utf8mb4",
    "name"      =>  "festiplan",
    "user"      =>  "utilisateur_festiplan",
    "password"  =>  "US3RfEs.T1PL4N."

];

const AUTHENTIFICATION_COLUMNS = [

    "table"     => "utilisateur",

    "id"        => "id_utilisateur",
    "login"     => "login_uti",
    "password"  => "mdp_uti",

];