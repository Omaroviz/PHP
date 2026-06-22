<?php
// Временно закомментируем твой login.php, чтобы проверить, что код вообще работает
// include_once '../login.php';

// ВРЕМЕННОЕ ПОДКЛЮЧЕНИЕ (потом вернешь свое)
$host = 'localhost';
$dbname = 'publications';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Ошибка подключения: " . $e->getMessage());
}

// ===== ПАГИНАЦИЯ =====
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

$limit = 5;
$offset = ($page - 1) * $limit;

// ===== ВЫВОД ТАБЛИЦЫ =====
echo "<table border='1'>";
echo "<thead><tr><th>ID</th><th>Name</th><th>Username</th></tr></thead>";
echo "<tbody>";

$sql = "SELECT * FROM users LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$users = $stmt->fetchAll();

if (count($users) == 0) {
    echo "<tr><td colspan='3'>Нет пользователей</td></tr>";
} else {
    foreach ($users as $user) {
        echo "<tr>";
        echo "<td>{$user['id']}</td>";
        echo "<td>{$user['name']}</td>";
        echo "<td>{$user['username']}</td>";
        echo "</tr>";
    }
}

echo "</tbody></table>";

// ===== СЧИТАЕМ СТРАНИЦЫ =====
$total = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$total_pages = ceil($total / $limit);

echo "<br>";

// ===== ССЫЛКИ =====
if ($page > 1) {
    echo "<a href='?page=" . ($page - 1) . "'>Назад</a> ";
}

for ($i = 1; $i <= $total_pages; $i++) {
    if ($i == $page) {
        echo "<strong>[$i]</strong> ";
    } else {
        echo "<a href='?page=$i'>$i</a> ";
    }
}

if ($page < $total_pages) {
    echo "<a href='?page=" . ($page + 1) . "'>Вперед</a>";
}
?>
