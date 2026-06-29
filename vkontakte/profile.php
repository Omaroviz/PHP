<?php

include_once 'login.php';

session_start();

if (!isset($_SESSION['username'])) {
	header('Location: sign.php');
	exit();
}

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['add_post'])
	&& !empty($_POST['title']) && !empty($_POST['text'])) {
	$sql = "INSERT INTO posts(title, text, author, author_id, post_from) VALUES(:title, :text, :author, :author_id, :post_from)";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([
		":title" => $_POST['title'],
		":text" => $_POST['text'],
		":author" => $_SESSION['username'],
		":author_id" => $_SESSION['id'],
		":post_from" => $_GET['id']
	]);
	header("Location: ".$_SERVER['REQUEST_URI']);
	exit();
}

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['city_btn'])) {
	echo codetext('Отладка', "полковнику никто не пишет"); 
	echo $_POST['city'];
	$stmt = $pdo->prepare("UPDATE users_info SET city = :city WHERE id = :id");
	$stmt->execute([
		':city' => $_POST['city'],
		':id' => $_SESSION['id']
	]);
	header('Location: profile.php?id='.$_SESSION['id']);
	exit();
}

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['about_btn'])) {
	$sql = "UPDATE users_info SET about = :about WHERE id = :id";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([
		':about' => $_POST['about'],
		':id' => $_SESSION['id']
	]);
	header("Location: profile.php?id=".$_SESSION['id']);
	exit();
}
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
			<a href="friends.html" class="vk-button">Друзья</a>
		</div>

		<div class="vk-right" id="vk-right">

			<form method="GET" action="search.php" style="margin: 0; padding: 0">
			<input type="text" name="find" placeholder="Поиск" style="margin: 0; padding-left: 9px;">
			<button type="submit">Поиск</button>
			</form>

			<a href="https://vkontakte.ucoz.site/online-1/messages.html" class="vk-button">Сообщения</a>
			<a href="#" class="vk-button">Поиск</a>
			<a href="login.html" class="vk-button" id="userStatus">Вход</a>
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
						<h1 class="profileName"><span><?php echo htmlspecialchars($profile['name']);?></span></h1>
						<h3>Личная информация:</h3>
						<ul>
						<li>Никнейм: <span id="profile-info-userName"><?php echo htmlspecialchars($profile['username'])?></span></li>
							<li>Возраст: <span id="profile-info-age">21</span>
<?php
if ($edit_profile) {echo '<button class="vk-button-btn" style="max-width: 100px; text-align: center; padding: 1px; font-size: 10px">Изменить</button>';}
?>
</li>
							<li>
								<label for="city-select">Город: <?php echo $profile_info['city'];?></label>
								<?php
								if ($edit_profile) {
								echo <<<_END
								<form method="POST">
								<select id="city-select" class="vk-button-btn" style="max-width: 120px; padding: 1px; font-size: 10px" name="city">
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
							<button type="submit" name="city_btn" class="vk-button-btn" style="padding: 0 10px">Готово</button>
							</form>
							_END;
								}
							?>
							</li>
<li>    <form method="POST">
	<label>О себе: </label>
	    <span><?php 
	$about = $profile_info['about'] ?? '';
echo nl2br(htmlspecialchars(wordwrap($about, 30, "\n", true)));	?>
<?php if ($edit_profile) { ?>
            <textarea name="about" placeholder="Напишите о себе..."></textarea><br>
            <button type="submit" name="about_btn" class="vk-button-btn">Сохранить</button>
	<?php } ?>    
</form>
</li>
							</li>
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
							$sql = "SELECT * FROM posts WHERE post_from = :id ORDER BY id DESC";
							$stmt = $pdo->prepare($sql);
							$stmt->execute([':id' => $_GET['id']]);
							$post = $stmt->fetchAll();
?>
<?php if (count($post) > 0): ?>
    <?php foreach ($post as $info): ?>
        <div class="post">
            <h3><?php echo htmlspecialchars($info['title']); ?></h3>
            <p><?php echo nl2br(htmlspecialchars($info['text'])); ?></p>
            <small><?php echo htmlspecialchars($info['author']); ?></small>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="post">
        <p>Нет постов</p>
    </div>
<?php endif; ?>				</div>
			</div>
		</div>
	</div>
</main>

</body>

</html>
































