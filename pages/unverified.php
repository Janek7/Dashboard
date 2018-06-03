<?php
/**
 * Created by PhpStorm.
 * User: Janek
 * Date: 07.04.2018
 * Time: 13:57
 */

require '../functions/database.php';
global $conn;

if (isset($_POST['check_verify'])) {
    $userid = $_SESSION['userid'];
    $sql = "SELECT verified FROM users WHERE id = '$userid'";
    $verifiedResult = $conn->query($sql);
    $row = $verifiedResult->fetch_assoc();
    if ($row['verified'] == 1) {
        $_SESSION['verified'] = 1;
        header("Location: start");
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet"
          href="../adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="../adminlte/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="../adminlte/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../adminlte/dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../adminlte/plugins/iCheck/square/blue.css">

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
        <b>Verifizierung</b>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Dein Account wurde noch nicht verfiziert</p>

        <form action="../index.php" method="post">
            <div class="row">
                <!-- /.col -->
                <div class="col-xs-4">
                    <button style="margin-left: 80pt" name="check_verify" type="submit" class="btn btn-primary btn-block btn-flat">Prüfen</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
        <br/>
        <a href="login.php" class="text-center">Zurück zum Login</a>

    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- Eigene Scripts -->
<script src="../js/loginPage.js"></script>

<!-- jQuery 3 -->
<script src="../adminlte/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="../adminlte/plugins/iCheck/icheck.min.js"></script>
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