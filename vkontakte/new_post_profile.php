<?php

include_once 'login.php';

session_start();


if (isset($_SESSION['username'])) {
if ($_SERVER['REQUEST_METHOD'] === "POST"  && isset($_POST['add_post']) &&
	$_SESSION['username'] && !empty($_POST['text'])) {
	echo codetext("Отладка", "Добавил пост");
	$sql = "INSERT INTO posts(title, text, author, author_id, post_from) VALUES(:title, :text, :author, :author_id, :post_from)";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([
		":title" => $_POST['title'],
		":text" => $_POST['text'],
		":author" => $_SESSION['username'],
		":author_id" => $_SESSION['id'],
		":post_from" => $_GET['id']
	]);
	header("Location: vkontakte.php");
	exit();
}
} else {
	header("Location: sign.php");
	exit();
}



