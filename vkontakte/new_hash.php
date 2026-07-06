<?php

if ($_SERVER['REQUEST_METHOD'] === "POST") {
	echo password_hash($_POST['password'], PASSWORD_DEFAULT);
}
?>
<!DOCTYPE html>
<html lang='ru'>
<head>
<title>Получтить новый Hash</title>
</head>
<body>
<form method='POST'>
<input type='text' name='password' placeholder='Новый пароль'>
<button type='text' name='ok'>Готово</button>
</form>
</body>
</html>



