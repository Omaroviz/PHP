<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);include_once 'login.php';

if ($_SERVER['REQUEST_METHOD'] === "POST" && 
	isset($_POST['password_btn']) && 
	!empty($_POST['password']) && 
	!empty($_POST['name']) && 
	!empty($_POST['username']) &&
	!empty($_POST['password'])) {
	$sql = "INSERT INTO users(name, username, password, role) VALUES(:name, :username, :password, :role)";
	$stmt = $pdo->prepare($sql);
	$hashed = password_hash($_POST['password'], PASSWORD_DEFAULT);
	$stmt->execute([
		":name" => $_POST['name'],
		":username" => $_POST['username'],
		":password" => $hashed,
		":role" => $_POST['role']
	]);
}
?> 

<!DOCTYPE html>
<html>
<head>
<title>Reg.php</title>
</head>
<body>
<form method="POST">
<input type="text" name="name" placeholder="Name">
<input type="text" name="username" placeholder="Username">
<input type="text" name="password" placeholder="Password">
<input type="text" name="role" placeholder="Role">
<button type="submit" name="password_btn">Enter</button>
</form>
</body>
<html>
