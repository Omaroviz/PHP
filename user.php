<!DOCTYPE html>
<html>
<head>
<title>User<title>
<meta charset="utf-8" />
</head>
<body>
<?php
if(isset($_GET["id"]))
{
    try {
       $conn = new PDO("mysql:host=localhost;dbname=test_db;charset=utf8mb4", 'root', ''); 
        $sql = "SELECT * FROM users WHERE id = :userid";
        $stmt = $conn->prepare($sql);
        // привязываем значение параметра :userid к $_GET["id"]
        $stmt->bindValue(":userid", $_GET["id"]);
        // выполняем выражение и получаем пользователя по id
        $stmt->execute();
        if($stmt->rowCount() > 0){
            foreach ($stmt as $row) {
              $username = $row["name"];
	      $userage = $row["age"];
	      $password = $row['password'];
             
              echo "<div>
                    <h3>Информация о пользователе</h3>
                    <p>Имя: $username</p>
		    <p>Возраст: $userage</p>
		    <p>Пароль: $password</p>
                </div>";
            }
        }
        else{
            echo "Пользователь не найден";
        }
    }
    catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}
?>




<h1>Поиск по ID</h1>
<form action="user.php" method="GET">
<input type="text" name="id" placeholder="ID">
<button type="submit">Готово</button>
</form>
</body>
</html>
