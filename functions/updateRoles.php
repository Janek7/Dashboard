<?php
/**
 * Created by PhpStorm.
 * User: Janek
 * Date: 11.04.2018
 * Time: 23:02
 */

require 'database.php';
global $conn;
session_start();

foreach ($_GET as $get) {
    echo $get;
}