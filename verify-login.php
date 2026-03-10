
<?php

require ('dbconnect.php');

$username = $_POST['username'];
$password = $_POST['password'];

$exist = $db->is_exist('users', "username='$username' AND password='$password'");

if ($exist) {

    session_start();
    $_SESSION['user'] = $username;
    $_SESSION['isloggedin'] = true;

    header('location: home.php');
} else {
    echo 'Access denied';
}