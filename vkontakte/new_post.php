<?php

include_once 'login.php';

session_start();

echo "OKAY";

if ($_SERVER['REQUEST_METHOD'] === "POST"  && isset($_POST['add_post']) &&
	$_SESSION['username'] && !empty($_POST['text'])) {
	echo codetext("Отладка", "Добавил пост");
	$sql = "INSERT INTO posts(title, text, author) VALUES(:title, :text, :author)";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([
		":title" => $_POST['title'],
		":text" => $_POST['text'],
		":author" => $_SESSION['username']
	]);
	header("Location: vkontakte.php");
	exit();
}




