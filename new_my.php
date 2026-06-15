<?php

$host = 'localhost';
$dbname = 'publications';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", 
                   $username, 
                   $password);
    
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch(PDOException $e) {
    die("Ошибка подключения: " . $e->getMessage());
}

if (isset($_GET['delete_id'])) {
	$sql = "DELETE FROM users WHERE id = :id";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([
		":id" => $_GET['delete_id']
	]);
	header("Location: " . $_SERVER['PHP_SELF']);
    	exit();}

echo <<<_END
	<style>
	table, th, td {
    		border: 1px solid #333;
   		border-collapse: collapse;
  		padding: 7px 10px;
	}
	</style>
	<table><thead><tr>
	<th>ID</th>
	<th>Name</th>
	<th>Username</th>
	<th>Password</th>
	<th>Role</th>
	<th>Use</th>
	</tr></thead><tbody>
_END;

$stmt = $pdo->query("SELECT * FROM users;");
$users = $stmt->fetchAll();

foreach ($users as $user) {
	echo <<<_END
		<tr>
		<td>{$user["id"]}</td>
		<td>{$user["name"]}</td>
		<td>{$user["username"]}</td>
		<td>{$user["password"]}</td>
		<td>{$user["role"]}</td>
		<td><a href="?delete_id={$user['id']}">Удалить</a></td>
		</tr>
_END;
}

echo "</tbody></table>";

if ($_SERVER['REQUEST_METHOD'] === "POST" && 
	$_POST['enter_btn'] &&
	$_POST['name'] &&
	$_POST['username'] &&
	$_POST['password'] &&
	$_POST['role']
) {
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

$stmt = $pdo->query("SELECT * FROM users WHERE id = 2");
$user = $stmt->fetch();
if ($user) {
foreach ($user as $info) {
	echo $info." | ";
}
echo "<br>Использовался метод fetch()<br>";
} else {echo "Пользователь не найден";}

$stmt = $pdo->query("SELECT COUNT(*) FROM users");
echo "<br>Всего пользователей: ";
echo $stmt->fetchColumn().". Использовался метод fetchColumn().";

?>


<!DOCTYPE html>
<html>
<head>
<title>new_my</title>
</head>
<body>
<form method="POST">
<input type="text" name="name" placeholder="Name"><br>
<input type="text" name="username" placeholder="Username"><br>
<input type="text" name="password" placeholder="Password"><br>
<input type="text" name="role" placeholder="Role"><br>
<button type="submit" name="enter_btn">Enter</button>
</form>
</body>
</html>
