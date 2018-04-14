<?php
/**
 * Created by PhpStorm.
 * User: Janek
 * Date: 14.04.2018
 * Time: 23:21
 */

require '../entities/CodingProject.php';
require 'database.php';
global $conn;
global $codingProjects;

if (isset($_GET['newtitle']) && isset($_GET['projectid'])) {
    $newtitle = $_GET['newtitle'];
    $projectid = $_GET['projectid'];
    $project = getProjectFromId($projectid);
    $project->setTitle($newtitle);
    $sqlUpdateTitle = "UPDATE coding_projects SET title = '$newtitle' WHERE id = '$projectid'";
    $conn->query($sqlUpdateTitle);
} else {
    echo "error";
}