<?php

include_once 'login.php';
include_once 'user.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['delete_id'])) {
	$post = new Post($_GET['delete_id'], $pdo);
	if ($_SESSION['id'] === $post->author_id || $_SESSION['username'] === "admin") {
		$post->delete($pdo);
		header('Location: '.$_SERVER['PHP_SELF']);
		exit();
	} else {$error = "Вы не можете удалить этот пост!";}
}

if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['like'])) {
	// Потом	
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

			<a href="account" class="vk-button">Настройки</a>
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


<main class="page-layout">
	<aside class="sidebar">
		<div class="friends-mini" style="justify-content: normal">
			<span id="userNameHTML" class="sidebar-userName"><b>
<?php
if (isset($_SESSION['name'])) {
	echo $_SESSION['name'];
} else {echo "Гость";}
?>
</b></span>
		</div>
		<nav>
			<h2 style="margin: 10px;"><em>....Стена Новостей</em></h2>
			<button type="button" class="vk-button" id="menuButton">Меню</button>
			<a href="#" class="vk-button" id="subscribeButton" onclick="subscribe()">Подписаться</a>
		</nav>
		<div class="sidebar-window-post">
			<a href="" class="sidebar-window-post-btn">Все посты</a>
			<a href="" class="sidebar-window-post-btn">Посты друзей</a>
			<a href="" class="sidebar-window-post-btn">Посты каналов</a>
			<a href="" class="sidebar-window-post-btn">Общая лента</a>
		</div>
		<div class="sidebar-window-post">
			<a href="" class="sidebar-window-post-btn">Мои лайки</a>
			<a href="" class="sidebar-window-post-btn">Мои дизлайки</a>
			<a href="" class="sidebar-window-post-btn">Мои комментарии</a>
			<!--			<a href="" class="sidebar-window-post-btn">Мои голоса: 0</a>-->
		</div>
		<!--<div class="sidebar-window-post">-->
		<!--<a href="" class="sidebar-window-post-btn">Ответы</a>-->
		<!--<a href="" class="sidebar-window-post-btn">Избранное</a>-->
		<!--<a href="" class="sidebar-window-post-btn">Нравиться друзьям</a>-->
		<!--</div>-->
	</aside>

	<div class="main-content">
		<div class="post">
			<form method="POST" action="new_post.php">
			<p class="postmain">Новая запись</p>
			<textarea name="title" id="postName" placeholder="Заголовок" class="createPostName" style='resize: none'></textarea>
			<textarea name="text" id="postInput" placeholder="Что у вас нового?" class="createPostText" style='resize: none'></textarea>
			<!-- <input type="text" id="postCommand" placeholder="Команда" class="createPostCommand"> -->
			<button type="submit" name="add_post" class="createPostButton">Опубликовать</button>
			</form>
		</div>

		<!-- Сюда будут падать новые посты -->
<?php
if (empty($_SESSION['id'])) {
echo <<<_END
	
	<div class='post'>
		<h3 style="margin: 0;">Добро пожаловать!</h3>
		<a href='sign.php'>Войдите</a> или
		<a href='register.php'>Зарегистрируйтесь</a>
	</div>
_END;

}

if (isset($error)) {
$error = htmlspecialchars($error);
echo <<<_END
	
	<div class='post'>
		<h3 style="margin: 0;">Ошибка</h3>
		{$error}
		<a href='vkontakte.php'>Перезагрузка</a>
	</div>
_END;
}
echo <<<_END
_END;
$stmt = $pdo->query("SELECT posts.*, users.username FROM posts LEFT JOIN users ON posts.post_from = users.id ORDER BY posts.id DESC");
$posts = $stmt->fetchAll();
foreach ($posts as $poster) {
	$post = new Post($poster);
	$title = htmlspecialchars($post->title);
	$text = htmlspecialchars($post->text);
		echo <<<_END
    <div class="post">
	<h3 style="margin: 0;">{$title}</h3>
	{$text}
_END;
if (is_numeric($post->post_from)) {
echo "<br><small style='color: grey; font-weight: bold;'>".htmlspecialchars($post->date)." | ".htmlspecialchars($post->author)." | На стене @".htmlspecialchars($poster['username'])."</small>";
} else {
	echo "<br><small style='color: grey; font-weight: bold;'>".htmlspecialchars($post->date)." | ".htmlspecialchars($post->author)."</small>"; 
}
	if (isset($_SESSION['username'])) {
	if ($_SESSION['username'] === $post->author || $_SESSION['username'] == "admin"){
	echo '</p><a class="vk-button" href="?delete_id='.htmlspecialchars($post->id).'">Удалить</a>';
	}
	}
	echo " <a href='post.php?id=".$post->id."' class='vk-button'>Комментарии</a></div>";

}



?>

	</div>
</main>
<footer id="vniz" style="margin: 0;">
	<a href="#" class="vk-button" onclick="confirm('Fork me? Fork you! @octocat')">О сайте</a>
© 2026 Вконтакте Druza. Исходный код распространяется под лицензией 
<a href="https://www.gnu.org/licenses/gpl-3.0.html" target="_blank" rel="noopener noreferrer">GNU GPL v3</a> на сайте <a href='https://www.GitHub.com/Omaroviz/PHP'>GitHub</a>.
</footer>

</body>

</html>




