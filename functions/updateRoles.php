<?php
/**
 * Created by PhpStorm.
 * User: Janek
 * Date: 11.04.2018
 * Time: 23:02
 */

require 'database.php';
require '../entities/Role.php';
global $conn;
session_start();

if (isset($_GET['userid'])) {
    foreach (array_keys($_GET) as $roleId) {
        if ($roleId != "user") {
            $user = $_GET['userid'];
            if ($_GET[$roleId] == "add") {
                $insert = "INSERT INTO user_roles (role_id, user_id) VALUES ('$roleId', '$user')";
                $conn->query($insert);
                $role = getRoleFromId($roleId);
                foreach ($role->getPerms() as $permId) {
                    $insertPerm = "INSERT INTO user_perms (perm_id, user_id) VALUES ('$permId', '$user')";
                    $conn->query($insertPerm);
                }
            } elseif ($_GET[$roleId] == "remove") {
                $delete = "DELETE FROM user_roles WHERE role_id = '$roleId' AND user_id = '$user'";
                $conn->query($delete);
                $role = getRoleFromId($roleId);
                foreach ($role->getPerms() as $permId) {
                    $deletePerm = "DELETE FROM user_perms WHERE perm_id = '$permId' AND user_id = '$user'";
                    $conn->query($deletePerm);

                }
            }
        }
    }
} else {
    echo "error";
}