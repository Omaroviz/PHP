<?php

include_once 'login.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['delete_id'])) {
	$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = :id");
	$stmt->execute([":id" => $_GET['delete_id']]);
	$user = $stmt->fetch();
	$stmt_info = $pdo->prepare('SELECT * FROM users WHERE username = :username');
	$stmt_info->execute([":username" => $user['author']]);
	$user_info = $stmt_info->fetch();
	if ($_SESSION['username'] == "admin" || $_SESSION['username'] === $user['author']) {
		$stmt = $pdo->prepare($sql = "DELETE FROM posts WHERE id = :id");	
		$stmt->execute([':id' => $_GET['delete_id']]);
	header("Location: https://localhost/vkontakte/vkontakte.php");
    exit();
	} else {echo "Вы не можете удалить этот пост!";}
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
			<textarea name="title" id="postName" placeholder="Заголовок" class="createPostName"></textarea>
			<textarea name="text" id="postInput" placeholder="Что у вас нового?" class="createPostText"></textarea>
			<!-- <input type="text" id="postCommand" placeholder="Команда" class="createPostCommand"> -->
			<button type="submit" name="add_post" class="createPostButton">Опубликовать</button>
			</form>
		</div>

		<!-- Сюда будут падать новые посты -->
<?php

echo <<<_END
_END;
$stmt = $pdo->query("SELECT * FROM posts ORDER BY id DESC");
$posts = $stmt->fetchAll();
foreach ($posts as $post) {
		echo <<<_END
    <div class="post">
	<h3 style="margin: 0;">
_END;
        echo htmlspecialchars($post['title']);
        echo <<<_END
</h3>
_END;
echo htmlspecialchars($post['text']);
if (is_numeric($post['post_from'])) {
$sql = "SELECT username FROM users WHERE id = :post_from";
$stmt = $pdo->prepare($sql);
$stmt->execute([':post_from' => $post['post_from']]);
//var_dump($stmt->fetch());
$post_by = $stmt->fetch();
echo "<br><small style='color: grey; font-weight: bold;'>".htmlspecialchars($post['date'])." | ".htmlspecialchars($post['author'])." |       На стене @".$post_by['username']."</small>";
} else {
	echo "<br><small style='color: grey; font-weight: bold;'>".htmlspecialchars($post['date'])." | ".htmlspecialchars($post['author'])."</small>"; 
}
	if (isset($_SESSION['username'])) {
	if ($_SESSION['username'] === $post['author'] || $_SESSION['username'] == "admin"){
	echo '</p><a class="vk-button" href="?delete_id='.$post['id'].'">Удалить</a>';
	}
	}
	echo "</div>";

}



?>

	</div>
</main>
<footer id="vniz" style="margin: 0;">
	<a href="#" class="vk-button" onclick="confirm('Fork me? Fork you! @octocat')">О сайте</a>
	"Вконтакте Druza" ООО. Все права защищены. Распространения кода сайта разрешено с <a href="#">условиями
	конфидициальности</a> на сайте GitHub.
</footer>

</body>

</html>




