<?php
include_once '../login.php';
$limit = 5; // сколько записей показывать на странице

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

$total_stmt = $pdo->query("SELECT COUNT(*) FROM users");
$total_rows = $total_stmt->fetchColumn();

$total_pages = ceil($total_rows / $limit);

if ($page > $total_pages && $total_pages > 0) {
    $page = $total_pages;
}

$offset = ($page - 1) * $limit;

$sql = "SELECT * FROM users LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$users = $stmt->fetchAll();

echo "<h3>Список пользователей (страница $page из $total_pages)</h3>";

echo "<table border='1'>";
echo "<tr><th>ID</th><th>Имя</th><th>Логин</th><th>Роль</th></tr>";

foreach ($users as $user) {
    echo "<tr>";
    echo "<td>" . $user['id'] . "</td>";
    echo "<td>" . $user['name'] . "</td>";
    echo "<td>" . $user['username'] . "</td>";
    echo "<td>" . $user['role'] . "</td>";
    echo "</tr>";
}
echo "</table>";

echo "<br>";

if ($page > 1) {
    echo "<a href='?page=" . ($page - 1) . "'>⬅ Назад</a> ";
} else {
    echo "⬅ Назад ";
}

for ($i = 1; $i <= $total_pages; $i++) {
    if ($i == $page) {
        echo "<strong>[$i]</strong> "; // текущая страница жирным
    } else {
        echo "<a href='?page=$i'>$i</a> ";
    }
}

if ($page < $total_pages) {
    echo "<a href='?page=" . ($page + 1) . "'>Вперед ➡</a>";
} else {
    echo "Вперед ➡";
}
?>
