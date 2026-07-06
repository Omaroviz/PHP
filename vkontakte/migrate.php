<?php
include_once 'login.php';

$stmt = $pdo->query("SELECT id, password FROM users");
$users = $stmt->fetchAll();

foreach ($users as $user) {
    // Если пароль уже захэширован (начинается с $2y$), пропускаем
    if (strpos($user['password'], '$2y$') === 0) {
        continue;
    }
    
    $hash = password_hash($user['password'], PASSWORD_DEFAULT);
    
    $update = $pdo->prepare("UPDATE users SET password = :hash WHERE id = :id");
    $update->execute([
        ':hash' => $hash,
        ':id' => $user['id']
    ]);
    
    echo "Обновлён пользователь ID: " . $user['id'] . "<br>";
}

echo "Готово!";
?>
