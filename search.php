<!DOCTYPE html>
<html>
<head>
<title>Search</title>
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
<h2>Список пользователей</h2>
<?php
try {
    $conn = new PDO("mysql:host=localhost;dbname=test_db;charset=utf8mb4", "root", "");
    $sql = "SELECT id, name FROM users";
    $result = $conn->query($sql);
    echo "<table><tr><th>ID</th><th>Имя</th><th>Ссылка</th><th>Изменить</th></tr>";
    foreach($result as $row){
	echo "<tr>";
	    echo "<td>" . $row["id"] . "</td>";
	    echo "<td>" . $row["name"] . "</td>";
	    echo "<td><a href='user.php?id=" . $row["id"] . "' >Посмотреть</a></td>";
	    echo "<td><a href=\"update.php?id=".$row['id']."\">Изменить</a></td>";
	echo "</tr>";
    }
    echo "</table>";
}
catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>
</body>
</html>
