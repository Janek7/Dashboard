<?php
/**
 * Created by PhpStorm.
 * User: Janek
 * Date: 16.04.2018
 * Time: 18:19
 */

require '../database.php';
global $conn;

$projectTitle = $_POST['projectTitle'];
$projectId = $_POST['projectId'];
$workstepText = $_POST['workstepText'];
$startDate = date_create_from_format("Y-m-d H:i:s", str_replace("T", " ", $_POST['startDate']));
$startDate = $startDate->getTimestamp();
$endDate = date_create_from_format("Y-m-d H:i:s", str_replace("T", " ", $_POST['endDate']));
$endDate = $endDate->getTimestamp();

if (isset($workstepText) && isset($startDate) && isset($endDate)) {
    $sqlInsertCodingWorkstep = "INSERT INTO coding_worksteps(project_id, text, start_date, end_date)
                                VALUES('$projectId', '$workstepText', FROM_UNIXTIME($startDate), FROM_UNIXTIME($endDate))";
    $conn->query($sqlInsertCodingWorkstep);
} else {
    echo "error, ungültige Parameter";
}

header("Location: coding/project/$projectTitle");