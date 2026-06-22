<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once '../login.php';

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


$stmt = $pdo->query('SELECT * FROM users;');
while ($row = $stmt->fetch()) {
	echo <<<_END
		<tr>
		<td>{$row['id']}</td>
		<td>{$row['name']}</td>
		<td>{$row['username']}</td>
		<td>{$row['password']}</td>
		<td>{$row['role']}</td>
		</tr>
		_END;
}

echo "</tbody></table>";

if ($_SERVER['REQUEST_METHOD'] === "POST" &&
	isset($_POST['new_user']),
	!empty($_POST['name']),
	!empty($_POST['username']),
	!empty($_POST['password']),
	!empty($_POST['role'])
) {
	$sql = "INSERT INTO ";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Feed</title>
</head>
<body>
<form method="POST">
<input type="text" name="name" placeholder="Name"><br>
<input type="text" name="username" placeholder="Username"><br>
<input type="text" name="password" placeholder="Password"><br>
<input type="text" name="role" placeholder="Role"><br>
<button type="submit" name="new_user">Enter</button>
</form>
<body>
<html>
