<!DOCTYPE html>
<html lang='ru'>
<head> 
<title>Тест</title>
<style src='../vkontaktestyle.css'></style>
</head>
<body>
<?php

include_once '../login.php';

function showPosts($pdo) {
if (isset($_GET['page'])) {
	$page = (int)$_GET['page'];
	if ($page < 1) $page = 1;
	$stmt = $pdo->query('SELECT * FROM posts LIMIT 5 OFFSET '.($page - 1) * 5);
	$posts = $stmt->fetchAll();
	if ($posts) {
		foreach ($posts as $post) {
			$title = htmlspecialchars($post['title']);
			$text = htmlspecialchars($post['text']);
		echo <<<_END
			<div class='post'>
			<h3 style='margin: 0;'>{$title}</h3>
			{$text}
			</div>
			_END;
	}
	$page_up = $page + 1;
	$page_down = $page - 1;
	echo "<a href='?page=".$page_down."'>Назад</a> ";
	echo "<a href='?page=".$page_up."'>Вперед</a>";
	} else {
		header('Location: index.php');
		exit();
	}

} else {
	header('Location: index.php?page=1');
	exit();	

}

}

showPosts($pdo);
