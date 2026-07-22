<?php include_once 'login.php'; session_start(); 
include_once 'user.php';

if ($_SERVER['REQUEST_METHOD'] === "POST" &&
	isset($_POST['sign_btn']) &&
	!empty($_POST['username']) &&
	!empty($_POST['password'])) {
	$user = new User(null, $pdo);

	if ($user->login($_POST['username'], $_POST['password'])) {
			header('Location: vkontakte.php');
			exit();
		} else {
			$error = "Неверный пароль";
		}
	} else {
	 	//echo "Неверный логин/пароль";
	}

	//header("location: " . $_server['php_self']);
	//exit();


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
	
	<a href="account.php" class="vk-button">Настройки</a>
			<a href="search.php" class="vk-button">Поиск</a>
			<a href="register.php" class="vk-button" id="userStatus">Регистрация</a>
		</div>
	</div>
</header>

<main>
	<div class="login-content">
		<p class="login-main-text">Добро пожаловать!</p>
		<?php
		if (isset($error)) {
			echo "<b>".$error."</b>";
		}
		?>	
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
			<a type="button" class="vk-button" href="register.php">Регистрация</a>
		</div>
	</div>
</main>

</body>
</html>
