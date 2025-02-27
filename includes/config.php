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
define("HOST", "");     // The host you want to connect to.
define("USER", "");    // The database username. 
define("PASSWORD", "");    // The database password. 
define("DATABASE", "");    // The database name. 
define("CHARSET", "utf8mb4");    // The database name. 


$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
    PDO::MYSQL_ATTR_FOUND_ROWS => true,
];
$con = new PDO("mysql:host=" . HOST . ";dbname=" . DATABASE . ";charset=" . CHARSET, USER, PASSWORD, $options);
