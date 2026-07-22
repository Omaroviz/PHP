<?php

include_once 'login.php';
include_once 'user.php';

session_start();

if (!isset($_SESSION['id'])){
	header("Location: sign.php");
	exit();
}
if (!isset($_GET['site'])) {
	header("Location: account.php?site=main");
	exit();

}
$user = new User($_SESSION['id'], $pdo);
	$name = htmlspecialchars($_SESSION['name']);
	$user_age = htmlspecialchars($user->age);
	$user_about = htmlspecialchars($user->about);
	$user_city = htmlspecialchars($user->city);
	$username = htmlspecialchars($user->username);

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
																						
			<a href="account.php" class="vk-button">Настройки</a>
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
<h3 style='text-align: center;'>Изменить пароль</h2>
<form method='POST' style='align-items: center;'>

<input type='password' name='old_password' placeholder='Старый пароль' required><br>
<input type='password' name='new_password' placeholder='Новый пароль' required><br>
<input type='password' name='new2_password' placeholder='Повторите пароль' required><br>
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
		if (password_verify($_POST['old_password'], $user->password)) {
			echo "Молодец, малыш!<br>";
			$hashed = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
			$user->edit("users", "password", $hashed, $pdo);
		} else {
			echo "Неверный старый пароль";
		}	
	} else {
		echo 'Новые пароли не совпадают!';
	}

} 

if (isset($_GET['site']) && $_GET['site'] === "main") {
	echo <<<_END
		<h3 style='text-align: center'>Управление аккаунтом</h3>
		<p>Привет, {$name}!
	_END;
}

if (isset($_GET['site']) && $_GET['site'] === "info") {
	echo <<<_END
		<h3 style='text-align: center'>Личная информация</h3>
		<div class='account_info_info'>
		<p class='account_info_p'>Имя: {$name} <a href='edit_info.php?site=name' class='account_info_btn'>Изменить</a></p> 
		<p class='account_info_p'>Никнейм: @{$username} <a href='edit_info.php?site=username' class='account_info_btn'>Изменить</a></p>
		<p class='account_info_p'>Возраст: {$user_age} <a  href='edit_info.php?site=age' class='account_info_btn'>Изменить</a></p>
		<p class='account_info_p'>Город: {$user_city} <a  href='edit_info.php?site=city' class='account_info_btn'>Изменить</a></p>
		<p class='account_info_p'>О себе: {$user_about} <a  href='edit_info.php?site=about' class='account_info_btn'>Изменить</a></p>
		</div>
_END;
}
?>
</div>
</div>
</main>
</body>
<html>	
