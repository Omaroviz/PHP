<?php // user.php

$host = 'localhost';
$dbname = 'vkontakte';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",$username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch(PDOException $e) {
    die("Ошибка подключения: " . $e->getMessage());
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

class User {
	public $id, $username, $password, $name, $city, $about, $age;
	private $db;
	public function __construct($id, $pdo) {
		$this->db = $pdo;
		$stmt = $pdo->prepare("SELECT * FROM users LEFT JOIN users_info ON users.id = users_info.id WHERE users.id = :id");
		$this->id = $id;
		$stmt->execute([':id' => $id]);
		$users_info = $stmt->fetch();
		if ($users_info) {
		$this->name = $users_info['name'];
		$this->username = $users_info['username'];
		$this->password = $users_info['password'];
		$this->city = $users_info['city'] ?? "Не выбрано";
		$this->about = $users_info['about'] ?? "Не выбрано";
		$this->age = $users_info['age'] ?? "Не выбрано";
		}
	}
	
	public function edit($table, $column, $text, $pdo) {
		$stmt = $pdo->prepare("UPDATE $table SET $column = :text WHERE id = :id");
		$stmt->execute([
			':text' => $text,
			':id' => $this->id,
		]);

		//$user->edit("users_info", "age", 21, $pdo);	
	    if ($table === 'users' && $column === 'name') {
        $this->name = $text;
        $_SESSION['name'] = $text;
    } elseif ($table === 'users' && $column === 'username') {
        $this->username = $text;
        $_SESSION['username'] = $text;
    } elseif ($table === 'users_info' && $column === 'city') {
        $this->city = $text;
    } elseif ($table === 'users_info' && $column === 'age') {
        $this->age = $text;
    } elseif ($table === 'users_info' && $column === 'about') {
        $this->about = $text;
    }
	}

	public function logout() {
		$_SESSION['id'] = null;
		
		$_SESSION['username'] = null;
		$_SESSION['name'] = null;
	}

	public function login($username, $password) {
		$pdo = $this->db;
		$stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
		$stmt->execute([':username' => $username]);
		$hash_password = $stmt->fetch();
		if ($hash_password && password_verify($password, $hash_password['password'])) {
			$_SESSION['id'] = $hash_password['id'];
			$_SESSION['username'] = $hash_password['username'];
			$_SESSION['name'] = $hash_password['name'];
			return 1;
		} else {
			return 0;
		}
	}

}

class Post {

	public $id;
	public $title;
	public $text;
	public $author;
	public $date;
	public $author_id;
	public $post_from;
    	private $db;
	public function __construct($post) {
		$this->id = $post['id'];
		$this->title = $post['title'];
		$this->text = $post['text'];
		$this->author = $post['author'];
		$this->date = $post['date'];
		$this->author_id = $post['author_id'];
		$this->post_from = $post['post_from'];
	
	}

	public function delete($pdo) {
		$stmt = $pdo->prepare("DELETE FROM posts WHERE id = :id");
		$stmt->execute([':id' => $this->id]);
	}
}

// Вход: $user->login("Kolbasenko" ,"kolbasa"); 
/*
echo "Имя: ".htmlspecialchars($user->name)."<br>";
echo "Никнейм: ".htmlspecialchars($user->username)."<br>";
echo "Город: ".htmlspecialchars($user->city)."<br>";
echo "О себе: ".htmlspecialchars($user->about)."<br>";
echo "Возраст: ".htmlspecialchars($user->age)."<br>";
 */




