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

if (isset($_GET['userid'])) {
    foreach (array_keys($_GET) as $role) {
        if ($role != "user") {
            $user = $_GET['userid'];
            if ($_GET[$role] == "add") {
                $insert = "INSERT INTO user_roles (role_id, user_id) VALUES ('$role', '$user')";
                $conn->query($insert);
            } elseif ($_GET[$role] == "remove") {
                $delete = "DELETE FROM user_roles WHERE role_id = '$role' AND user_id = '$user'";
                $conn->query($delete);
            }
        }
    }
} else {
    echo "error";
}