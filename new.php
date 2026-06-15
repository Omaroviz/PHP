<?php
$host = 'localhost';
$dbname = 'publications';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", 
                   $username, 
                   $password);
    
    // Устанавливаем режим ошибок: исключения
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Устанавливаем режим выборки по умолчанию (ассоциативный массив)
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
    //echo "Подключено успешно!";
    
} catch(PDOException $e) {
    die("Ошибка подключения: " . $e->getMessage());
}
if (isset($_GET['delete_id'])) {
    $sql = "DELETE FROM users WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $_GET['delete_id']]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
$stmt = $pdo->query("SELECT * FROM users"); 
$users = $stmt->fetchAll();

echo <<<_END

	<style>
	table, th, td {
    		border: 1px solid #333;
   		border-collapse: collapse;
  		padding: 10px;
	}
	</style>
	<table><thead><tr>
	<th>ID</th>
	<th>Имя</th>
	<th>Никнейм</th>
	<th>Пароль</th>
	<th>Роль</th>
	<th>Действия</th>
	</tr></thead>
	<tbody>

_END;
foreach ($users as $user) {
	echo "<tr>";
	echo "<td>".$user['id'] . "</td>";
	echo "<td>".$user['name'] . "</td>";
	echo "<td>".$user['username'] . "</td>";
	echo "<td>".$user['password'] . "</td>";
	echo "<td>".$user['role'] . "</td>";
	echo "<td><a href='?delete_id=".$user['id']."' onclick='return confirm(\"Точно удалить?\")'>Удалить</a><td>";
	echo "</tr>";
}

echo "</tbody></table>";
// 2. Получить одну строку
// $stmt = $pdo->query("SELECT * FROM users WHERE id = 3");
$user = $stmt->fetch();
if ($user) {
echo "Вся информация о пользователе с id = ".$user['id'].": <br>";
foreach ($user as $detail) {
	echo $detail." | ";
}} else {echo "Пользователь не найден";}
echo "<br>";

// 3. Получить одно значение
$stmt = $pdo->query("SELECT COUNT(*) FROM users");
echo "Всего пользователей: ".$stmt->fetchColumn();

?>
<!DOCTYPE html>
<html>
<head>
<title>php -> hph</title>
</head>
<body>
<form method="POST">
<input type="text" name="name" placeholder="Имя">
<input type="text" name="username" placeholder="Никнейм">
<input type="text" name="password" placeholder="Пароль">
<input type="text" name="role" placeholder="Роль">
<button type="submit" name="submit_btn">Готово</button>
</form>
<?php
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['submit_btn'])) {
	$sql = "INSERT INTO users(name, username, password, role) VALUES(:name, :username, :password, :role)";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([
		':name' => $_POST['name'],
		':username' => $_POST['username'],
		':password' => $_POST['password'],
		':role' => $_POST['role'],
	]);
	header("Location: ".$_SERVER['PHP_SELF']);
	exit();	
}
?>
</body>
</html>
