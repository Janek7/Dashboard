<?php
/**
 * Created by PhpStorm.
 * User: Janek
 * Date: 14.04.2018
 * Time: 23:57
 */

require '../entities/CodingProject.php';
require 'database.php';
global $conn;
global $codingProjects;

if (isset($_GET['newstate']) && isset($_GET['projectid'])) {
    $newstate = $_GET['newstate'];
    $projectid = $_GET['projectid'];
    $project = getProjectFromId($projectid);
    $project->setState($newstate);
    $sqlUpdateState = "UPDATE coding_projects SET state = '$newstate' WHERE id = '$projectid'";
    $conn->query($sqlUpdateState);
} else {
    echo "error";
}