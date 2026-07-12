<?php

include_once 'login.php';
include_once 'user.php';

session_start();

if (!isset($_SESSION['username'])) {
	header('Location: sign.php');
	exit();
}

$author_wall = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['delete_id'])) {
	$post = new Post($_GET['delete_id'], $pdo);
	if ($_SESSION['id'] == $post->author_id || $_SESSION['username'] == "admin" || $_SESSION['id'] == $author_wall) {
		$post->delete($pdo);
		header('Location: '.$_SERVER['PHP_SELF']);
		exit();
	} else {$error = "Вы не можете удалить этот пост!";}
}

$user = new User($_SESSION['id'], $pdo);
if (isset($_GET['id']) && $_GET['id'] != $_SESSION['id']) {
    $user = new User($_GET['id'], $pdo);
} else {
    $viewUser = $user;
}
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['add_post'])
	&& !empty($_POST['title']) || !empty($_POST['text'])) {
	
    $post_from = isset($_GET['id']) ? $_GET['id'] : $_SESSION['id'];

	$sql = "INSERT INTO posts(title, text, author, author_id, post_from) VALUES(:title, :text, :author, :author_id, :post_from)";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([
		":title" => $_POST['title'],
		":text" => $_POST['text'],
		":author" => $_SESSION['username'],
		":author_id" => $_SESSION['id'],
		":post_from" => $post_from
	]);
	header("Location: ".$_SERVER['REQUEST_URI']);
	exit();
}
/*
if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['id'])) {
	$sql = "SELECT * FROM users WHERE id = :id";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([':id' => $_GET['id']]);
	$user = $stmt->fetch();
	if ($user) {
		if ($user['id'] === $_SESSION['id']) {
			$edit_profile = TRUE;
		} else {
			$edit_profile = FALSE;	
		}
		$profile = $user;
		$stmt = $pdo->prepare("SELECT * FROM users_info WHERE id = :id");
		$stmt->execute([':id' => $profile['id']]);
		$profile_info = $stmt->fetch();
	} else {
		echo "User not find :(";
		exit();
	}
} else {
	header("Location: profile.php?id=".$_SESSION['id']);
	exit();
}

 */

if (!$_GET['id']) {
	header("Location: profile.php?id=".$_SESSION['id']);
	exit();
}

if ($user->id === $_SESSION['id']) {
	$edit_profile = 1;
} else {
	$edit_profile = 0;
}
?>


<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="vkontaktestyle.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="profile.css" type="text/css" media="all"/>
	<title>Моя страница</title>
	<style>
	.post {
		min-width: 600px;
	}
	</style>
</head>

<body>
<header style="">
	<div class="vkontakte-main-panel">
		<a href="vkontakte.php" class="vkontakte-text">
			<span class="vkontakte-main-text-B">В</span>контакте
		</a>
		<div class="vk-left">
			<a href="profile.html" class="vk-button">Моя страница</a>
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
if (isset($_SESSION['id'])) {
	echo '<a href="logout.php" class="vk-button" id="userStatus">Выход</a>';
} else {
	echo '<a href="sign.php" class="vk-button" id="userStatus">Вход</a>';
}
?>
		</div>
	</div>

</header>

<main class="profile-main">
	<div class="page-container">
		<div class="page-wrapper">
			<div class="profile-row">
				<div class="page-layout">
					<div class="profile-info">
						<img src="media/Pavel_Durov_logo.jpg" alt="Фото профиля" class="profile-logo">
						<h1 class="profileName"><span><?php echo htmlspecialchars($user->name);?></span></h1>
						<h3>Личная информация:</h3>
						<ul>
						<li>Никнейм: @<span id="profile-info-userName"><?php echo htmlspecialchars($user->username)?></span></li>
							<li>Возраст: <span id="profile-info-age">
<?php
	echo htmlspecialchars($user->age);
?>
</span>
    </li>
							<li>
								<label for="city-select">Город: <?php 
echo htmlspecialchars($user->city);
?></label>
							</li>
<li>    <form method="POST">
	<label>О себе: </label>
	    <span><?php 
	$about = $user->about;
echo nl2br(htmlspecialchars(wordwrap($about, 30, "\n", true)));	?>
</form>
</li>
<?php
if ($edit_profile) {
	echo <<<_END
<li style='all: unset;'>
<a href='account.php' style='display: inline-block; margin: 0;'>Изменить</a>
</li>
_END;
}
?>
						</ul>
					</div>
					<div class="profile-post-container">
						<div class="post">
							<form method="POST">
								<p class="postmain">Новый пост</p>
								<textarea name="title" id="postName" placeholder="Заголовок" class="createPostName"></textarea>
								<textarea name="text" id="postInput" placeholder="Что у вас нового?" class="createPostText"></textarea>
								<!-- <input type="text" id="postCommand" placeholder="Команда" class="createPostCommand"> -->
								<button type="submit" name="add_post" class="createPostButton">Опубликовать</button>
							</form>
							</div>
<?php
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
$stmt = $pdo->prepare("SELECT * FROM posts WHERE post_from = :id ORDER BY id DESC");
$stmt->execute([':id' => $_GET['id']]);
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
echo "<br><small style='color: grey; font-weight: bold;'>".htmlspecialchars($post->date)." | ".htmlspecialchars($post->author)."</small>";
	if (isset($_SESSION['username'])) {
	if ($_SESSION['username'] === $post->author || $_SESSION['username'] == "admin" || $_SESSION['id'] == $_GET['id']){
	echo '</p><a href="?id='.urlencode($_GET['id']).'&delete_id='.urlencode($post->id).'" class="vk-button">Удалить</a></a>';
	}
	}
	echo "</div>";

}

?>
			</div>
		</div>
	</div>
</main>

</body>

</html>































