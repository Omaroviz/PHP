<?php

include_once 'login.php';
include_once 'user.php';

session_start();
if (!isset($_SESSION['id'])){
	header("Location: sign.php");
	exit();
}
/*if (!isset($_GET['site'])) {
	header("Location: account.php?site=main");
	exit();

}*/
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
<a href='edit_info.php?site=main' class='account_box_header_btn' >Главная страница</a>
<a href='edit_info.php?site=name' class='account_box_header_btn' >Изменить имя</a>
<a href='edit_info.php?site=username' class='account_box_header_btn' >Изменить никнейм</a>
<a href='edit_info.php?site=city' class='account_box_header_btn' >Изменить город</a>
<a href='edit_info.php?site=age' class='account_box_header_btn' >Изменить возраст</a>
<a href='edit_info.php?site=about' class='account_box_header_btn' >Изменить "О себе"</a>
</div>
<?php
if (!isset($_GET['site'])) {
	echo "<h3 style='text-align: center'>Изменить данные пользователя @".htmlspecialchars($_SESSION['username'])."</h3>";
	$stmt = $pdo->prepare('SELECT * FROM users
					JOIN users_info ON users.id = users_info.id
					WHERE users.id = :id
		');
	$stmt->execute([':id' => $_SESSION['id']]);
	echo "<small>Ваши данные: ";print_r($stmt->fetch());echo "</small>";

}


if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['site']) && $_GET['site'] === "main") {

	header('Location: edit_info.php');
	exit();

}

if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['site'])) {
	if ($_GET['site'] === "age") {
		echo <<<_END
			<h3 style='text-align: center'>Изменить возраст</h3>
			<form method="POST" style='margin: 0 auto 20px auto;'>
			<input type='number' class='edit_info_input' name='edit_info_input' placeholder='Введите возраст...'>
			<button type='submit' name='edit_info_age_btn' class='edit_info_name_btn' name='edit_name'>Готово</button>
			</form>
			_END;
	}

}
if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['site'])) {
	if ($_GET['site'] === "about") {
		echo <<<_END
			<h3 style='text-align: center'>Изменить "О себе"</h3>
			<form method="POST" style='margin: 0 auto 20px auto; align-items: center;'>
			<textarea name='edit_info_input' style='resize: none; width: 300px; height: 100px; margin: 0' placeholder='Введите текст...'></textarea><br>
			<button type='submit' name='edit_info_about_btn' class='edit_info_name_btn' name='edit_name'>Готово</button>
			</form>
			_END;
	}

}		
if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['site'])) {
	if ($_GET['site'] === "name") {
		echo <<<_END
			<h3 style='text-align: center'>Изменить имя</h3>
			<form method="POST" style='margin: 0 auto 20px auto;'>
			<input type='text' class='edit_info_input' name='edit_info_input' placeholder='Введите новое имя...'>
			<button type='submit' name='edit_info_name_btn' class='account_info_btn' name='edit_name'>Готово</button>
			</form>
			_END;
	}

}

if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['site']) && $_GET['site'] === "username") {
	echo <<<_END
			<h3 style='text-align: center'>Изменить никнейм</h3>
			<form method="POST" style='margin: 0 auto 20px auto;'>
			<input type='text' class='edit_info_input' name='edit_info_input' placeholder='Введите новый никнейм...'>
			<button type='submit' name='edit_info_username_btn' class='account_info_btn' name='edit_name'>Готово</button>
			</form>
			_END;
}
if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['site']) && $_GET['site'] === "city") {
	echo <<<_END
			<h3 style='text-align: center'>Изменить город</h3>
			<form method="POST" style='margin: 0 auto 20px auto;'>
						<select id="city-select" class="vk-button-btn" style="max-width: 120px; padding: 1px; font-size: 10px" name="edit_info_input">
						<option value="Москва">Москва</option>
						<option value="Санкт-Петербург">Санкт-Петербург</option>
						<option value="Новосибирск">Новосибирск</option>
						<option value="Екатеринбург">Екатеринбург</option>
						<option value="Казань">Казань</option>
						<option value="Нижний Новгород">Нижний Новгород</option>
						<option value="Челябинск">Челябинск</option>
						<option value="Самара">Самара</option>
						<option value="Омск">Омск</option>
						<option value="Ростов-на-Дону">Ростов-на-Дону</option>
						<option value="Уфа">Уфа</option>
						<option value="Красноярск">Красноярск</option>
						<option value="Воронеж">Воронеж</option>
						<option value="Пермь">Пермь</option>
						<option value="Волгоград">Волгоград</option>
						<option value="Краснодар">Краснодар</option>
						<option value="Саратов">Саратов</option>
						<option value="Тюмень">Тюмень</option>
						<option value="Тольятти">Тольятти</option>
						<option value="Ижевск">Ижевск</option>
						<option value="Махачкала">Махачкала</option>
						<option value="Хабаровск">Хабаровск</option>
						<option value="Владивосток">Владивосток</option>
						<option value="Другой" selected>Другой город</option>
					</select>
			<button type='submit' name='edit_info_city_btn' class='account_info_btn' name='edit_name'>Готово</button>
			</form>
			_END;
}
if ($_SERVER['REQUEST_METHOD'] === "GET"  && isset($_GET['site']) && $_GET['site'] === 'bue') {
	echo "<h3 style='text-align: center'>Готово</h3><p style=\"text-align: center;\"><a href=\"account.php\">Перейти к настройкам</a> <br> <a href=\"vkontakte.php\">Перейти на главную страницу</a></p>";
}


$user = new User($_SESSION['id'], $pdo);

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['edit_info_city_btn']) && !empty($_POST['edit_info_input'])) {
	/*
	$stmt = $pdo->prepare('UPDATE users_info SET city = :city WHERE id = :id');
	$stmt->execute([
		':city' => trim($_POST['edit_info_input']),
		':id' => $_SESSION['id']
	]);
	 */
	$user->edit('users_info', 'city', $_POST['edit_info_input'], $pdo);
	header('Location: edit_info.php?site=bue');	
	exit();
}
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['edit_info_name_btn']) && !empty($_POST['edit_info_input'])) {
	$user->edit('users', 'name', $_POST['edit_info_input'], $pdo);
	header('Location: edit_info.php?site=bue');	
	exit();

}

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['edit_info_username_btn']) && !empty($_POST['edit_info_input'])) {
	$username = trim($_POST['edit_info_input']);
	if (!preg_match('/^[A-Za-z0-9_]+$/', $username)) {
		echo "<b style='text-align: center'>Логин может содержать только латиницу, цифры и _<br><a href='edit_info.php?site=username'>Попробовать еще раз</a></b>";
		exit();
	} else {
		
		$stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
		$stmt->execute([':username' => $username]);
		if ($stmt->fetch()) {
			echo "Данный никнейм занят!";
			exit();
		}
	if (mb_strlen($username) < 6) {
		echo "<b class='edit_info_error'>Длина никнейма должна быть больше 5 символов!<br><a href='edit_info?site=username'>Попробывать еще раз</b>";
		exit();
	}


	$user->edit('users', 'username', $_POST['edit_info_input'], $pdo);
	header('Location: edit_info.php?site=bue');	
	exit();
	}
	}

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['edit_info_age_btn']) && !empty($_POST['edit_info_input'])) {
	$user->edit('users_info', 'age', $_POST['edit_info_input'], $pdo);
	header('Location: edit_info.php?site=bue');	
	exit();

}

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['edit_info_about_btn']) && !empty($_POST['edit_info_input'])) {
	$user->edit('users_info', 'about', $_POST['edit_info_input'], $pdo);
	header('Location: edit_info.php?site=bue');	
	exit();

}
?>
</div>
</div>
</main>
</body>
<html>	












