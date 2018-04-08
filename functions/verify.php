<?php
/**
 * Created by PhpStorm.
 * User: Janek
 * Date: 08.04.2018
 * Time: 02:03
 */

require 'database.php';
global $conn;
session_start();

if (isset($_GET['verify'])) {
    $sql = "UPDATE users  SET verified = ";
    if ($_GET['verify'] == "true") {
        $sql .= "'1', verified_by = '" . $_SESSION['userid'] . "', verify_date = CURRENT_TIMESTAMP()";
    } else {
        $sql .= "'0', verified_by = null, verify_date = null";
    }
    $targetUserID = $_GET['userid'];
    $sql .= " WHERE id = '$targetUserID'";
    $conn->query($sql);

    //Rückgabe in JSON
    $json = '{"data-verified": "' . $_GET['verify'] . '"';
    if ($_GET['verify'] == "true") {
        $json .= ', "data-verifier": "' . $_SESSION['userid'] . '", "data-verifyDate": "' . date('Y-m-d H:i:s') . '"';
    }
    echo $json . "}";
} else {
    echo "verify error";
}