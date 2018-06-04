<?php
require "../functions/database.php";
global $conn;
session_start();

//Prüft in welchem Pfad die Page aufgerufen wird -> Imports müssen auf den Pfad angepasst werden
$f = !file_exists("index.php");
//Login Request - Wurde Seite zum ersten mal aufgerufen oder mit Daten zum registrieren
$lr = isset($_POST['log_user']);

$user = "";
$password = "";
$errors = [];

//Wird nur betreten wenn Skript nach Eingabe der Daten aufgerufen wird
if ($lr) {

    //Eingaben des Formulars aus Post mit DB günstigen Strings holen
    $user = mysqli_real_escape_string($conn, $_POST['userInput']);
    $password = mysqli_real_escape_string($conn, $_POST['pwInput']);

    //Prüfen ob alles angegeben ist und Passwörter übereinstimmen
    //Falls nicht wird eine Fehlermeldung erzeugt
    if (empty($user)) array_push($errors, "Bitte gib einen Nutzernamen ein!");
    if (empty($password)) array_push($errors, "Bitte gib ein Passwort ein!");

    if (count($errors) == 0) {
        $hashed_pw = password_hash($password, PASSWORD_DEFAULT);
        //Angegebene Daten mit Userdaten aus DB prüfen
        $sql = "SELECT id, password, verified FROM users WHERE name = '$user'";
        $userResult = $conn->query($sql);
        if ($result = $userResult->fetch_assoc()) {
            echo $password . " " . $result['password'];
            if (password_verify($password, $result['password'])) {
                $_SESSION['userid'] = $result['id'];
                $_SESSION['username'] = $user;
                $_SESSION['verified'] = $result['verified'];
                $sqlUpdateString = "UPDATE users SET logins = logins + 1 WHERE id = '" . $result['id'] . "';";
                $conn->query($sqlUpdateString);
                header("Location: start");
            } else {
                array_push($errors, "Das Passwort ist falsch!");
            }
        } else {
            array_push($errors, "Es existiert kein User mit dem Name '$user'!");
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Log in | Dashboard</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?php if ($f) echo "../" ?>images/favicon.ico">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet"
          href="<?php if ($f) echo "../" ?>adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="<?php if ($f) echo "../" ?>adminlte/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php if ($f) echo "../" ?>adminlte/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php if ($f) echo "../" ?>adminlte/dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php if ($f) echo "../" ?>adminlte/plugins/iCheck/square/blue.css">

    <!-- Eigenes File für Fehler -->
    <link rel="stylesheet" href="../css/userAuth.css">

    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <b>Dashboard</b>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Melde dich an um zu starten</p>

        <form action="../login" method="post">
            <div class="form-group has-feedback">
                <input name="userInput" type="text" class="form-control" placeholder="Name"
                    <?php if ($lr && isset($_POST['userInput'])) echo "value=\"" . $_POST['userInput'] . "\"" ?>>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input name="pwInput" type="password" class="form-control" placeholder="Passwort"
                    <?php if ($lr && isset($_POST['pwInput'])) echo "value=\"" . $_POST['pwInput'] . "\"" ?>>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <?php if (count($errors) > 0) : ?>
                <div class="error-box">
                    <p class="error-header">Achtung!</p>
                    <?php foreach ($errors as $error) : ?>
                        <p><?php echo $error ?></p>
                    <?php endforeach ?>
                </div>
            <?php endif ?>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox"> An Daten erinnern
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button name="log_user" type="submit" class="btn btn-primary btn-block btn-flat">Login</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

        <a id="forgotPW">Passwort vergessen</a><br>
        <a href="<?php if (!$f) echo "pages/" ?>register" class="text-center">Registrieren</a>

    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- Eigene Scripts -->
<script src="../js/loginPage.js"></script>

<!-- jQuery 3 -->
<script src="<?php if ($f) echo "../" ?>adminlte/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php if ($f) echo "../" ?>adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?php if ($f) echo "../" ?>adminlte/plugins/iCheck/icheck.min.js"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' /* optional */
        });
    });
</script>
</body>
</html>
