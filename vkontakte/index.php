<?php

include_once 'login.php';

session_start();


echo "Пользователи сайта: ";
$stmt = $pdo->query("SELECT * FROM users");
$users = $stmt->fetchAll();
foreach($users as $user) {
	echo $user['name'].", ";
}
echo "<br>";
if (isset($_SESSION['name']) && isset($_SESSION['username'])) {
	echo "Привет, ".$_SESSION['name'];
	echo "<br>";
	echo codetext("Отладка", "пользователь зарегистрирован");
} else {
	echo "Привет, гость!";
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo <<<_END
	<a href="sign.php">Войти</a>
	<a href="register.php">Регистрция</a><br><br>
_END;

echo <<<_END
	<form method="POST">
	<textarea name="post_title" placeholder="Заголовок" type="wrap" required></textarea><br>
	<textarea name="post_text" placeholder="Что у вас нового?..." type="wrap" required></textarea><br>
	<button type="submit" name="add_post">Готово</button>
	</form>
	_END;
if ($_SERVER['REQUEST_METHOD'] === "POST"  && isset($_POST['add_post']) &&
	$_SESSION['username'] && !empty($_POST['post_text'])) {
	echo codetext("Отладка", "Добавил пост");
	$sql = "INSERT INTO posts(title, text, author) VALUES(:title, :text, :author)";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([
		":title" => $_POST['post_title'],
		":text" => $_POST['post_text'],
		":author" => $_SESSION['username']
	]);
	header("Location: " . $_SERVER['PHP_SELF']);
	exit();
}

echo <<<_END
	<style>
	.post {
		background-color: Gainsboro;
		border: 2px black solid;
		margin: 5px;
		padding: 10px 5px;
	}
	</style>
_END;
$stmt = $pdo->query("SELECT * FROM posts");
$posts = $stmt->fetchAll();
foreach ($posts as $post) {
		echo <<<_END
    <div class="post">
	<h3 style="margin: 0;">
_END;
        echo htmlspecialchars($post['title']);
        echo <<<_END
</h3>
	<p style="margin: 0;">
_END;
        echo htmlspecialchars($post['text']);
        echo <<<_END
</p>
    </div>
_END;

}








