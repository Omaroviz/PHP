<?php

include_once 'login.php';
include_once 'user.php';
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
if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['find'])) {
echo '<h2 class="search_h">Люди</h2>';
/*$sql = "SELECT * FROM users WHERE id = :text OR name LIKE :text OR username LIKE :text";
$stmt = $pdo->prepare($sql);
$stmt->execute([':text' => '%'.$_GET['find'].'%']);
$users = $stmt->fetchAll();*/
$search = new Search($_GET["find"], $pdo);
if ($search->users) {
foreach ($search->users as $user) {
	echo <<<_END
<div class="search_box">
<span class="search_info"> 
<span class="search_avatar">MH</span>
<span class="search_info_text">
<span class="search_name">
_END;
echo htmlspecialchars($user['name']);
echo <<<_END
</span>
<span class="search_username">@
_END;

echo htmlspecialchars($user['username']);
echo <<<_END
</span>
</span>
</span>
<span class="search_right">
<a class="search_write_a" href="profile.php?id={$user['id']}">Профиль</a>
<a class="search_write_a">Написать</a>
</span>
</div>
_END;
}} else {
	echo "<h4>Ничего не найдено</h4>";

}
echo '<h2 class="search_h">Посты</h2>';
if ($search->posts) {
foreach ($search->posts as $post) {
	echo "<div class='post'>";
	echo "<h3 style='margin: 0;'>".htmlspecialchars($post['title'])."</h3>";
	echo htmlspecialchars($post['text']);
	echo "</div>";
}} else {
echo "<h4>Ничего не найдено</h4>";
	}
} else {

	echo <<<_END
		<form method='GET'>
		<div class="search_input_div">
		<input class='search_input' type='text' name='find' placeholder='Введите запрос'>
		<button type='submit' class='search_input_btn'>Поиск</button>
		</div>
		</form>
		_END;
if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['find'])) {
	header('Location: search.php?find='.$_GET['find']);
	exit();
}
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




