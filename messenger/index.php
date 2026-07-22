<?php
// ==================== КОНФИГ ====================
$host = 'localhost';
$dbname = 'messenger';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка БД: " . $e->getMessage());
}

session_start();

// ==================== ШИФРОВАНИЕ ====================
$encryption_key = 'my_secret_key_1234567890123456';

function encrypt_text($text, $key) {
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    return base64_encode($iv . openssl_encrypt($text, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv));
}

function decrypt_text($data, $key) {
    $data = base64_decode($data);
    $iv_len = openssl_cipher_iv_length('aes-256-cbc');
    $iv = substr($data, 0, $iv_len);
    return openssl_decrypt(substr($data, $iv_len), 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
}

// ==================== РЕГИСТРАЦИЯ / ВХОД ====================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    try {
        $stmt->execute([$username, $password]);
        $_SESSION['user_id'] = $pdo->lastInsertId();
        $_SESSION['username'] = $username;
        header("Location: ?");
        exit();
    } catch (PDOException $e) {
        $error = "Такой логин уже существует";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$_POST['username']]);
    $user = $stmt->fetch();
    if ($user && password_verify($_POST['password'], $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: ?");
        exit();
    } else {
        $error = "Неверный логин или пароль";
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ?");
    exit();
}

// ==================== AJAX-ОБРАБОТЧИКИ ====================
// Отправка сообщения (AJAX)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax_send']) && isset($_SESSION['user_id'])) {
    header('Content-Type: application/json');
    $to_user_id = (int)$_POST['to_user_id'];
    $message = encrypt_text($_POST['message'], $encryption_key);
    $stmt = $pdo->prepare("INSERT INTO messages (from_user_id, to_user_id, message) VALUES (?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $to_user_id, $message]);
    echo json_encode(['status' => 'ok']);
    exit();
}

// Получение новых сообщений (AJAX)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['ajax_poll']) && isset($_SESSION['user_id'])) {
    header('Content-Type: application/json');
    $chat_user_id = (int)$_GET['user_id'];
    $last_id = isset($_GET['last_id']) ? (int)$_GET['last_id'] : 0;
    
    $stmt = $pdo->prepare("
        SELECT * FROM messages
        WHERE id > ? AND (
            (from_user_id = ? AND to_user_id = ?) OR
            (from_user_id = ? AND to_user_id = ?)
        )
        ORDER BY created_at ASC
    ");
    $stmt->execute([$last_id, $_SESSION['user_id'], $chat_user_id, $chat_user_id, $_SESSION['user_id']]);
    $messages = $stmt->fetchAll();
    
    $result = [];
    foreach ($messages as $msg) {
        $result[] = [
            'id' => $msg['id'],
            'from_user_id' => $msg['from_user_id'],
            'message' => htmlspecialchars(decrypt_text($msg['message'], $encryption_key)),
            'time' => date('H:i', strtotime($msg['created_at']))
        ];
    }
    echo json_encode($result);
    exit();
}

// ==================== ПОЛУЧЕНИЕ СПИСКА ПОЛЬЗОВАТЕЛЕЙ ====================
$users = $pdo->query("SELECT id, username FROM users ORDER BY username")->fetchAll();

// ==================== ВЫБОР СОБЕСЕДНИКА ====================
$chat_user_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;
$chat_user = null;
if ($chat_user_id && isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$chat_user_id]);
    $chat_user = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Мессенджер</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background: #0a0a0a;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 10px;
        }
        .app {
            max-width: 900px;
            width: 100%;
            height: 95vh;
            max-height: 800px;
            background: #111b21;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.8);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            position: relative;
        }
        .auth {
            background: #1e2a32;
            padding: 40px 30px;
            border-radius: 16px;
            max-width: 400px;
            margin: auto;
            width: 100%;
            color: #e9edef;
        }
        .auth h2 { font-weight: 400; font-size: 24px; margin-bottom: 20px; text-align: center; color: #fff; }
        .auth input {
            width: 100%;
            padding: 12px 16px;
            margin: 6px 0;
            border: none;
            border-radius: 10px;
            background: #2a3942;
            color: #e9edef;
            font-size: 15px;
            outline: none;
        }
        .auth input::placeholder { color: #8696a0; }
        .auth button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 10px;
            background: #00a884;
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 8px;
            transition: background 0.2s;
        }
        .auth button:hover { background: #008f72; }
        .auth .error { color: #ff6b6b; font-size: 14px; text-align: center; margin: 6px 0; }
        .auth hr { border: none; border-top: 1px solid #2a3942; margin: 20px 0; }
        .header {
            background: #1e2a32;
            padding: 12px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #2a3942;
            flex-shrink: 0;
        }
        .header .logo { color: #e9edef; font-size: 18px; font-weight: 600; display: flex; align-items: center; gap: 10px; }
        .header .logo span { background: #00a884; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 16px; color: #fff; }
        .header .user-info { color: #e9edef; display: flex; align-items: center; gap: 16px; }
        .header .user-info a { color: #8696a0; text-decoration: none; font-size: 14px; transition: color 0.2s; }
        .header .user-info a:hover { color: #e9edef; }
        .main { display: flex; flex: 1; overflow: hidden; background: #0b141a; }
        .sidebar {
            width: 260px;
            background: #1e2a32;
            border-right: 1px solid #2a3942;
            padding: 10px 0;
            overflow-y: auto;
            flex-shrink: 0;
        }
        .sidebar .section-title { color: #8696a0; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; padding: 10px 16px 6px; }
        .sidebar ul { list-style: none; padding: 0; margin: 0; }
        .sidebar ul li { padding: 8px 16px; display: flex; align-items: center; gap: 12px; cursor: pointer; transition: background 0.15s; }
        .sidebar ul li:hover { background: #2a3942; }
        .sidebar ul li a { text-decoration: none; color: #e9edef; display: flex; align-items: center; gap: 12px; width: 100%; font-size: 14px; }
        .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #00a884;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 14px;
            flex-shrink: 0;
        }
        .sidebar .empty { color: #8696a0; padding: 20px 16px; text-align: center; font-size: 14px; }
        .chat { flex: 1; display: flex; flex-direction: column; background: #0b141a; min-width: 0; }
        .chat-header {
            padding: 12px 20px;
            background: #1e2a32;
            border-bottom: 1px solid #2a3942;
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }
        .chat-header .avatar { width: 40px; height: 40px; font-size: 16px; }
        .chat-header .name { color: #e9edef; font-size: 16px; font-weight: 500; }
        .chat-header .status { color: #8696a0; font-size: 12px; }
        .chat-placeholder { color: #8696a0; text-align: center; padding: 40px 20px; font-size: 15px; flex: 1; display: flex; align-items: center; justify-content: center; }
        .messages {
            flex: 1;
            overflow-y: auto;
            padding: 16px 20px 10px;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .msg {
            max-width: 70%;
            padding: 10px 14px;
            border-radius: 12px;
            font-size: 14px;
            line-height: 1.4;
            word-wrap: break-word;
            animation: fadeIn 0.2s ease;
        }
        .msg.sent { background: #005c4b; color: #e9edef; align-self: flex-end; border-bottom-right-radius: 4px; }
        .msg.received { background: #1f2c33; color: #e9edef; align-self: flex-start; border-bottom-left-radius: 4px; }
        .msg .time { font-size: 10px; color: #8696a0; margin-top: 4px; display: block; text-align: right; }
        .msg.sent .time { color: #9bb8b0; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: translateY(0); } }
        .input-area {
            padding: 10px 16px;
            background: #1e2a32;
            border-top: 1px solid #2a3942;
            display: flex;
            gap: 10px;
            flex-shrink: 0;
        }
        .input-area input {
            flex: 1;
            padding: 10px 16px;
            border: none;
            border-radius: 20px;
            background: #2a3942;
            color: #e9edef;
            font-size: 15px;
            outline: none;
        }
        .input-area input::placeholder { color: #8696a0; }
        .input-area button {
            padding: 8px 20px;
            border: none;
            border-radius: 20px;
            background: #00a884;
            color: #fff;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            white-space: nowrap;
        }
        .input-area button:hover { background: #008f72; }
        @media (max-width: 700px) { .sidebar { width: 200px; } .msg { max-width: 85%; } }
        @media (max-width: 550px) {
            .app { height: 100vh; max-height: 100vh; border-radius: 0; }
            .sidebar { width: 140px; font-size: 12px; }
            .sidebar ul li { padding: 6px 10px; }
            .sidebar .avatar { width: 28px; height: 28px; font-size: 11px; }
            .msg { max-width: 90%; padding: 8px 12px; }
        }
    </style>
</head>
<body>

<div class="app">

<?php if (!isset($_SESSION['user_id'])): ?>
    <div class="auth">
        <h2>💬 Вход</h2>
        <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Логин" required>
            <input type="password" name="password" placeholder="Пароль" required>
            <button type="submit" name="login">Войти</button>
        </form>
        <hr>
        <form method="POST">
            <input type="text" name="username" placeholder="Новый логин" required>
            <input type="password" name="password" placeholder="Новый пароль" required>
            <button type="submit" name="register">Зарегистрироваться</button>
        </form>
    </div>
<?php else: ?>
    <div class="header">
        <div class="logo"><span>💬</span>Мессенджер</div>
        <div class="user-info">
            <span><?= htmlspecialchars($_SESSION['username']) ?></span>
            <a href="?logout">Выйти</a>
        </div>
    </div>

    <div class="main">
        <div class="sidebar">
            <div class="section-title">Контакты</div>
            <ul>
                <?php foreach ($users as $u): ?>
                    <?php if ($u['id'] == $_SESSION['user_id']) continue; ?>
                    <li>
                        <a href="?user_id=<?= $u['id'] ?>" data-user-id="<?= $u['id'] ?>">
                            <span class="avatar"><?= strtoupper(substr($u['username'], 0, 2)) ?></span>
                            <?= htmlspecialchars($u['username']) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
                <?php if (count($users) <= 1): ?>
                    <div class="empty">Нет других пользователей</div>
                <?php endif; ?>
            </ul>
        </div>

        <div class="chat" id="chat-container">
            <?php if ($chat_user): ?>
                <div class="chat-header">
                    <span class="avatar"><?= strtoupper(substr($chat_user['username'], 0, 2)) ?></span>
                    <div>
                        <div class="name"><?= htmlspecialchars($chat_user['username']) ?></div>
                        <div class="status">онлайн</div>
                    </div>
                </div>

                <div class="messages" id="message-box">
                    <!-- Сообщения загружаются через JavaScript -->
                    <div style="color:#8696a0; text-align:center; padding:20px;">Загрузка...</div>
                </div>

                <div class="input-area">
                    <input type="text" id="message-input" placeholder="Напишите сообщение..." autocomplete="off">
                    <button id="send-btn">➤</button>
                </div>

                <script>
                    const chatUserId = <?= $chat_user_id ?>;
                    const myUserId = <?= $_SESSION['user_id'] ?>;
                    let lastMessageId = 0;

                    function loadMessages() {
                        fetch(`?ajax_poll=1&user_id=${chatUserId}&last_id=${lastMessageId}`)
                            .then(r => r.json())
                            .then(data => {
                                if (data.length === 0) return;
                                const box = document.getElementById('message-box');
                                // Убираем заглушку, если она есть
                                if (box.querySelector('.empty-placeholder')) {
                                    box.innerHTML = '';
                                }
                                data.forEach(msg => {
                                    const div = document.createElement('div');
                                    div.className = `msg ${msg.from_user_id == myUserId ? 'sent' : 'received'}`;
                                    div.innerHTML = msg.message + `<span class="time">${msg.time}</span>`;
                                    box.appendChild(div);
                                    if (msg.id > lastMessageId) lastMessageId = msg.id;
                                });
                                box.scrollTop = box.scrollHeight;
                            });
                    }

                    function sendMessage() {
                        const input = document.getElementById('message-input');
                        const text = input.value.trim();
                        if (!text) return;
                        input.disabled = true;
                        fetch('', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                            body: `ajax_send=1&to_user_id=${chatUserId}&message=${encodeURIComponent(text)}`
                        })
                        .then(r => r.json())
                        .then(() => {
                            input.value = '';
                            input.disabled = false;
                            input.focus();
                            loadMessages();
                        });
                    }

                    document.getElementById('send-btn').addEventListener('click', sendMessage);
                    document.getElementById('message-input').addEventListener('keydown', e => {
                        if (e.key === 'Enter') sendMessage();
                    });

                    // Первая загрузка
                    setTimeout(() => {
                        // Убираем заглушку
                        const box = document.getElementById('message-box');
                        box.innerHTML = '<div class="empty-placeholder" style="color:#8696a0;text-align:center;padding:20px;">Загрузка...</div>';
                        // Загружаем историю с last_id = 0
                        fetch(`?ajax_poll=1&user_id=${chatUserId}&last_id=0`)
                            .then(r => r.json())
                            .then(data => {
                                box.innerHTML = '';
                                if (data.length === 0) {
                                    box.innerHTML = '<div style="color:#8696a0;text-align:center;padding:40px 0;">Нет сообщений</div>';
                                }
                                data.forEach(msg => {
                                    const div = document.createElement('div');
                                    div.className = `msg ${msg.from_user_id == myUserId ? 'sent' : 'received'}`;
                                    div.innerHTML = msg.message + `<span class="time">${msg.time}</span>`;
                                    box.appendChild(div);
                                    if (msg.id > lastMessageId) lastMessageId = msg.id;
                                });
                                box.scrollTop = box.scrollHeight;
                            });
                    }, 100);

                    // Периодический опрос (каждые 2 секунды)
                    setInterval(loadMessages, 2000);
                </script>
            <?php else: ?>
                <div class="chat-placeholder">
                    <div>
                        <div style="font-size:40px; margin-bottom:12px;">💬</div>
                        <div>Выберите чат слева</div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
</div>

</body>
</html>
