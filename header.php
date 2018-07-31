<html>
<head>
    <link rel="stylesheet" href="assets/bootstrap.min.css">
    <link rel="stylesheet" href="assets/bootstrap-theme.min.css">
<?php

session_start();
require_once 'DBHelper.php';

$db_helper = new DBHelper('localhost', 'simple_ticket', 'root', '');

function check_login($show_login=false){
    $l = isset($_SESSION['login']) && $_SESSION['login'] === true;
    if (!$show_login)
        return $l;
    if (!$l){
        header('location: /login.php');
        die;
    }
    return $l;
}
?>
</head>

<body>
    <nav class="navbar navbar-default">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Simple Ticket</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="/">Home</a></li>
                </ul>
                <form class="navbar-form navbar-left">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Search">
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>

                <ul class="nav navbar-nav navbar-right">
                    <?php
                    if(!check_login()){
                        echo "<li><a href=\"/login.php\">Login</a></li>";
                        echo "<li><a href=\"/register.php\">Register</a></li>";
                    } else {
                        echo "
                    <li class=\"dropdown\">
                        <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\">".$_SESSION['user']['name']." <span class=\"caret\"></span></a>
                        <ul class=\"dropdown-menu\">
                            <li><a href=\"/profile.php\">Profile</a></li>
                            <li role=\"separator\" class=\"divider\"></li>
                            <li><a href=\"/logout.php\">Logout</a></li>
                        </ul>
                    </li>
                        ";
                    }
                    ?>

                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
    <div class="container">
    <?php
    if (isset($_SESSION['message'])){
        echo "<div class=\"alert alert-success\">".$_SESSION['message']."</div>";
        unset($_SESSION['message']);
    }
    ?>