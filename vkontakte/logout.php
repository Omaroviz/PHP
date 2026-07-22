<?php
include_once 'user.php';
include_once 'login.php';

session_start();

$user = new User($_SESSION['id'], $pdo);
$user->logout();

header("Location: vkontakte.php");
exit();


