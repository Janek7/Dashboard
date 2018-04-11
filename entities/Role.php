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

class Role {

    private $id;
    private $name;

    function __construct($row) {
        $this->id = $row['id'];
        $this->name = $row['name'];
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

}