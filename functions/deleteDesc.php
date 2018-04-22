<?php
/**
 * Created by PhpStorm.
 * User: Janek
 * Date: 22.04.2018
 * Time: 14:12
 */

require 'database.php';
global $conn;

$descid = $_GET['descid'];
if (isset($descid)) {
    $sqlDeleteDesc = "DELETE FROM coding_project_descriptions WHERE id = '$descid'";
    echo $sqlDeleteDesc;
    $conn->query($sqlDeleteDesc);
} else {
    echo "error, keine Desc ID angegeben";
}