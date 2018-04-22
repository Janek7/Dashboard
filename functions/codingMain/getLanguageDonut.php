<?php
/**
 * Created by PhpStorm.
 * User: Janek
 * Date: 22.04.2018
 * Time: 22:21
 */

require '../database.php';
global $conn;

$getLanguageFrequencys = "SELECT cl.name, COUNT(*) as freq FROM coding_project_languages cpl JOIN coding_languages cl 
                          ON cpl.language_id = cl.id GROUP BY cpl.language_id";
$sqlResult = $conn->query($getLanguageFrequencys);
$jsonString = "[";
while ($row = $sqlResult->fetch_assoc()) {
    $jsonString .= "{\"label\": \"" . $row['name'] . "\", \"value\": \"" . $row['freq'] . "\"}, ";
}
$jsonString = substr($jsonString, 0, -2) . "]";
echo $jsonString;