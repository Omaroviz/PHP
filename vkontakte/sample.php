<?php

include_once 'login.php';
session_start();
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
			<a href="https://vkontakte.ucoz.site/online-1/messages.html" class="vk-button">Сообщения</a>
			<a href="#" class="vk-button">Поиск</a>
			<?php 
			if (isset($_SESSION['username'])) {
				echo "<a href='logout.php' class='vk-button'>Выйти</a>";
			} else {
				echo "<a href='sign.php' class='vk-button' id='userStatus'>Вход</a>";
			}
		?>
		</div>
	</div>

</header>


<main class="page-layout">
<div class="post">
</div>
</main>
<footer id="vniz" style="margin: 0;">
	<a href="#" class="vk-button" onclick="confirm('О сайте.\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\nПривет')">О сайте</a>
	"Вконтакте Druza" ООО. Все права защищены. Распространения кода сайта разрешено с <a href="#">условиями
	конфидициальности</a> на сайте GitHub.
</footer>

</body>

</html>




