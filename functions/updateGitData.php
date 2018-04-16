<?php
/**
 * Created by PhpStorm.
 * User: Janek
 * Date: 16.04.2018
 * Time: 21:09
 */

require 'database.php';
global $conn;

if (isset($_GET['projectid'])) {
    $projectId = $_GET['projectid'];
    $sqlUpdateGit = "UPDATE coding_projects ";
    $sets = 0;
    if (isset($_GET['gitClient'])) {
        $gitClient = $_GET['gitClient'];
        $sqlUpdateGit .= "SET git_client = '$gitClient' ";
        $sets++;
    }
    if (isset($_GET['repoName'])) {
        $repoName = $_GET['repoName'];
        if ($sets == 0) {
            $sqlUpdateGit .= "SET git_repo_name = '$repoName' ";
        } else {
            $sqlUpdateGit .= ", git_repo_name = '$repoName' ";
        }
        $sets++;
    }
    if (isset($_GET['repoLink'])) {
        $repoLink = $_GET['repoLink'];
        if ($sets == 0) {
            $sqlUpdateGit .= "SET git_repo_link = '$repoLink' ";
        } else {
            $sqlUpdateGit .= ", git_repo_link = '$repoLink' ";
        }
    }
    $sqlUpdateGit .= "WHERE id = '$projectId'";
    $conn->query($sqlUpdateGit);
    header("Location: ../index.php?page=codingProject&project=" . $_GET['projecttitle']);
} else {
    echo "error, kein Projekt angegeben";
}