<?php

include_once 'login.php';

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
<a href='edit_info.php?site=main' class='account_box_header_btn' >Главная страница</a>
<a href='edit_info.php?site=name' class='account_box_header_btn' >Изменить имя</a>
<a href='edit_info.php?site=username' class='account_box_header_btn' >Изменить никнейм</a>
<a href='edit_info.php?site=city' class='account_box_header_btn' >Изменить город</a>
<a href='edit_info.php?site=age' class='account_box_header_btn' >Изменить возраст</a>
<a href='edit_info.php?site=about' class='account_box_header_btn' >Изменить "О себе"</a>
</div>
<?php
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
			<button type='submit' name='edit_info_name_btn' class='account_info_btn' name='edit_name'>Готово</button>
			</form>
			_END;
}

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['edit_info_name_btn']) && !empty($_POST['edit_info_input'])) {

	$stmt = $pdo->prepare('UPDATE users SET name = :name WHERE id = :id');
	$stmt->execute([
		':name' => trim($_POST['edit_info_input']),
		':id' => $_SESSION['id']
	]);
	
	}

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['edit_info_age_btn']) && !empty($_POST['edit_info_input'])) {
	$stmt = $pdo->prepare('UPDATE users_info SET age = :age WHERE id = :id');
	$stmt->execute([
		':age' => $_POST['edit_info_input'],
		':id' => $_SESSION['id']
	]);
}

?>
</div>
</div>
</main>
</body>
<html>	












