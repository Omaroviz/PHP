<?php
// ============================================
// РАБОТА С ТВОЕЙ БАЗОЙ test_db
// ============================================

// 1. Подключение (подставь свои данные, если отличаются)
$host = 'localhost';
$dbname = 'test_db';
$username = 'root';      // твой пользователь MariaDB
$password = '';          // твой пароль

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
    echo "Подключено к test_db<br><br>";
    
    // ============================================
    // 1. ВЫВЕСТИ ВСЕХ ПОЛЬЗОВАТЕЛЕЙ
    // ============================================
    echo "<b>Все пользователи:</b><br>";
    $stmt = $pdo->query("SELECT id, name, age, password FROM users");
    $users = $stmt->fetchAll();
    
    foreach ($users as $user) {
        echo "ID: {$user['id']} | Имя: {$user['name']} | Возраст: {$user['age']} | Пароль: {$user['password']}<br>";
    }
    
    // ============================================
    // 2. ПОЛУЧИТЬ ПОЛЬЗОВАТЕЛЯ ПО ID (prepare + execute)
    // ============================================
    echo "<br><b>Поиск пользователя с id = 1:</b><br>";
    $user_id = 1;
    $sql = "SELECT * FROM users WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $user_id]);
    $user = $stmt->fetch();
    
    if ($user) {
        echo "Найден: {$user['name']}, возраст {$user['age']}, пароль {$user['password']}<br>";
    } else {
        echo "Не найден<br>";
    }
    
    // ============================================
    // 3. ДОБАВИТЬ НОВОГО ПОЛЬЗОВАТЕЛЯ
    // ============================================
    echo "<br><b>Добавление нового пользователя:</b><br>";
    
    $new_name = "DeepSeek_Test";
    $new_age = 2;          // в честь версии 2.0
    $new_password = "ai_safe_pass";
    
    $sql = "INSERT INTO users (name, age, password) VALUES (:name, :age, :password)";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        'name' => $new_name,
        'age' => $new_age,
        'password' => $new_password
    ]);
    
    if ($result) {
        $new_id = $pdo->lastInsertId();
        echo "Добавлен пользователь '{$new_name}' с ID = {$new_id}<br>";
    } else {
        echo "Ошибка добавления<br>";
    }
    
    // ============================================
    // 4. ОБНОВИТЬ ВОЗРАСТ ПОЛЬЗОВАТЕЛЯ
    // ============================================
    echo "<br><b> Обновление возраста пользователя с id = 1:</b><br>";
    
    $update_id = 1;
    $new_age = 21;
    
    $sql = "UPDATE users SET age = :age WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['age' => $new_age, 'id' => $update_id]);
    
    echo "Обновлено строк: " . $stmt->rowCount() . "<br>";
    
    // Покажем обновлённого пользователя
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute(['id' => $update_id]);
    $updated_user = $stmt->fetch();
    echo "Теперь у {$updated_user['name']} возраст {$updated_user['age']}<br>";
    
    // ============================================
    // 5. УДАЛИТЬ ТЕСТОВОГО ПОЛЬЗОВАТЕЛЯ (которого добавили)
    // ============================================
    if (isset($new_id)) {
        echo "<br><b>Удаление тестового пользователя (ID = {$new_id}):</b><br>";
        
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $new_id]);
        
        echo "Удалено строк: " . $stmt->rowCount() . "<br>";
    }
    
    // ============================================
    // 6. ПОКАЗАТЬ, ЧТО ОСТАЛОСЬ В ТАБЛИЦЕ (С ОГРАНИЧЕНИЕМ)
    // ============================================
    echo "<br><b>📊 Итоговый список (первые 5 записей):</b><br>";
    $stmt = $pdo->query("SELECT id, name, age FROM users LIMIT 5");
    $few_users = $stmt->fetchAll();
    
    foreach ($few_users as $user) {
        echo "ID: {$user['id']} | Имя: {$user['name']} | Возраст: {$user['age']}<br>";
    }
    
} catch(PDOException $e) {
    die("❌ Ошибка: " . $e->getMessage());
}
?>
