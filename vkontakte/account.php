<?php

include_once 'login.php';

session_start();

if (!isset($_SESSION['id'])){
	header("Location: sign.php");
	exit();
}

echo "Продолжение.<br>";
?>


<!DOCTYPE html>
<html lang='ru'>
<head>
<title>Аккаунт</title>
</head>
<body>
<h2>Изменить пароль</h2>
<form method='POST'>

<input type='text' name='old_password' placeholder='Старый пароль' required><br>
<input type='text' name='new_password' placeholder='Новый пароль' required><br>
<input type='text' name='new2_password' placeholder='Повторите пароль' required><br>
<button type='submit' name='edit_password_btn'>Готово</button>
</form>

<?php
if (
	!empty($_POST['old_password']) &&
	!empty($_POST['new_password']) &&
	!empty($_POST['new2_password'])
) {
	if ($_POST['new2_password'] === $_POST['new_password']) {
	
		$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
		$stmt->execute([':id' => $_SESSION['id']]);
		$user_password = $stmt->fetch();
		echo "Отладка: ";var_dump($user_password);echo "<br>";
		if (password_verify($_POST['old_password'], $user_password['password'])) {
			echo "Молодец, малыш!<br>";
			$stmt = $pdo->prepare("UPDATE users SET password = :password WHERE id = :id");
			$hashed = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
			$stmt->execute([
				':password' => $hashed,
				':id' => $user_password['id']
			]);
		} else {
			echo "Неверный старый пароль";
		}	
	} else {
		echo 'Новые пароли не совпадают!';
	}

} else {
	echo "Заполните все поля!";
}
?>

</body>
<html>	











