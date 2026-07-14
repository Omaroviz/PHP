<?php

include_once 'login.php';
include_once 'user.php';

session_start();

if (empty($_SESSION['id'])) {
} else {


$user = new User($_SESSION['id'], $pdo);
	$name = htmlspecialchars($_SESSION['name']);
	$user_age = htmlspecialchars($user->age);
	$user_about = htmlspecialchars($user->about);
	$user_city = htmlspecialchars($user->city);
	$username = htmlspecialchars($user->username);
}

if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['delete_id'])) {
	$post = new Post($_GET['delete_id'], $pdo);
	if ($_SESSION['id'] === $post->author_id || $_SESSION['username'] === "admin") {

		$post->delete($pdo);
		header('Location: vkontakte.php');
		exit();
	} else {$error = "Вы не можете удалить этот пост!";}
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

<main>
<div style='margin: 0 30%'>

<?php
if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['id'])) {
	
$post = new Post($_GET['id'], $pdo);
$title = htmlspecialchars($post->title);
$text = htmlspecialchars($post->text);
$author = htmlspecialchars($post->author);
echo <<<_END
<div class='post'> 
<h3 style='margin: 0;'>{$title}</h3>
<p>{$text}</p>
_END;
if (is_numeric($post->post_from)) {
echo "<small style='color: grey; font-weight: bold;'>".htmlspecialchars($post->date)." | ".htmlspecialchars($post->author)." | На стене @".htmlspecialchars($post->post_from_username)."</small>";
} else {
	echo "<small style='color: grey; font-weight: bold;'>".htmlspecialchars($post->date)." | ".htmlspecialchars($post->author)."</small>"; 
}
	if (isset($_SESSION['username'])) {
	if ($_SESSION['username'] === $post->author || $_SESSION['username'] == "admin"){
	echo '</p><a class="vk-button" href="?delete_id='.htmlspecialchars($post->id).'">Удалить</a>';
	}
	}
}
echo "</div>";
?>
<h3>Комментарий</h3>
<form method='POST'>
<textarea placeholder='Введите комментарий' name='text'></textarea>
<button type='submit' name='add_comment_btn'>Отправить</button>
</form>
<?php
if (isset($_POST['add_comment_btn']) && isset($_POST['text'])) {
	$post = new Post($_GET['id'], $pdo);
	$post->addComment($_POST['text'], $pdo);
	header('Location: '.$_SERVER['REQUEST_URI']);
	exit();
}

$post->showComment($pdo);
$comments = $post->comments;
if ($comments) {
	foreach ($comments as $comment) {
		$text = htmlspecialchars($comment['text']);
		$author = htmlspecialchars($comment['username']);
		echo <<<_END
			<div class='post' style='padding: 0 10px'>
			<p style= 'display: inline-block; margin: 10px 0 10px 3px'>{$text}</p><br>
			<small style='color: grey; font-weight: bold; display: inline-block; margin: 0 0 10px 3px'>@{$author}</small>
			</div>
		_END;
	}
}
?>
</div>

</main>
</body>
<html>	

