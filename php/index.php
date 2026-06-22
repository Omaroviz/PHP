<?php

include_once "../login.php";



$sql = "SELECT * FROM products";
$stmt = $pdo->query($sql);
$users = $stmt->fetchAll();
foreach ($users as $user) {
	echo <<<_END
		ID: {$user['id']}<br>
		Name: {$user['name']}<br>
		Price: {$user['price']}<br><br>
		_END;
}

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['add_product'])) {
	if (!empty($_POST['name']) &&
		!empty($_POST['price'])) {
		$find_users = [];
		$find_users[$_POST['name']] = $_POST['price'];
		$sql = "INSERT INTO products(name, price) VALUES(:name, :price)";
		$stmt = $pdo->prepare($sql);
		$users = $stmt->execute([':name' => $_POST['name'], ':price' => $find_users[$_POST['name']]]);
		print($users);
		header("Location: " . $_SERVER['PHP_SELF']);
		exit();

	}
}
	
?>
<!DOCTYPE html>
<html>
<head>
<title>PHP</title>
</head>
<body>
<form method="post">
<input type="text" name="name" placeholder="Name"><br>
<input type="text" name="price" placeholder="Price"><br>
<button type="submit" name="add_product">Enter</button>
</form>
</body>
</html>





