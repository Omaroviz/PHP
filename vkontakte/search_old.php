<?php

include_once 'login.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['find'])) {
	echo "<h2>Люди</h2>";
	$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :text OR name = :text OR username = :text");
	$stmt->execute([':text' => $_GET['find']]);
	$users = $stmt->fetchAll();
	if ($users) {
	foreach ($users as $user) {
		echo htmlspecialchars($user['name']). " @".htmlspecialchars($user['username'])."<br>";
	}
	} else {
		echo "Ничего не найдено";
	}
	echo "<h2>Посты</h2>";
	$stmt = $pdo->prepare("SELECT * FROM posts WHERE title = :text");
	$stmt->execute([':text' => $_GET['find']]);
	$posts = $stmt->fetchAll();
	if ($posts) {
	foreach ($posts as $post) {
		echo $post['title']."<br>";
		echo $post['text']."<br><br>";
	}
	} else {
		echo "Ничего не найдено";
	}
	echo "<h2>Сообщества</h2>";
	/*$stmt = $pdo->prepare("SELECT * FROM posts WHERE title = :text");
	$stmt->execute([':text' => $_GET['find']]);
	$posts = $stmt->fetchAll();
	if ($posts) {
	foreach ($posts as $post) {
		echo $post['title']."<br>";
		echo $post['text']."<br><br>";
	}
	echo "I think bWlrdSBoYXRzdW5l oo-ee-oo";
	} else {
		echo "Ничего не найдено";
	}*/
	echo "Поиск по сообществам не сделан.";
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
<title>Поиск></title>
</head>
<body>


















