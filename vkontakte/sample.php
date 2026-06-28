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
<div style="display: flex; flex-direction: column; align-items: center; width: 100%;">
<main class="search_main">

<?php
$sql = "SELECT * FROM users WHERE id = :text OR name = :text OR username = :text";
$stmt = $pdo->prepare($sql);
$stmt->execute([':text' => "stepa"]);
$users = $stmt->fetchAll();
foreach ($users as $user) {
	echo <<<_END
<div class="search_box">
<span class="search_info"> 
<span class="search_avatar">MH</span>
<span class="search_info_text">
<span class="search_name">
{$user['name']}
</span>
<span class="search_username">
@{$user['username']}
</span>
</span>
</span>
<span class="search_right">
<a class="search_write_a">Написать</a>
<a class="search_write_a">Добавить</a>
</span>
</div>
_END;
}
?>
</main>
</div>
<footer id="vniz" style="margin: 0;">
	<a href="#" class="vk-button" onclick="confirm('О сайте.\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\nПривет')">О сайте</a>
	"Вконтакте Druza" ООО. Все права защищены. Распространения кода сайта разрешено с <a href="#">условиями
	конфидициальности</a> на сайте GitHub.
</footer>

</body>

</html>




