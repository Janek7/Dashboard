<?php
require "../functions/database.php";
global $conn;
session_start();

//Prüft in welchem Pfad die Page aufgerufen wird -> Imports müssen auf den Pfad angepasst werden
$f = !file_exists("index.php");
//Register Request - Wurde Seite zum ersten mal aufgerufen oder mit Daten zum registrieren
$rr = isset($_POST['reg_user']);

$user = "";
$email = "";
$password = "";
$confirmedPassword = "";
$errors = [];

//Wird nur betreten wenn Skript nach Eingabe der Daten aufgerufen wird
if ($rr) {

    //Eingaben des Formulars aus Post mit DB günstigen Strings holen
    $user = mysqli_real_escape_string($conn, $_POST['userInput']);
    $email = mysqli_real_escape_string($conn, $_POST['emailInput']);
    $password = mysqli_real_escape_string($conn, $_POST['pwInput']);
    $confirmedPassword = mysqli_real_escape_string($conn, $_POST['pwcInput']);

    //Prüfen ob alles angegeben ist und Passwörter übereinstimmen
    //Falls nicht wird eine Fehlermeldung erzeugt
    if (empty($user)) array_push($errors, "Bitte gib einen Nutzernamen ein!");
    if (empty($email)) array_push($errors, "Bitte gib eine Email ein!");
    if (empty($password)) array_push($errors, "Bitte gib ein Passwort ein!");
    if (empty($confirmedPassword)) array_push($errors, "Bitte bestätige dein Passwort!");
    if ($password != $confirmedPassword && !empty($password) && !empty($confirmedPassword))
        array_push($errors, "Die Passwörter stimmen nicht überein");

    //Angegebene Daten mit Userdaten aus DB auf doppelte Werte prüfen
    $sql = "SELECT * FROM users WHERE name = '$user' OR email = '$email'";
    $checkUserEmailResult = $conn->query($sql);
    while ($row = $checkUserEmailResult->fetch_assoc()) {
        if ($row['name'] == $user) {
            array_push($errors, "Es existiert bereits ein Account mit dem Namen '$user'!");
        }
        if ($row['email'] == $email) {
            array_push($errors, "Es existiert bereits ein Account mit der Email '$email'!");
        }
    }


    //Wenn kein Fehler aufgetreten ist insert und weiterleiten
    if (count($errors) == 0) {
        //Eintragen
        $hashed_pw = password_hash($password, PASSWORD_DEFAULT);
        $insertQuery = "INSERT INTO users (name, email, password) VALUES('$user', '$email', '$hashed_pw')";
        $conn->query($insertQuery);
        //ID auslesen
        $useridResult = $conn->query("SELECT id FROM users WHERE name = '$user'");
        $result = $useridResult->fetch_assoc();
        global $_SESSION;
        $_SESSION['userid'] = $result['id'];
        $_SESSION['username'] = $user;
        $_SESSION['verified'] = false;

        header("Location: unverified.php");
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Registrierung | Dashboard</title>
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

<body class="hold-transition register-page">
<div class="register-box">
    <div class="register-logo">
        <b>Dashboard</b>
    </div>

    <div class="register-box-body">
        <p class="login-box-msg">Erstelle einen neuen Account</p>
        <form action="register.php" method="post">
            <div class="form-group has-feedback">
                <input name="userInput" type="text" class="form-control" placeholder="Name"
                    <?php if ($rr && isset($_POST['userInput'])) echo "value=\"" . $_POST['userInput'] . "\"" ?>>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input name="emailInput" type="email" class="form-control" placeholder="Email"
                    <?php if ($rr && isset($_POST['emailInput'])) echo "value=\"" . $_POST['emailInput'] . "\"" ?>>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input name="pwInput" type="password" class="form-control" placeholder="Password"
                    <?php if ($rr && isset($_POST['pwInput'])) echo "value=\"" . $_POST['pwInput'] . "\"" ?>>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input name="pwcInput" type="password" class="form-control" placeholder="Passwort bestätigen"
                    <?php if ($rr && isset($_POST['pwcInput'])) echo "value=\"" . $_POST['pwcInput'] . "\"" ?>>
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
                <!-- /.col -->
                <div class="col-xs-4">
                    <button name="reg_user" type="submit" class="btn btn-primary btn-block btn-flat">Registrieren
                    </button>
                </div>
                <!-- /.col -->
            </div>
        </form>
        <br/>
        <a href="login.php" class="text-center">Ich habe bereits einen Account</a>
    </div>
    <!-- /.form-box -->
</div>
<!-- /.register-box -->

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
