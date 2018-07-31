<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 7/31/2018
 * Time: 9:51 AM
 */

require_once 'header.php';

if (check_login()){
    header('location: /index.php');
    die;
}

$error = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (strlen($_POST['password']) < 3){
        array_push($error, 'password must at least 3 characters length');
    }
    if ($_POST['password'] != $_POST['re-password']){
        array_push($error, 're password not match with password');
    }
    if ($db_helper->checkUsername($_POST['username'])){
        array_push($error, 'this username already taken');
    }
    if ($db_helper->checkEmail($_POST['email'])){
        array_push($error, 'this email already taken');
    }
    if (!$error){
        $user_id  = $db_helper->insertUser([
            "name" => $_POST['name'],
            "family" => $_POST['family'],
            "email" => $_POST['email'],
            "username" => $_POST['username'],
            "password" => $_POST['password'],
            "type" => 'USER',
        ]);
        if ($user_id > 0){
            $res = $db_helper->getUser($user_id);
            $_SESSION['login'] = true;
            $_SESSION['user'] = $res;
            $_SESSION['message'] = "$res[family], Welcome!";
            header('location: index.php');
            die;
        } else {
            array_push($error, 'error in register! try again');
        }
    }
}


?>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <?php
        if ($error){
            foreach ($error as $item) {
                ?>
                <div class="alert alert-danger"><?php echo $item; ?></div>
                <?php
            }
        }
        ?>
        <form class="form-horizontal" action="/register.php" method="post">
            <div class="form-group">
                <label for="inputName3" class="col-sm-4 control-label">Name</label>
                <div class="col-sm-8">
                    <input name="name" type="text" class="form-control" id="inputName3" placeholder="Enter your nae">
                </div>
            </div>
            <div class="form-group">
                <label for="inputFamily" class="col-sm-4 control-label">Family</label>
                <div class="col-sm-8">
                    <input name="family" type="text" class="form-control" id="inputFamily" placeholder="Enter your family">
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-4 control-label">Email</label>
                <div class="col-sm-8">
                    <input name="email" type="email" class="form-control" id="inputEmail3" placeholder="Enter an Email">
                </div>
            </div>
            <div class="form-group">
                <label for="inputUsername3" class="col-sm-4 control-label">Username</label>
                <div class="col-sm-8">
                    <input name="username" type="text" class="form-control" id="inputUsername3" placeholder="Enter an Username">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-4 control-label">Password</label>
                <div class="col-sm-8">
                    <input name="password" type="password" class="form-control" id="inputPassword3" placeholder="Enter a Password">
                </div>
            </div>
            <div class="form-group">
                <label for="inputRePassword3" class="col-sm-4 control-label">Repeat Password</label>
                <div class="col-sm-8">
                    <input name="re-password" type="password" class="form-control" id="inputRePassword3" placeholder="Repeat ypur Password">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-6">
                    <button type="submit" class="btn btn-default">Register</button>
                </div>
            </div>
        </form>
    </div>
</div>