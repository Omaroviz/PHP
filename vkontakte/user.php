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
		/*
		$low = 0;
		$high = count($arr) - 1;
		while ($low <= $high) {
			$mid = floor(($high - $low) / 2);
			$guess = $arr[$mid];
			if ($guess == $item) {
				return $mid;
			} else if ($guess > $item) {
				$high = $mid - 1;
			} else {
				$low = $mid + 1;
			}
		}

		 */
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
			$stmt = $pdo->prepare('SELECT * FROM token WHERE id = :id');
			$stmt->execute([':id' => $hash_password['id']]);
			$token = $stmt->fetch();
			if (!$token) {
				$cookie_token = substr(bin2hex(random_bytes(10)), 0, $length);
				$date = date('d/m/Y', strtotime('+12 month'));
				$stmt = $pdo->prepare('INSERT INTO token(id, cookie_token, date) VALUES(:id, :cookie_token, :date)');	
				$stmt->execute([
					':id' => $hash_password['id'],
					':cookie_token' => $cookie_token,
					':date' => $date
				]);
				setcookie('cookie_token', $cookie_token, [
					'expires'  => $date,
					'path'     => '/',          
					'domain'   => '',           
					'secure'   => false,        
					'httponly' => true,         
					'samesite' => 'Lax'           
				]);
			}
		
			return 1;
		} else {
			return 0;
		}
	}

}

class Post {

	public $id;
	public $post_from_username;
	public $title;
	public $text;
	public $error;
	public $author;
	public $date;
	public $author_id;
	public $post_from;
    	private $db;
    	public $comments;
public function __construct($data, $pdo = null) {
    if (is_array($data)) {
        // Если передан массив — берём данные из него
        $this->id = $data['id'];
        $this->title = $data['title'];
        $this->text = $data['text'];
        $this->author = $data['author'];
        $this->date = $data['date'];
        $this->author_id = $data['author_id'];
        $this->post_from = $data['post_from'];
    } else {
        // Если передан ID — загружаем из БД
        $this->db = $pdo;
	$stmt = $pdo->prepare("

SELECT 
    posts.*, 
    author.username AS author_username,
    wall.username AS wall_username
FROM posts
LEFT JOIN users AS author ON posts.author_id = author.id
LEFT JOIN users AS wall ON posts.post_from = wall.id
WHERE posts.id = :id");
        $stmt->execute([':id' => $data]);
        $post = $stmt->fetch();
        if ($post) {
            $this->id = $post['id'];
            $this->title = $post['title'];
            $this->text = $post['text'];
            $this->author = $post['author'];
            $this->date = $post['date'];
            $this->author_id = $post['author_id'];
            $this->post_from_username = $post['wall_username'];
            $this->post_from = $post['post_from'];
	} else {
		$this->error = 1;
	}
    }
}
	public function delete($pdo) {
		$this->deleteAllComments($this->id);
		$stmt = $pdo->prepare("DELETE FROM posts WHERE id = :id");
		$stmt->execute([':id' => $this->id]);
	}
	/*
	public function like() {
		$stmt = $pdo->prepare('SELECT like FROM posts WHERE id = :id');
		$stmt = $stmt->execute([':id' => $this->id]);
		if ($stmt->fect) {
			$
		}
	 */
	public function addComment($text, $pdo) {
		$stmt = $pdo->prepare('INSERT INTO comments(text, author_id, post_id) VALUES(:text, :author_id, :post_id)');
		$stmt->execute([
			':text' => $text,
			':author_id' => $_SESSION['id'],
			':post_id' => $this->id,
		]);
	}

	public function showComment($pdo) {
		$stmt = $pdo->prepare('SELECT comments.*, users.username FROM comments LEFT JOIN users ON comments.author_id = users.id WHERE comments.post_id = :id ORDER BY comments.id DESC');
		$stmt->execute([':id' => $this->id]);
		$this->comments = $stmt->fetchAll();
	}

	public function deleteAllComments($id) {
		$pdo = $this->db;
		$stmt = $pdo->prepare('DELETE FROM comments WHERE post_id = :post_id');
		$stmt->execute([
			':post_id' => $id
		]);
	}

	public function deleteComment($id) {
		$pdo = $this->db;
		$stmt = $pdo->prepare('SELECT author_id FROM comments WHERE id = :id');
		$stmt->execute([':id' => $id]);
		if ($stmt->fetchColumn()) {
		$stmt = $pdo->prepare('DELETE FROM comments WHERE id = :id');
		$stmt->execute([':id' => $id]);
		} else {
			echo "Вы не можете удалить комментарий";
		}
	}
}

class Search {
	public $text, $posts, $users;

	public function __construct($text, $pdo) {
		$text = "%".$text."%";
		$stmt = $pdo->prepare("
SELECT id, username, name
FROM users
WHERE username LIKE :text
OR name LIKE :text");
		$stmt->execute([':text' => $text]);
		$this->users = $stmt->fetchAll();
		$stmt = $pdo->prepare("SELECT * FROM posts WHERE title LIKE :text OR text LIKE :text");
		$stmt->execute([':text' => $text]);
		$this->posts = $stmt->fetchAll();
	}
}

class CSRF {
	public function newToken() {
		if (empty($_SESSION['csrf_token'])) {
			$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
		}
		return $_SESSION['csrf_token'];
	}
	public function validateToken($post) {
		if (!isset($_SESSION['csrf_token']) || !isset($post)) {
			return false;
		}
		return hash_equals($_SESSION['csrf_token'], $post);
	}

}

/*
echo "Имя: ".htmlspecialchars($user->name)."<br>";
echo "Никнейм: ".htmlspecialchars($user->username)."<br>";
echo "Город: ".htmlspecialchars($user->city)."<br>";
echo "О себе: ".htmlspecialchars($user->about)."<br>";
echo "Возраст: ".htmlspecialchars($user->age)."<br>";
 */




