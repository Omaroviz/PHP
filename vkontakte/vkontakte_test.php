<?php // vkontakte_test.php

include_once 'login.php';
include_once 'user.php';

session_start();


$stmt = $pdo->query("SELECT * FROM posts");
$posts = $stmt->fetchAll();
foreach ($posts as $poster) {
	$post = new Post($poster['id'], $pdo);
	echo $post->text."<br>";

}

?>

<!DOCTYPE html>
<html lang='ru'>
<head>
<title>TEST</title>
</head>
<body>

</body>
</html>




