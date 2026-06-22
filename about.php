<?php

include_once 'login.php';

echo "<code>// Подключился к Базе Данных</code><br>";

if ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET['name'])) {
	echo "<code>// Вижу GET-запрос</code><br>";
	$sql = 'SELECT * FROM users WHERE name = :name OR username = :name';
	$stmt = $pdo->prepare($sql);
	$stmt->execute([':name' => $_GET['name']]);
	$info = $stmt->fetch();
	if ($info) {
		echo "ID: ".htmlspecialchars($info['id'])."<br>";
		echo "Name: ".htmlspecialchars($info['name'])."<br>";
		echo "Username: ".htmlspecialchars($info['username'])."<br>";
		echo "Role: ".htmlspecialchars($info['role'])."<br>";
		echo "<code>// Передал пользователю информацию о ".htmlspecialchars($info['name'])."</code>";
	} else {
		echo "Пользователь не найден<br>" ;
		echo "<code>// Не нашел информацию о ".$_GET['name']."</code>";
	}	
}

echo <<<_END
	<form method="GET">
		<input type="text" name="name" placeholder="Name">
		<button type="submit">Enter</button>
	</form>
	_END;















