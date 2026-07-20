<?php

include_once 'login.php';
include_once 'user.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['delete_id']) && isset($_POST['delete_btn']) && isset($_POST['csrf_token'])) {
	if (!$csrf->validateToken($_POST['csrf_token'])) {die('CSRF ошибка. Доступ запрещен');}
	$post = new Post($_POST['delete_id'], $pdo);
	if ($_SESSION['id'] === $post->author_id || $_SESSION['username'] === "admin") {
		$post->delete($pdo);
		header('Location: '.$_SERVER['PHP_SELF']);
		exit();
	} else {$error = "Вы не можете удалить этот пост!";}
}



