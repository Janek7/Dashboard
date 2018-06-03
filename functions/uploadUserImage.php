<?php
/**
 * Created by PhpStorm.
 * User: Janek
 * Date: 01.06.2018
 * Time: 22:41
 */

session_start();
global $conn;

$sqlUpdateString = "UPDATE users SET icon = '" . $_POST['userImageLink'] . "' WHERE id = '" . $_SESSION['userid'] . "';";
$conn->query($sqlUpdateString);

header("Location: start");

//Code zum Speichern eines über Formular hochgeladenen Bildes
/*echo "<pre>";
echo "POST:";
print_r($_POST);
echo "FILES:";
print_r($_FILES);
echo "</pre>";
//echo sys_get_temp_dir();

$info = pathinfo($_FILES['userimage']['name']);
$newname = $_SESSION['userid'] . "." . $info['extension'];
$target = __DIR__ . "/.." . '/images/uploadedUserIcons/'.$newname;

echo is_uploaded_file($_FILES['userimage']['tmp_name']) . " " . file_exists($_FILES['userimage']['tmp_name']) . "<br/>";
echo $_FILES['userimage']['tmp_name'] . "<br/>" . $target . "<br/>";

if (move_uploaded_file($_FILES['userimage']['tmp_name'], $target)) {
    echo "Datei ist valide und wurde erfolgreich hochgeladen.\n";
    header("Location: start");
} else {
    echo "error";
}*/