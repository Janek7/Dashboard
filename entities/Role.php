<?php
/**
 * Created by PhpStorm.
 * User: Janek
 * Date: 11.04.2018
 * Time: 21:47
 */

global $conn;

$roles = [];
global $roles;
$sqlGetRoles = "SELECT * FROM roles";
$result = $conn->query($sqlGetRoles);
while ($row = $result->fetch_assoc()) {
    array_push($roles, new Role($row));
}

foreach ($roles as $role) {
    $roleid = $role->getId();
    $sqlGetPerms = "SELECT perm_id FROM perm_role_connections WHERE role_id = '$roleid'";
    $permResult = $conn->query($sqlGetPerms);
    while ($row = $permResult->fetch_assoc()) {
        $role->addPerm($row['perm_id']);
    }
}

class Role {

    private $id;
    private $name;
    private $perms;

    function __construct($row) {
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->perms = [];
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getPerms() {
        return $this->perms;
    }

    public function addPerm($perm) {
        array_push($this->perms, $perm);
    }

}

function getRoleFromId($id) {
    global $roles;
    foreach ($roles as $role) {
        if ($id == $role->getId()) {
            return $role;
        }
    }
    return null;
}
