<?php

include_once 'function.php';

$host = 'localhost';
$dbname = 'vkontakte';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",$username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch(PDOException $e) {
    die("Ошибка подключения: " . $e->getMessage());
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('session.use_only_cookies', 1);
