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

function getPage($user) {
    //index.php?page=example
    global $pages;
    if (isset($_GET['page'])) {
        $pagename = $_GET['page'];
        $path = "pages/" . $pagename . ".php";
        if (!file_exists($path)) {
            $pagename = "error";
        }
        $page = $pages[$pagename];
        $viewPerm = $page->getViewPerm();
        if ($user->hasPerm($viewPerm) || $viewPerm == null) {
            return $pages[$pagename];
        } else {
            return $pages['noperms'];
        }
    } else {
        return $pages['main'];
    }
}

function getUser() {
    global $users;
    foreach ($users as $user) {
        if ($user->getId() == $_SESSION['userid']) {
            return $user;
        }
    }
}

function logLastActivity($page) {
    $userid = $_SESSION['userid'];
    $lastPage = $page->getNavText();
    $sql = "UPDATE users SET last_page = '$lastPage', last_activity = CURRENT_TIMESTAMP() WHERE id = '$userid'";
    global $conn;
    $conn->query($sql);
}

function getGitIcon($project) {
    $gitIcon = null;
    switch ($project['git_client']) {
        case "Github":
            $gitIcon = "fa-github";
            break;
        case "Bitbucket":
            $gitIcon = "fa-bitbucket";
            break;
        default:
            $gitIcon = "fa-code-fork";
    }
    return $gitIcon;
}
