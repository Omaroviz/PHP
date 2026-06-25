<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once "login.php";


echo codetext("Отладка", "тест отладки");

echo <<<_END
	<h3>Зарегистрироваться</h3>
	<form method="POST">
	<input type="text" name="name" placeholder="Введите имя" required><br>
	<input type="text" name="username" placeholder="Введите псеводним" required><br>
	<input type="text" name="password" placeholder="Введите пароль" required><br>
	<button type="submit" name="register_btn">Готово</button>
	</form>
	_END;

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['register_btn'])) {
	echo codetext("Отладка","получил POST-запрос");
	$sql = "SELECT * FROM users WHERE username = :username";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([":username" => $_POST['username']]);
	$user = $stmt->fetch();
	if ($user) {
		echo "Пользователь с таким ником уже существует";
	} else {
		echo codetext("Отладка", "добавляем пользователя в Database");
		$sql = "INSERT INTO users(name, username, password) VALUES(:name, :username, :password)";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([
			":name" => $_POST['name'], 
			":username" => $_POST['username'], 
			":password" => password_hash($_POST['password'], PASSWORD_DEFAULT),
		]);
		header("Location: " . $_SERVER['PHP_SELF']);
    		exit();
	}
}












