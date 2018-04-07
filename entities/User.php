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



    public function getVerifiedLabelID() {
        return "verifiedLabel" . $this->id;
    }

}