<?php
/**
 * Created by PhpStorm.
 * User: Janek
 * Date: 04.04.2018
 * Time: 22:07
 */

if (file_exists("index.php")) {
    require 'config.php';
} else {
    require '../config.php';
}
global $configuration;

$conn = MySQLi_connect(
    $configuration['database']['hostname'],
    $configuration['database']['username'],
    $configuration['database']['password'],
    $configuration['database']['dbname']
);

//Check connection
if (MySQLi_connect_errno()) echo "Failed to connect to MySQL: " . MySQLi_connect_error();
