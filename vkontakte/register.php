<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once "login.php";

//echo codetext("Отладка", "тест отладки");

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['register_btn'])) {
	echo codetext("Отладка","получил POST-запрос");
	$name = trim($_POST['name']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    // Проверка логина (только латиница, цифры, _)
    if (!preg_match('/^[A-Za-z0-9_]+$/', $username)) {
        echo "Логин может содержать только латиницу, цифры и _";
        exit();
    }
    
    if (strlen($username) < 6) {
        echo "Логин должен быть не короче 6 символов";
        exit();
    }
    
    if (strlen($password) < 8) {
        echo "Пароль должен быть не короче 8 символов";
        exit();
    }
    	$sql = "SELECT * FROM users WHERE username = :username";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([":username" => $_POST['username']]);
	$user = $stmt->fetch();
	if ($user) {
		echo "Пользователь с таким ником уже существует";
	} else {
		echo codetext("Отладка", "добавляем пользователя в Database");
		$sql = "INSERT INTO users(name, username, password) VALUES(:name, :username, :password)";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([
			":name" => $_POST['name'], 
			":username" => $_POST['username'], 
			":password" => password_hash($_POST['password'], PASSWORD_DEFAULT),
		]);

		header("Location: " . $_SERVER['PHP_SELF']);
    		exit();
	}
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="vkontaktestyle.css" type="text/css" media="all"/>
	<title>Регистрация</title>
</head>
<body>
<header>
	<div class="vkontakte-main-panel">
		<a href="vkontakte.php" class="vkontakte-text">
			<span class="vkontakte-main-text-B">В</span>контакте
		</a>
		<div class="vk-left">
			<a href="profile.php" class="vk-button">Моя страница</a>
			<a href="friends.php" class="vk-button">Друзья</a>
		</div>

		<div class="vk-right" id="vk-right">
			<a href="about.php" class="vk-button">Сообщения</a>
			<a href="search.php" class="vk-button">Поиск</a>
			<a href="sign.php" class="vk-button" id="userStatus">Вход</a>
		</div>
	</div>
</header>

<main>
	<div class="login-content">
		<form method="POST">
		<p class="login-main-text">Регистрация</p>

		<div>
			<span class="input-text">Имя:</span>
			<input name="name" type="text" id="regName" required>
		</div>

		<div>
			<span class="input-text">Логин:</span>
			<input name="username" type="text" id="regUsername" required>
		</div>

		<div>
			<span class="input-text" >Пароль:</span>
			<input type="password" name="password" id="regPassword" required>
		</div>


		<div style="margin: 10px 0;">
			<button type="submit" name="register_btn" class="createPostButton" onclick="register()">Регистрация</button>
			</form>
			<a href="sign.php" class="vk-button">Вход</a>
		</div>
	</div>
</main>

</script>
</body>
</html>
