<?php

include_once '../login.php';

echo "Login.php подключен";

echo <<<_END
	<form method="POST">
	<input type="text" name="name" placeholder="Name" required><br>
	<input type="text" name="password" placeholder="Password" required><br>
	<button name="new_user">Enter</button>
	</form><br><form method="POST">
	<input type="text" name="sign_name" placeholder="Sing-in Name" required>
	<input type="password" name="sign_password" placeholder="Sing-in Password" required>
	<button type="submit" name="sign_btn">Sign-in</button>
	</form>

	_END;

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['new_user'])) {
	echo "Принял";
	$sql = "INSERT INTO password(name, password) VALUES(:name, :password)";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([':name' => $_POST['name'], ':password' => password_hash($_POST['password'],  PASSWORD_DEFAULT)]);
	header("location: " . $_SERVER['PHP_SELF']);
	exit();
} else if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['sign_btn'])){
	echo "Okay";
	$user = 'SELECT * FROM password WHERE name = :name';
	$stmt = $pdo->prepare($user);
	$stmt->execute([':name' => $_POST['sign_name']]);
	$user = $stmt->fetch();
	$my_pass = $_POST['sign_password'];
	$hash_pass = $user['password'];
	if ($user && password_verify($my_pass, $hash_pass)) {
	 	echo "Сработало!";
	} else {
		echo "Подумай еще:(";
	}
	//header("location: " . $_server['php_self']);
	//exit();
}

