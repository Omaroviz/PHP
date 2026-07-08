<?php

include_once 'login.php';

session_start();

if (!isset($_SESSION['id'])){
	header("Location: sign.php");
	exit();
}
if (!isset($_GET['site'])) {
	header("Location: account.php?site=main");
	exit();

}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="vkontaktestyle.css">
	<link rel="icon" href="media/vkontakte.ico">
	<title>Вконтакте Druza</title>
</head>

<body>
<header style="">
	<div class="vkontakte-main-panel">
		<a href="vkontakte.php" class="vkontakte-text">
			<span class="vkontakte-main-text-B">В</span>контакте
		</a>
		<div class="vk-left">
			<a href="profile.php" class="vk-button">Моя страница</a>
			<a href="friends.php" class="vk-button">Друзья</a>
		</div>

		<div class="vk-right" id="vk-right">
			<form method="GET" action="search.php" style="margin: 0; padding: 0">
			<input type="text" name="find" placeholder="Поиск" style="margin: 0; padding-left: 9px;">
			<button type="submit">Поиск</button>
			</form>

			<a href="https://vkontakte.ucoz.site/online-1/messages.html" class="vk-button">Сообщения</a>
			<a href="search.php" class="vk-button">Поиск</a>
			<?php 
			if (isset($_SESSION['username'])) {
				echo "<a href='logout.php' class='vk-button'>Выход</a>";
			} else {
				echo "<a href='sign.php' class='vk-button' id='userStatus'>Вход</a>";
			}
		?>
		</div>
	</div>

</header>

<main class='account_loyaut'>

<div class='account_box'>

<div class='account_box_header'>
<a href='account.php?site=main' class='account_box_header_btn' >Аккаунт</a>
<a href='account.php?site=info' class='account_box_header_btn' >Личная информация</a>
<a href='account.php?site=password' class='account_box_header_btn' >Пароль</a>
</div>
<?php
if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['site'])) {
	if ($_GET['site'] === "password") {
		echo <<<_END
<div>
<h2>Изменить пароль</h2>
<form method='POST'>

<input type='text' name='old_password' placeholder='Старый пароль' required><br>
<input type='text' name='new_password' placeholder='Новый пароль' required><br>
<input type='text' name='new2_password' placeholder='Повторите пароль' required><br>
<button type='submit' name='edit_password_btn'>Готово</button>
</form>
</div>
_END;
	}
}?>
<?php
if (
	$_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_password_btn']) &&
	isset($_GET['site']) && $_GET['site'] === "password" &&
	!empty($_POST['old_password']) &&
	!empty($_POST['new_password']) &&
	!empty($_POST['new2_password'])
) {
	if ($_POST['new2_password'] === $_POST['new_password']) {
	
		$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
		$stmt->execute([':id' => $_SESSION['id']]);
		$user_password = $stmt->fetch();
		echo "Отладка: ";var_dump($user_password);echo "<br>";
		if (password_verify($_POST['old_password'], $user_password['password'])) {
			echo "Молодец, малыш!<br>";
			$stmt = $pdo->prepare("UPDATE users SET password = :password WHERE id = :id");
			$hashed = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
			$stmt->execute([
				':password' => $hashed,
				':id' => $user_password['id']
			]);
		} else {
			echo "Неверный старый пароль";
		}	
	} else {
		echo 'Новые пароли не совпадают!';
	}

} 

if (isset($_GET['site']) && $_GET['site'] === "main") {
	echo "<h3 style='text-align: center'>Управление аккаунтом</h3>";
}

if (isset($_GET['site']) && $_GET['site'] === "info") {
	$name = htmlspecialchars($_SESSION['name']);
	$stmt = $pdo->prepare("SELECT i.id, i.city, i.about, i.age 
FROM users u 
JOIN users_info i ON u.id = i.id 
WHERE u.id = :id");
	$stmt->execute([':id' => $_SESSION['id']]);
	$user_info = $stmt->fetch();
	$user_age = $user_info['age'];
	$user_about = $user_info['about'];
	$user_city = $user_info['city'];
	$username = htmlspecialchars($_SESSION['username']);
	$age = htmlspecialchars($_SESSION['name']);
	echo <<<_END
		<h3 style='text-align: center'>Личная информация</h3>
		<div class='account_info_info'>
		<p class='account_info_p'>Имя: {$name} <a href='edit_info.php?site=name' class='account_info_btn'>Изменить</a></p> 
		<p class='account_info_p'>Никнейм: @{$username} <button class='account_info_btn'>Изменить</button></p>
		<p class='account_info_p'>Возраст: {$user_age} <button class='account_info_btn'>Изменить</button></p>
		<p class='account_info_p'>Город: {$user_city} <button class='account_info_btn'>Изменить</button></p>
		<p class='account_info_p'>О себе: {$user_about} <a class='account_info_btn'>Изменить</a></p>
		</div>
_END;
	
}
?>
</div>
</div>
</main>
</body>
<html>	











