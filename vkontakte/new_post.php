<?php

include_once 'login.php';
include_once 'user.php';

session_start();


if (isset($_SESSION['username'])) {
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['add_post']) &&
	$_SESSION['csrf_token'] && (!empty($_POST['text']) || !empty($_POST['title']))) {
	// echo codetext("Отладка", "Добавил пост");
	$csrf = new CSRF();
	if (!$csrf->validateToken($_POST['csrf_token'])) {
		die('CSRF ошибка. Доступ запрещен.');
	}
	$sql = "INSERT INTO posts(title, text, author, author_id, post_from) VALUES(:title, :text, :author, :author_id, :post_from)";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([
		":title" => trim($_POST['title']),
		":text" => trim($_POST['text']),
		":author" => $_SESSION['username'],
		":author_id" => $_SESSION['id'],
		":post_from" => "general"
	]);
	header("Location: vkontakte.php");
	exit();
} else {
	header('Location: vkontakte.php');
	exit();
}
} else {
	header("Location: sign.php");
	exit();
}



