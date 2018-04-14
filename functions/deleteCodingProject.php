<?php
/**
 * Created by PhpStorm.
 * User: Janek
 * Date: 15.04.2018
 * Time: 00:21
 */

require 'database.php';
global $conn;
$projectid = $_GET['projectid'];

$sqlDeleteProject = "DELETE FROM coding_projects WHERE id = '$projectid'";
$conn->query($sqlDeleteProject);

$sqlDeleteProject = "DELETE FROM coding_project_languages WHERE project_id = '$projectid'";
$conn->query($sqlDeleteProject);

$sqlDeleteProject = "DELETE FROM coding_project_descriptions WHERE project_id = '$projectid'";
$conn->query($sqlDeleteProject);

header("Location: ../index.php");