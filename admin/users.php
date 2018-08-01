<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 8/1/2018
 * Time: 8:33 AM
 */

require_once '../header.php';

check_login(true);

check_access('ADMIN', true);

$users = $db_helper->getUsers();
?>
<div class="row">
    <div class="col-md-12">
        <a href="new-user.php" class="btn btn-info">New user</a>
        <table class="table table-responsive table-striped table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Family</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Type</th>
                    <th>Join At</th>
                    <th>-</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $i = 1;
                foreach ($users as $user){
                echo "
                <tr>
                    <td>${i}</td>
                    <td>${user['name']}</td>
                    <td>${user['family']}</td>
                    <td>${user['username']}</td>
                    <td>${user['email']}</td>
                    <td>${user['type']}</td>
                    <td>${user['created_at']}</td>
                    <td>
                        <a href=\"edit-user.php?id=${user['id']}\" class=\"btn btn-primary\">Edit</a>
                        <a href=\"remove-user.php?id=${user['id']}\" class=\"btn btn-danger\">Remove</a>
                    </td>
                </tr>
                ";
                $i++;
                }
            ?>
            </tbody>
        </table>
    </div>
</div>
<?php
require_once '../footer.php';
?>