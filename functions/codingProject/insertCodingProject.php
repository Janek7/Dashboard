<?php
/**
 * Created by PhpStorm.
 * User: Janek
 * Date: 14.04.2018
 * Time: 15:29
 */

require '../database.php';
global $conn;
session_start();
$userid = $_SESSION['userid'];

$title = $_POST['title'];
$startDate = date_create_from_format("Y-m-d", $_POST['startDate']);
$startDate = $startDate->getTimestamp();
echo $startDate;
$languages = [];
foreach ($_POST['languages'] as $selectedLanguage) {
    array_push($languages, $selectedLanguage);
}
$mainLanguage = $_POST['mainLanguage'];
$gitClient = $_POST['gitclient'];
$gitRepoLink = $_POST['gitRepoLink'];
$gitRepoName = $_POST['gitRepoName'];
$state = $_POST['state'];

$sqlInsertProject = "INSERT INTO coding_projects (user_id, title, start_date, git_client, git_repo_link, git_repo_name, state)
                      VALUES ('$userid', '$title', FROM_UNIXTIME($startDate), '$gitClient', '$gitRepoLink', '$gitRepoName', '$state')";
echo $sqlInsertProject;
$conn->query($sqlInsertProject);

$sqlGetProjectId = "SELECT id FROM coding_projects ORDER BY id DESC limit 1";
$idResult = $conn->query($sqlGetProjectId);
$id = null;
if ($row = $idResult->fetch_assoc()) {
    $id = $row['id'];
}
foreach ($languages as $language) {
    $sqlInsertLanguage = "INSERT INTO coding_project_languages (language_id, project_id, main) 
                          VALUES ('$language', '$id', '" . ($language == $mainLanguage ? "1" : "0") . "')";
    $conn->query($sqlInsertLanguage);
}

header("Location: ../../index.php?page=codingProjects&project=$title");