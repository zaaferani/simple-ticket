<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 7/31/2018
 * Time: 12:39 PM
 */

require_once 'header.php';

check_login(true);

$user = $_SESSION['user'];
$error = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if ($_POST['old-password'] != '') {
        if (strlen($_POST['password']) < 3) {
            array_push($error, 'password must at least 3 characters length');
        }
        if ($_POST['password'] != $_POST['re-password']) {
            array_push($error, 're password not match with password');
        }
        if (!$db_helper->checkLogin($user['username'], $_POST['old-password'])){
            array_push($error, 'old password incorrect');
        }
    }
    if (!$error){
        $param = [
            "name" => $_POST['name'],
            "family" => $_POST['family'],
            "sex" => $_POST['sex'],
        ];
        if ($_POST['old-password'] != ''){
            $param['password'] = $_POST['password'];
        }
        $e = $db_helper->update("users", $param, ["id" => $user['id']]);
        if (((int)$e) == 0){
            $user = $db_helper->getUser($user['id']);
            $_SESSION['user'] = $user;
            $_SESSION['message'] = "your profile updated!";
        } else {
            array_push($error, 'error on update! try again');
        }
    }
}
?>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <form class="form-horizontal" action="/profile.php" method="post">
            <div class="form-group">
                <label for="inputName3" class="col-sm-4 control-label">Name</label>
                <div class="col-sm-8">
                    <input name="name" type="text" value="<?php echo $user['name'] ?>" class="form-control" id="inputName3" placeholder="Enter your nae">
                </div>
            </div>
            <div class="form-group">
                <label for="inputFamily" class="col-sm-4 control-label">Family</label>
                <div class="col-sm-8">
                    <input name="family" type="text" value="<?php echo $user['family'] ?>" class="form-control" id="inputFamily" placeholder="Enter your family">
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-4 control-label">Email</label>
                <div class="col-sm-8">
                    <span class="form-control" disabled id="inputEmail3"><?php echo $user['email'] ?></span>
                </div>
            </div>
            <div class="form-group">
                <label for="inputUsername3" class="col-sm-4 control-label">Username</label>
                <div class="col-sm-8">
                    <span class="form-control" disabled id="inputUsername3"><?php echo $user['username'] ?></span>
                </div>
            </div>
            <div class="form-group">
                <label for="inputSex3" class="col-sm-4 control-label">Sex</label>
                <div class="col-sm-8">
                    <select name="sex" id="inputSex3" class="form-control">
                        <option value="M" <?php echo $user['sex'] == 'M' ? 'selected' : '' ?>>Male</option>
                        <option value="F" <?php echo $user['sex'] == 'F' ? 'selected' : '' ?>>Female</option>
                        <option value="U" <?php echo $user['sex'] == 'U' ? 'selected' : '' ?>>unknown</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="inputOldPassword3" class="col-sm-4 control-label">Old Password</label>
                <div class="col-sm-8">
                    <input name="old-password" type="password" class="form-control" id="inputOldPassword3" placeholder="Empty if wont change password">
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
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php
require 'footer.php';
?>