<?php
/**
 * Created by PhpStorm.
 * User: Janek
 * Date: 22.04.2018
 * Time: 14:34
 */

require 'database.php';
global $conn;

$descText = $_GET['descText'];
$projectId = $_GET['projectId'];
if (isset($descText) && isset($projectId)) {
    $sqlInsertDesc = "INSERT INTO coding_project_descriptions(project_id, text) VALUES('$projectId', '$descText')";
    $conn->query($sqlInsertDesc);

    $sqlGetNewDescId = "SELECT id FROM coding_project_descriptions ORDER BY id DESC LIMIT 1";
    $sqlResult = $conn->query($sqlGetNewDescId);
    if ($row = $sqlResult->fetch_assoc()) {
        $id = $row['id'];
        echo '{"id": "' . $id . '", "text":"' . $descText . '"}';
    }
} else {
    echo "error, kein Text oder Project ID angegeben";
}