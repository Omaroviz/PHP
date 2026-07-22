<?php
if (empty($_COOKIE['theme'])) {
setcookie('theme', 'dark', [
    'expires'  => time() + 31536000, // на 1 год
    'path'     => '/',               // доступна на всем сайте
    'domain'   => '',                // пусто для локального хоста
    'secure'   => false,             // false, так как на localhost обычно нет HTTPS
    'httponly' => true,              // защита от XSS-атак (куку нельзя украсть через JS)
    'samesite' => 'Lax'              // базовая защита от CSRF-атак
]);
echo "Добавил куки";
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && 
	!empty($_POST['title']) &&
	!empty($_POST['text']) &&
	isset($_POST['newCookie_btn'])
) {
	
setcookie($_POST['title'], $_POST['text'], [
    'expires'  => time() + 60, // на 1 год
    'path'     => '/',               // доступна на всем сайте
    'domain'   => '',                // пусто для локального хоста
    'secure'   => false,             // false, так как на localhost обычно нет HTTPS
    'httponly' => true,              // защита от XSS-атак (куку нельзя украсть через JS)
    'samesite' => 'Lax'              // базовая защита от CSRF-атак
]);
header('Location: '.$_SERVER['PHP_SELF']);
exit();
}

var_dump($_COOKIE);echo "<br>";
echo $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang='ru'>
<head>
<title>Cookie.php</title>
</head>
<body>

<form method='POST'>
<input type='text' name='title' placeholder='Введите название куки'><br>
<input type='text' name='text' placeholder='Введите текст куки'><br>
<button type='submit' name='newCookie_btn'>Готово</button>
</form>

</body>
</html>
