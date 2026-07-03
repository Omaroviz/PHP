<?php

include_once '../login.php';

if (isset($_GET['page'])) {
	$page = (int)$_GET['page'];
	if ($page < 0) $page = 0;
	$stmt = $pdo->query("SELECT COUNT(*) FROM posts");
	if ($page < $stmt->fetchColumn()) {
	$stmt = $pdo->query("SELECT * FROM posts LIMIT 10 OFFSET $page");
	$posts = $stmt->fetchAll();
	foreach($posts as $post) {
		echo htmlspecialchars($post['title'])."<br>";
	}
	$page2 = $page + 10;
	$page0 = $page - 10;
	echo "<a href='?page=".$page0."'>Назад</a>";
	echo "<a href='?page=".$page2."'>Вперед</a>";
	}
} else {

	echo "Нет \$_GET запроса";

}
