<!DOCTYPE html>
<html>
<head>
<title>METANIT.COM</title>
<meta charset="utf-8" />

<style>

table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
        padding: 5px 10px;
    }
</style>

</head>
<body>
<?php
if (isset($_POST["username"]) && isset($_POST["userage"]) && isset($_POST['password'])) {
     
    try {
	    $conn = new PDO("mysql:host=localhost;dbname=test_db;charset=utf8mb4", 'root', '');        
	   $sql = "INSERT INTO users (name, age, password) VALUES (:username, :userage, :password)";
	    // определяем prepared statement
	if ($_POST['userage'] && $_POST['username'] && $_POST['password']) {
        $stmt = $conn->prepare($sql);
	 
	// привязываем параметры к значениям
	$stmt->bindValue(":username", $_POST["username"]);
	$stmt->bindValue(":password", $_POST['password']);
        $stmt->bindValue(":userage", $_POST["userage"]);
        // выполняем prepared statement
        $affectedRowsNumber = $stmt->execute();
        // если добавлена как минимум одна строка
        if($affectedRowsNumber > 0 ){
            echo "Подключение к базе данных: Готово.<br>Name: " . $_POST["username"] ."<br>Age:  " . $_POST["userage"];  
	}

	$sql_command = "SELECT * FROM users";
	$result = $conn->query($sql_command);
	// $row = $result->fetch();
	echo "<table><tr><th>ID</th><th>Name</th><th>Age</th><th>Password</th></tr>";
	while ($row = $result->fetch()) {
		echo "<tr>";

		echo "<td>". $row['id']."</td>";
		echo "<td>". $row['name']."</td>";	
		echo "<td>".$row['age']."</td>";
		echo "<td>".$row['password']."</td>";

		echo "</tr>";
	}
	echo "</table>";
	} else {
		echo "Заполните все поля!";
	}
    }
    catch (PDOException $e) {
        echo "Подключение к базе данных: <span style=\"font-weight: bold;\">ОШИБКА.</span><br>" . $e->getMessage();
    }
}
?>
<h3>Создать нового пользователя.</h3>
<form method="post">
    <p>Имя пользователя:
    <input type="text" name="username" /></p>
    <p>Возраст пользователя:
    <input type="number" name="userage" /></p>
    <p>Пароль:
    <input type="text" name="password"></p>
    <input type="submit" value="Готово">
</form>

</html>
