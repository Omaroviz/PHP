<?php

include_once 'login.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['find_user_btn']) && !empty($_POST['find_text'])) {
	$sql = "SELECT * FROM users WHERE username = :username";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([":username" => $_POST['find_text']]);
	$user = $stmt->fetch();
	if ($user) {
		header('Location: profile.php?id='.$user['id']);
		exit();
	} else {
		echo "Пользователь не найден";
	}

}


