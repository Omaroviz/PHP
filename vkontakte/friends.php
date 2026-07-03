<?php

include_once 'login.php';

session_start();

$stmt = $pdo->query('SELECT * FROM users ORDER BY id DESC');
$users = $stmt->fetchAll();

function user_info($id) {
global $pdo;
$stmt = $pdo->prepare('SELECT * FROM users_info WHERE id = :id');
$stmt->execute([':id' => $id]);
return $stmt->fetch();
}
?>

	<!DOCTYPE html>
	<html lang="ru">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="vkontaktestyle.css" type="text/css" media="all"/>
		<title>Мои друзья</title>
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
			if (isset($_SESSION['id'])) {
			echo '<a href="logout.php" class="vk-button" id="userStatus">Выход</a>';	
			} else {
			echo '<a href="sign.php" class="vk-button" id="userStatus">Вход</a>';}
?>
</div>
	</div>

	</header>
	<main class="friends-page-layout">
		<aside class="friends-sidebar">
					<div class="friends-mini" style="justify-content: normal">
						<!--<span class="friends-mini-logo" id="friends-userNameTwo">DO</span>-->
						<span id="friends-userName-friends-mini" class="sidebar-userName">
						<b><?php 
						if (isset($_SESSION['id'])) {
							echo $_SESSION['name'];
						} else {
							echo "Guest";}
						?>

						</b>
						</span>
					</div>
					<?php
						//var_dump($_SESSION);
						if (isset($_SESSION['id'])) {
							echo htmlspecialchars(user_info($_SESSION['id'])['about']);
						}
					?>
		</aside>

		<div class="main-content">
<?php
foreach ($users as $user) {

	$stmt = $pdo->prepare("SELECT * FROM users_info WHERE id = :id");
	$stmt->execute([':id' => $user['id']]);
	$user_info = $stmt->fetch();

echo <<<_END
			<article class="friends-window">
				<div class="friends-mini">
					<span class="friends-mini-logo">DO</span>
_END;
					echo htmlspecialchars($user['name']);
echo <<<_END
					<div class="friends-mini-buttons">
						<a href="profile.php?id={$user['id']}" class="friends-button">Профиль</a>
						<a href="#" class="friends-button">Написать</a>
					</div>
				</div><p style='margin: 8px 0 5px 0'>
				_END;
if (isset($user_info['about'])) {
	echo htmlspecialchars($user_info['about']);
}
echo <<<_END
			</p></article>
			_END;
			}
		?>
		</div>
	</main>
	</body>

	</html>


















