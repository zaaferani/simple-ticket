<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 7/31/2018
 * Time: 9:14 AM
 */

require_once 'header.php';

if (check_login()){
    header('location: /index.php');
    die;
}

$error = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $res = $db_helper->checkLogin($_POST['username'], $_POST['password']);
    if ($res){
        $_SESSION['login'] = true;
        $_SESSION['user'] = $res;
        $_SESSION['message'] = "$res[family], Welcome!";
        header('location: index.php');
        die;
    } else {
        $error = true;
    }
}
?>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
    <?php
        if ($error){
    ?>
            <div class="alert alert-danger">username of password is incorrect</div>
    <?php
        }
    ?>
        <form class="form-horizontal" action="/login.php" method="post">
            <div class="form-group">
                <label for="inputUsername3" class="col-sm-2 control-label">Username</label>
                <div class="col-sm-10">
                    <input name="username" type="text" class="form-control" id="inputUsername3" placeholder="Username">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
                <div class="col-sm-10">
                    <input name="password" type="password" class="form-control" id="inputPassword3" placeholder="Password">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default">Sign in</button>
                </div>
            </div>
        </form>
    </div>
</div>