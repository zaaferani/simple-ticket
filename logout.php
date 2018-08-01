<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 7/31/2018
 * Time: 10:34 AM
 */

session_start();
session_destroy();
session_start();

$_SESSION['message'] = 'logout successful';
header('location: /index.php');