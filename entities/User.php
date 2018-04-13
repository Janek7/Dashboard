<?php
/**
 * Created by PhpStorm.
 * User: Janek
 * Date: 07.04.2018
 * Time: 15:04
 */

require 'functions/database.php';
global $conn;

$sql = "SELECT u1.*, u2.name as verifier FROM users u1 LEFT JOIN users u2 ON u1.verified_by = u2.id";
$userlResult = $conn->query($sql);
$users = [];
global $users;
while ($row = $userlResult->fetch_assoc()) {
    array_push($users, new User($row));
}

foreach ($users as $user) {
    $userid = $user->getId();
    $getPermsString = "SELECT p.id FROM user_perms up JOIN perms p ON up.perm_id = p.id WHERE up.user_id = '$userid'";
    $permResult = $conn->query($getPermsString);
    while ($row = $permResult->fetch_assoc()) {
        $user->addPerm($row['id']);
    }
}

foreach ($users as $user) {
    $userid = $user->getId();
    $getRoles = "SELECT * FROM user_roles WHERE user_id = '$userid'";
    $roleResult = $conn->query($getRoles);
    while ($row = $roleResult->fetch_assoc()) {
        $user->addRole($row['role_id']);
    }
}

class User {

    private $id;
    private $name;
    private $email;
    private $regsiterDate;
    private $verfied;
    private $verifier;
    private $verifyDate;
    private $lastActivity;
    private $lastPage;
    private $perms;
    private $roles;

    function __construct($row) {
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->email = $row['email'];
        $this->regsiterDate = new DateTime();
        $this->regsiterDate->setTimestamp(strtotime($row['register_date']));
        $this->verfied = $row['verified'];
        $this->verifier = $row['verifier'];
        $this->verifyDate = new DateTime();
        $this->verifyDate->setTimestamp(strtotime($row['verify_date']));
        $this->lastActivity = new DateTime();
        $this->lastActivity->setTimestamp(strtotime($row['last_activity']));
        $this->lastPage = $row['last_page'];
        $this->perms = [];
        $this->roles = [];
    }
    
    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getEmail() {
        return $this->email;
    }

    public function getRegisterDate() {
        return $this->regsiterDate->format('Y-m-d H:i:s');
    }

    public function getVerified() {
        return $this->verfied;
    }

    public function getVerifier() {
        return $this->verifier;
    }

    public function getVerifyDate() {
        return $this->verifyDate->format('Y-m-d H:i:s');
    }

    public function getLastActivity() {
        return $this->lastActivity->format('Y-m-d H:i:s');
    }

    public function getLastPage() {
        return $this->lastPage;
    }


    public function getPerms() {
        return $this->perms;
    }

    public function addPerm($perm) {
        array_push($this->perms, $perm);
    }

    public function hasPerm($perm) {
        return in_array($perm, $this->perms);
    }


    public function getRoles() {
        return $this->roles;
    }

    public function addRole($role) {
        array_push($this->roles, $role);
    }

    public function hasRole($role) {
        return in_array($role, $this->roles);
    }


    public function getVerifiedLabelID() {
        return "verifiedLabel" . $this->id;
    }

}