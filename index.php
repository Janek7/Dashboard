<?php
include "functions/utils.php";
include 'entities/Page.php';

//if session[user] == leer -> page = login bzw register
if (!isset($_SESSION['userid'])) {
    require "pages/login.php";
    exit(0);
}
$page = getPage();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php $page->getTitle()?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="adminlte/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="adminlte/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="adminlte/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="adminlte/dist/css/skins/_all-skins.min.css">

    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <!-- Spezielle Sheets -->
    <?php
    if ($page->hasExtraSheets()) {
        echo $page->getExtraSheets();
    }
    ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <header class="main-header">
        <!-- Logo -->
        <a href="index.php?page=pages/main.php" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>D</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg">Dashboard</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li>
                        <a><span id="time"></span></a>
                    </li>
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="adminlte/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                            <span class="hidden-xs">Janek</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="adminlte/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                                <p>Janek - Developer</p>
                            </li>
                            <!-- Menu Body -->
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="images/user.png" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p>Janek</p>
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>
            <!-- /.search form -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header">Menü</li>

                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-code"></i> <span>Proggen</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href=""><i class="fa fa-table"></i>Übersicht</a></li>
                        <li><a target="_blank" href="https://github.com/Janek7"><i class="fa fa-code-fork"></i>Git</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="">
                        <i class="fa fa-book"></i>
                        <span>Hochschule</span>
                    </a>
                </li>

                <li>
                    <a href="index.php?page=test">
                        <i class="fa fa-cog"></i>
                        <span>Test</span>
                    </a>
                </li>

                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-car"></i> <span>Fahrten</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href=""><i class="fa fa-calendar"></i>Timeline</a></li>
                        <li><a href=""><i class="fa fa-train"></i>Zug</a></li>
                        <li><a href=""><i class="fa fa-subway"></i>S-Bahn / Bus</a></li>
                    </ul>
                </li>

                <li>
                    <a href="#">
                        <i class="fa fa-sticky-note"></i>
                        <span>Notizen</span>
                        <span class="pull-right-container">
                            <span class="label label-primary pull-right">4</span>
                        </span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <i class="fa fa-check-square-o"></i>
                        <span>Todo</span>
                        <span class="pull-right-container">
                            <span class="label label-warning pull-right">2</span>
                        </span>
                    </a>
                </li>

                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-gamepad"></i> <span>Minigames</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a target="_blank" href="https://janek7.github.io/Minesweeper/index.html"><i
                                        class="fa fa-bomb"></i>Minesweeper</a>
                        </li>
                    </ul>
                </li>

                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-file"></i>
                        <span>Changelog</span>
                    </a>
                </li>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <?php
                echo $page->getHeader();
                ?>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active"><?php echo $page->getNavText()?></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <?php
            echo $page->getContent();
            ?>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.0
        </div>
        <strong>Copyright &copy; 2018 <a href="https://github.com/Janek7">Janek</a>.</strong> All rights
        reserved.
    </footer>
    <!-- ./wrapper -->

    <!-- Eigenes JS -->
    <script src="js/indexPage.js"></script>

    <!-- jQuery 3 -->
    <script src="adminlte/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="adminlte/bower_components/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.7 -->
    <script src="adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Morris.js charts -->
    <script src="adminlte/bower_components/raphael/raphael.min.js"></script>
    <script src="adminlte/bower_components/morris.js/morris.min.js"></script>
    <!-- Sparkline -->
    <script src="adminlte/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="adminlte/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="adminlte/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="adminlte/bower_components/moment/min/moment.min.js"></script>
    <script src="adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- datepicker -->
    <script src="adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- Slimscroll -->
    <script src="adminlte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="adminlte/bower_components/fastclick/lib/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="adminlte/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="adminlte/dist/js/pages/dashboard.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="adminlte/dist/js/demo.js"></script>

</div>
</body>
</html>