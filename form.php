<?php
/*
if ($_SERVER["REQUEST_METHOD"] == 'POST') {
	$num1 = (float)$_POST['num1'];
	$num2 = (float)$_POST['num2'];
	echo $num1 + $num2;
}
 */

$host = 'localhost';
$user = 'root';        // пользователь БД
$password = '';        // пароль (у XAMPP/WAMP по умолчанию пустой)
$dbname = 'test_db';

// Создаем соединение
$mysqli = new mysqli($host, $user, $password, $dbname);

// Проверяем ошибки
if ($mysqli->connect_error) {
    die("Ошибка подключения: " . $mysqli->connect_error);
}

// Устанавливаем кодировку (очень важно для русского языка)
$mysqli->set_charset("utf8mb4");

echo "Успешное подключение!<br>";
?>

<!DOCTYPE html>
<head>
<title>Document</title>
</head>
<body>

<form method="POST">
<input type="text" name="num1">
<input type="text" name="num2">
<button type="submit">Готово</button>
</form>

</body>
</html>








