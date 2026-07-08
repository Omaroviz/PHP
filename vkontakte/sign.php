<?php include_once 'login.php'; session_start(); 

if ($_SERVER['REQUEST_METHOD'] === "POST" &&
	isset($_POST['sign_btn']) &&
	!empty($_POST['username']) &&
	!empty($_POST['password'])) {
	// echo "POST дошел!";
	// Из соображений безопасности:
	$sql = "SELECT * FROM users WHERE username = :username";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([":username" => $_POST['username']]);
	$user = $stmt->fetch();
	// echo "<br><code>// Отладка: ";var_dump($user);echo "</code><br>";
	// Пока не будет добавлен файл registration.php, расхеширование паролей не будет!
	if (password_verify($_POST['password'], $user['password'])) {
		$_SESSION['name'] = $user['name'];
		$_SESSION['username'] = $user['username'];
		$_SESSION['id'] = $user['id'];
		$stmt = $pdo->prepare('SELECT id FROM users_info WHERE id = :id');
		$stmt->execute([':id' => $_SESSION['id']]);
		$user = $stmt->fetch();
		if (!$user) {
			$stmt = $pdo->prepare("INSERT INTO users_info(id) VALUES(:id)");
			$stmt->execute([':id' => $_SESSION['id']]);
		}

		header("Location: vkontakte.php");
		exit();

	} else {
	 	echo "Неверный логин/пароль";
	}

	//header("location: " . $_server['php_self']);
	//exit();
}

?>

<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="vkontaktestyle.css" type="text/css" media="all"/>
	<title>Вход</title>
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
			<a href="register_test.php" class="vk-button" id="userStatus">Регистрация</a>
		</div>
	</div>
</header>

<main>
	<div class="login-content">
		<p class="login-main-text">Добро пожаловать!</p>
		<form method="POST">
		<div>
			<span class="input-text">Логин:</span>
			<input name="username" type="text" id="loginUsername" required>
		</div>

		<div>
			<span class="input-text">Пароль:</span>
			<input name="password" type="password" id="loginPassword" required>
		</div>
		
		<div style="margin: 10px 0;">
			<button type="submit" name="sign_btn" class="createPostButton">Вход</button>
		</form>
			<a type="button" class="vk-button" href="register_test.php">Регистрация</a>
		</div>
	</div>
</main>

</body>
</html>
