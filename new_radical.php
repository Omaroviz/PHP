<!DOCTYPE html>
<html>
<head>
<title>new_radical</title>
</head>
<body>
<h1>Панель управления</h1>

<?php

$host = 'localhost';
$dbname = 'publications';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",$username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch(PDOException $e) {
    die("Ошибка подключения: " . $e->getMessage());
}

if (isset($_GET['info_id'])) {
	$sql = "SELECT * FROM users WHERE id = :id";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([':id' => $_GET['info_id']]);
	$info = $stmt->fetch();
	if ($info) {
		echo <<<_END
		<style>
			.btn_clck {
				font-family: Arial;
				background-color: grey;
				padding: 5px 9px;
				margin: 10px;
				display: block;
				max-width: 100px;
				text-align: center;
				border: 1px solid #45688e; 
				text-decoration: none;
				color: black;
			}
			.btn_clck:hover {
				border: 1px solid white;
			}
		</style>
		Name: {$info['name']}<br>
		Username: {$info['username']}<br>
		Password: {$info['password']}<br>
		Role: {$info['role']}<br>
		<a href="new_radical.php" class="btn_clck">Назад</a>
		_END;
	} else {echo "Пользователя не существует";}
	exit();
}

if (isset($_GET['delete_id'])) {
	$sql = "DELETE FROM users WHERE id = :id";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([
		":id" => $_GET['delete_id']
	]);
	header("Location: " . $_SERVER['PHP_SELF']);
	exit();
} 
if (isset($_GET['update_id'])) {
	$sql = "SELECT * FROM users WHERE id = :id";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([':id' => $_GET['update_id']]);
	$edit_user = $stmt->fetch();
}

echo <<<_END
	<style>
	table, th, td {
		border: 1px solid black;
		border-collapse: collapse;
		padding: 5px 10px;
	}
	* {font-family: Tahoma, Arial. sans-serif;}
	h1 {
		margin: 8px 10px;
	}
	</style>
	<table><thead><tr>
	<th>ID</th>
	<th>Name</th>
	<th>UserName</th>
	<th>Password</th>
	<th>Role</th>
	<th>Delete</th>
	<th>Update</th>
	<th>Info</th>
	</tr></thead><tbody>
	_END;

$stmt = $pdo->query("SELECT * FROM users");
$users = $stmt->fetchAll();
echo $users['id'];
foreach ($users as $user) {
	echo <<<_END
		<tr>
		<td>{$user['id']}</td>
		<td>{$user['name']}</td>
		<td>{$user['username']}</td>
		<td>{$user['password']}</td>
		<td>{$user['role']}</td>
		<td><a href="?delete_id={$user['id']}">Delete</a></td>
		<td><a href="?update_id={$user['id']}">Update</a></td>
		<td><a href="?info_id={$user['id']}">Info</a></td>
		</tr>
		_END;
}

if ($edit_user) {
	echo "<br>Редактирование данных @".$edit_user['username'].".<br>";
	echo <<<_END
		<form method="POST">
		<input type="text" name="name" placeholder="Введите новое имя"><br>
		<input type="text" name="username" placeholder="Введите новый псевдоним"><br>
		<input type="text" name="password" placeholder="Введите новый пароль"><br>
		<input type="text" name="role" placeholder="Введите новую роль"><br>
		<input type="hidden" name="id" value="{$edit_user['id']}">
		<button type="submit" name="updateget_btn">Готово</button>
		</form>
		_END;
	if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['updateget_btn'])){
	$sql = "UPDATE users SET name = :name, username = :username, password = :password, role = :role WHERE id = :id";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([
		":name" => $_POST['name'],
		":username" => $_POST['username'],
		":password" => $_POST['password'],
		":role" => $_POST['role'],
		":id" => $_POST['id']
	]);
	exit();}

}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
	if (isset($_POST['find_btn']) && $_POST['find_user']) {	
		$sql = "SELECT * FROM users WHERE id = :id";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([":id" => $_POST['find_user'],]);
		// $stmt = $pdo->query($sql);
		$user = $stmt->fetch();	
			echo <<<_END
				Вся информация о пользователе @{$user['username']}:<br>
				Имя: {$user['name']}<br>
				Псеводним: {$user['username']}<br>
				Пароль: {$user['password']}<br>
				Роль: {$user['role']}<br>
				_END;
	} else if (isset($_POST['input_btn']) &&
		!empty($_POST['name']) &&
		!empty($_POST['username']) &&
		!empty($_POST['password']) &&
		!empty($_POST['role'])
	) {
		// echo "Тут"; exit();
		$sql = "INSERT INTO users(name, username, password, role) VALUES(:name, :username, :password, :role)";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([
			":name" => $_POST['name'],
			":username" => $_POST['username'],
			":password" => $_POST['password'],
			":role" => $_POST['role'],
		]);
		header("Location: ".$_SERVER['PHP_SELF']);
		exit();
	}
}
$sql = "SELECT * FROM users WHERE id = 1";
$stmt = $pdo->query($sql);
$users = $stmt->fetch();
if ($users) {
	echo "Псеводним пользователя ID ".$users['id'].": ".$users['username'];
}
echo "<br>";

$sql = "SELECT COUNT(*) FROM users";
$stmt = $pdo->query($sql);
echo "Всего пользователей: ".$stmt->fetchColumn();



?>

<br>
<form method="POST">
<input type="text" name="find_user" placeholder="Find user">
<button type="submit" name="find_btn">Enter</button><br><br>
</form>

<form method="POST">
<input type="text" name="name" placeholder="Name"><br>
<input type="text" name="username" placeholder="Username"><br>
<input type="text" name="password" placeholder="Password"><br>
<input type="text" name="role" placeholder="Role"><br>
<button type="submit" name="input_btn" style="width: 180px; text-align: center;">Enter</button>
</form>
</body>
</html>
