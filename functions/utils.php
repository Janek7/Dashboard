<?php
/**
 * Created by PhpStorm.
 * User: Janek
 * Date: 01.04.2018
 * Time: 22:58
 * @param $pagename
 * @return string
 */

require 'database.php';
global $conn;

function getPage() {
    //index.php?page=example

    global $pages;
    if (isset($_GET['page'])) {
        $pagename = $_GET['page'];
        $path = "pages/" . $pagename . ".php";
        if (!file_exists($path)) {
            $pagename = "error";
        }
        return $pages[$pagename];
    } else {
        return $pages['main'];
    }
}

function logLastActivity($page) {
    $userid = $_SESSION['userid'];
    $lastPage = $page->getNavText();
    $sql = "UPDATE users SET last_page = '$lastPage', last_activity = CURRENT_TIMESTAMP() WHERE id = '$userid'";
    global $conn;
    $conn->query($sql);
}
