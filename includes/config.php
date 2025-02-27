<?php

/**
 * SHOW OR HIDE ERRORS
 */
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL ^ E_DEPRECATED ^ E_WARNING);
*/
// error_reporting(E_ALL);

/**
 * DB CONFIG
 */
define("HOST", "localhost");     // The host you want to connect to.
define("USER", "username");    // The database username. 
define("PASSWORD", "password");    // The database password. 
define("DATABASE", "db_name");    // The database name. 
define("CHARSET", "utf8mb4");    // The database name. 


$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
    PDO::MYSQL_ATTR_FOUND_ROWS => true,
];
$con = new PDO("mysql:host=" . HOST . ";dbname=" . DATABASE . ";charset=" . CHARSET, USER, PASSWORD, $options);
