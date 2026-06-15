<?php

function zagolovok($word)
{
    while (strlen($word) < 40) {
        $word = "-" . $word . "-";
    }
    return $word;
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
echo "<h2>Привет из Vim!</h2><br>";

$br = "<br>";

class User
{
	public $name;
}

$userDavud = new User;

$userDavud->name = "Davud";

echo $userDavud->name . "<br>";

$userBavud = new User;

$userBavud->name = "Bavud";

echo $userBavud->name . "<br>";


class Cat
{
	public $name;
	public $age;
	public $isHappy;

	function __construct($name, $age, $isHappy)
	{
		$this->name = $name;
		$this->age = $age;
		$this->isHappy = $isHappy;
	}
	function sayHi()
	{
		$status = $this->isHappy ? "счастливый" : "грустный";
		echo "Привет, {$status} кот {$this->name}";
	}
}

$barsik = new Cat("Барсик", 1.5, TRUE);
$barsik->sayHi();

class Calculator
{
	public $num1;
	public $num2;
	public function __construct($num1, $num2)
	{
		$this->num1 = $num1;
		$this->num2 = $num2;
	}
	function Mathem()
	{
		return $this->num1 + $this->num2;
	}
}

$test = new Calculator(1, 2);
echo "<br>" . $test->Mathem();


class Car
{
	public $brand, $model, $speed = 0, $engineOn = false;

	public function __construct($brand, $model)
	{
		$this->brand = $brand;
		$this->model = $model;
	}

	public function startEngine()
	{
		$this->engineOn = true;
	}
	public function stopEngine()
	{
		$this->engineOn = false;
	}
	public function accelerate($amount)
	{
		$amount && $amount > $this->speed ? $this->speed = $amount : print ("Скорость ниже 0 или ниже исходной");
	}
	public function brake($amount)
	{
		$amount && $amount >= 0 && $amount > $this->speed ? $this->speed = $amount : print ("Скорость ниже 0 или выше исходной");
	}
	public function getInfo()
	{
		print ("<br>Бренд: " . $this->brand . "<br>Модель:" . $this->model . "<br>Скорость:" . $this->speed . "<br>Двигатель включен?" . $this->engineOn . "<br>");
	}
}

$lada = new Car("АвтоВАЗ", "Жигули");

$lada->getInfo();

$lada->startEngine();


class Human
{
	public $name, $age;

	public function __construct($name, $age)
	{
		$this->name = $name;
		$this->age = $age;
	}

	public function eat($food)
	{
		echo $this->name . " ест " . $food;
	}

}

class Patimat extends Human
{
	public function __construct($name, $age)
	{
		parent::__construct($name, $age);
	}
}

$userPatimat = new Patimat("Патимат", "40");

$userPatimat->eat("конфеты.");

$userAndrey = new Human("Андрей", 13);
$userAndrey->eat("яблоко.");
echo "<br>";

class Programmist extends Human
{
	public $prog_lang;
	public function __construct($name, $age, $prog_lang)
	{
		// Вызываем конструктор родителя (Human)
		parent::__construct($name, $age);

		$this->prog_lang = $prog_lang;
	}
	public function Programming()
	{
		echo $this->name . " программирует на " . $this->prog_lang;
	}
}

$userStepan = new Programmist("Степан", 25, "php");
$userStepan->Programming();
echo "<br>";


class Animal
{
	protected $name;
	protected $legs;

	public function __construct($name, $legs)
	{
		$this->name = $name;
		$this->legs = $legs;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getLegs()
	{
		return $this->legs;
	}

	public function makeSound()
	{
		return "Издает звук";
	}
}

class Dog extends Animal
{
	public function __construct($name)
	{
		parent::__construct($name, 4);
	}

	public function makeSound()
	{
		return "{$this->name} гавкает: Гав-гав!";
	}
}

class CatAnimals extends Animal
{
	public function __construct($name)
	{
		parent::__construct($name, 4);
	}

	public function makeSound()
	{
		return "{$this->name} мяукает: Мяу-мяу!";
	}

	public function climb()
	{
		return "{$this->name} залез на дерево";
	}
}

$dog = new Dog("Шарик");
$cat = new CatAnimals("Мурзик");

echo $dog->makeSound() . "<br>";
echo $cat->makeSound() . "<br>";
echo $cat->climb();

echo "<br>";

abstract class Notification
{
	public $recipient, $message;

	public function __construct($recipient, $message)
	{
		$this->recipient = $recipient;
		$this->message = $message;
	}

	abstract function send();

	public function getInfo($recipient, $message)
	{
		return "Уведомление для $recipient: $message";
	}

}

class EmailNotification extends Notification
{

	public function send()
	{
		echo "Email отправлен на " . $this->recipient . ": " . $this->message;
	}
}

class SMSNotification extends Notification
{

	public function send()
	{
		echo "SMS отправлен на " . $this->recipient . ": " . $this->message;
	}
}

class TelegramNotification extends Notification
{

	public function send()
	{
		echo "Telegram-код отправлен на " . $this->recipient . ": " . $this->message;
	}
}
echo "<br>";

$email = new EmailNotification("omaroviz1990@gmail.com", "Код подтверждения Telegram: 457282. Не делитесь с кодом.");
$email->send();

echo "<br>";

$sms = new SMSNotification("8-800-2000-122", "Код подтверждения Telegram: 457282. Не делитесь с кодом.");
$sms->send();

echo "<br>";

$tg = new TelegramNotification("Telegram", "Код подтверждения Telegram: 457282. Не делитесь с кодом.");
$tg->send();

echo "<br>";

// abstract class

echo "<br>";

abstract class Worker
{
	public $name, $age;
	protected $classwork;

	public function __construct($name, $age)
	{
		$this->name = $name;
		$this->age = $age;
	}

	public function sayHi()
	{
		echo "Привет! Меня зовут " . $this->name . ", я из класса \"Worker\". Моя профессия: " . $this->classwork . ", и вот мой ID: ";
	}

	abstract function doWork();
}


class Medic extends Worker
{
	public $id, $classwork;
	public function __construct($name, $age, $id)
	{
		parent::__construct($name, $age);
		$this->id = $id;
		$this->classwork = "медик";
	}


	public function doWork()
	{
		echo $this->name . " идет в операционную";
	}
}

class Cassir extends Worker
{
	public $id;

	public function __construct($name, $age, $id)
	{
		parent::__construct($name, $age);
		$this->id = $id;
		$this->classwork = "кассир";
	}


	public function doWork()
	{
		echo $this->name . " идет на кассу";
	}
}

$Gosha = new Medic("Гоша", 30, 1234);

$Gosha->sayHi();
echo $br;

$Gosha->doWork();

$Alice = new Cassir("Алиса", 24, 1121);
echo $br;

$Alice->sayHi();
echo $br;

$Alice->doWork();
echo $br;
echo $br;

class sayWord
{
	public static function sayTime()
	{
		echo date("H:i:s");
	}

	public static function sayText()
	{
		$hour = (int) date("G");

		if ($hour >= 6 && $hour < 12) {
			echo "Доброе утро!";
		} else if ($hour >= 12 && $hour < 18) {
			echo "Добрый день.";
		} else if ($hour >= 18 && $hour <= 21) {
			echo "Добрый вечер.";
		} else {
			echo "Спокойной ночи!";
		}
	}
}
sayWord::sayTime();
echo $br;
sayWord::sayText();

echo $br, $br;


class Bank
{
	public static $wallet = 0;
	public static $users = [];

	public static function addMoney($user, $money)
	{
		self::$users[] = $user;
		self::$wallet += $money;
	}

	public static function seeWallet()
	{
		echo "Баланс: " . self::$wallet . "р.<br>";
		echo "Отправители: ";
		for ($i = 0; $i < count(self::$users); $i++) {
			echo self::$users[$i] . ", ";
		}
	}
}

Bank::addMoney("Гоша", 123);
Bank::addMoney("Андрей", 7);
Bank::addMoney("Алиса", 67);
Bank::seeWallet();

echo $br;

// class Game {
// 	protected static $hp = 100, $attack_power = 10;
// 	public static function Attack() {
// 		self::$hp -= self::$attack_power;
// 	} public static function HP() {
// 		echo "HP: ".self::$hp.".<br>Сила аттаки: ".self::$attack_power;
// 	}
// }

// Game::Attack();
// Game::HP();

class Game
{
	public static $hp1 = 100, $hp2 = 100;
}

class Gamer1 extends Game
{
	public static function Attack($attack_powered)
	{
		if ($attack_powered <= 20) {
			Game::$hp2 -= $attack_powered;
			echo "Вы нанесли врагу $attack_powered урона. HP Игрока 2: " . Game::$hp2;
		} else {
			echo "Сила аттаки должна быть ДО 20hp!";
		}
	}
}

class Gamer2 extends Game
{
	public static function Attack($attack_powered)
	{
		if ($attack_powered <= 20) {
			Game::$hp1 -= $attack_powered;
			echo "Вы нанесли врагу $attack_powered урона. HP Игрока 1 " . Game::$hp1;
		} else {
			echo "Сила аттаки должна быть ДО 20hp!";
		}
	}
}

Gamer1::Attack(12);
echo "<br>";
Gamer2::Attack(20);


abstract class UserSite
{
	public $name, $password, $userName, $group, $email;
	public function __construct($name, $password, $userName, $group, $email)
	{
		$this->name = $name;
		$this->password = $password;
		$this->userName = $userName;
		$this->group = $group;
		$this->email = $email;
	}

	public function sendComment($text)
	{
		echo "Комментраий \"$text\" отправлен!";
	}
}
class UserModerator extends UserSite
{
	public function __construct($name, $password, $userName, $group, $email)
	{
		parent::__construct($name, $password, $userName, $group, $email);
	}

	public function deleteComment($idComment)
	{
		echo "Комментраий удален!";
	}
}


echo "";




abstract class ShopWorker
{
	public $name, $age, $profession;
	public function __construct($name, $age, $profession)
	{
		$this->name = $name;
		$this->age = $age;
		$this->profession = $profession;
	}
	abstract function doShopWork();
}

class ShopCassir extends ShopWorker
{
	public function __construct($name, $age, $profession)
	{
		parent::__construct($name, $age, $profession);
	}

	public function doShopWork()
	{
	}
}

echo $br;

$food['cnd'] = "Candy";
$food['chs'] = "Cheese";
$food['sda'] = "Soda";

// for ($i = 0; $i < count($food); $i++) {
// 	echo $i+1;
// 	echo ". - ". $food[$i].$br;
// }

echo $food['cnd'];

$barsik1 = new Cat("Барсик", 3, TRUE);

echo $br;

echo "<h3 style=\"margin-bottom: 1px;\">🖳Database</h3>";

$host = "localhost";
$data = "publications";
$user = "root";
$pass = "";
$chrs = "utf8mb4";
$attr = "mysql:host=$host;dbname=$data;charset=$chrs";
$opts = [
	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	PDO::ATTR_EMULATE_PREPARES => false,
];


try {
	$pdo = new PDO($attr, $user, $pass, $opts);
} catch (PDOException $e) {
	throw new PDOException($e->getMessage(), (int) $e->getCode());
}

function get_post($pdo, $var) {
	return $pdo->quote($_POST[$var]);
}

$query = "SELECT * FROM classics";
$result = $pdo->query($query);

while ($row = $result->fetch(PDO::FETCH_BOTH)) {
	echo zagolovok(htmlspecialchars($row["title"])). $br;
	echo "Author: " . htmlspecialchars($row["author"]) . $br;
	echo "Category: " . htmlspecialchars($row["category"]) . $br;
	echo "Year: " . htmlspecialchars($row["year"]) . $br.$br;
}

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
// 	$username = $_POST['text'];
// 	echo "$username";
// } 

if (isset($_POST['delete']) && isset($_POST['isbn'])) {
    $isbn = get_post($pdo, 'isbn');
    $query = "DELETE FROM classics WHERE isbn=$isbn"; // get_post уже добавляет кавычки
    $result = $pdo->query($query);
}

if (isset($_POST['author']) && isset($_POST['title']) && isset($_POST['category']) && isset($_POST['year']) && isset($_POST['isbn'])) {
    
    // Проверка, что год - это число
    if (!is_numeric($_POST['year'])) {
        echo "<span style='color: red;'>❌ Ошибка: Год должен быть числом! Вы ввели: " . htmlspecialchars($_POST['year']) . "</span><br>";
    } else {
        $author = get_post($pdo, 'author');
        $title = get_post($pdo, 'title');
        $category = get_post($pdo, 'category');
        $year = (int)$_POST['year'];
        $isbn = get_post($pdo, 'isbn');
        
        $query = "INSERT INTO classics (author, title, category, year, isbn) 
                  VALUES ($author, $title, $category, $year, $isbn)";
        $result = $pdo->query($query);
        
        if ($result) {
            echo "<span style='color: green;'>Книга добавлена!</span><br>";
        }
    }
}
echo <<<_END
<form action="" method="POST">
		<h3 style="margin: 10px 0;">Новая запись</h3>
        <div class="flex-right">
            <input type="text" name="author" placeholder="Author"><br>
            <input type="text" name="title" placeholder="Title"><br>
            <input type="text" name="category" placeholder="Category"><br>
            <input type="text" name="year" placeholder="Year"><br>
            <input type="text" name="isbn" placeholder="ISBN"><br>
            <input type="submit" value="ADD RECORD">
        </div>
</form>
_END;

$query = "SELECT * FROM classics";
$result = $pdo->query($query);



while ($row = $result->fetch()) {
	$r0 = htmlspecialchars($row['author']);
	$r1 = htmlspecialchars($row['title']);
	$r2 = htmlspecialchars($row['category']);
	$r3 = htmlspecialchars($row['year']);
	$r4 = htmlspecialchars($row['isbn']);

	echo <<<_END
	<pre>
	Author: $r0
	Title: $r1
	Category: $r2
	Year: $r3
	ISBN: $r4
	</pre>
	<form method="post">
	<input type="hidden" name="delete" value="yes"> 
	<input type="hidden" name="isbn" value="$r4">
	<input type="submit" value="DELETE RECORD"></form>
	_END;

}










?>

<!DOCTYPE html>
	<html>

	<head>
		<title>Document</title>
		<style>
			body {
				background-color: black;
				color: green;
			}

			input,
			button,
			textarea {
				background-color: black;
				border: 1px solid green;
				text-decoration: none;
				color: green;
				padding: 1px 5px;
			}

			button:hover {
				border: 2px solid green;
				padding: 0 4px;
			}

			.flex-main {
    display: flex;
    gap: 20px;  /* Отступ между левой и правой частью */
}
.flex-left, .flex-right {
    display: flex;
    flex-direction: column;
	
}
input {
	max-width: 200px;
}

.stylel {
	text-decoration: none;
	color: green;
}
		</style>

	</head>

	<body>

		<!-- <img src="../Media/Ubuntu.png" alt=""> -->

		<h1>TEXT</h1>
		<form action="" method="POST">
			<input type="text" name="text" placeholder="Введите текст">
			<button type="submit" style="cursor: pointer;">Отправить</button>
		</form>
		<a href="search.php" class="stylel">search.php</a>

		<h3 style="margin-bottom: 1px;">Terminal</h3>
		<textarea name="" id="" placeholder="Enter command"></textarea><br>
		Далеко-далеко за словесными горами в стране гласных и согласных живут рыбные тексты. Имеет использовало
		последний прямо заголовок маленькая безорфографичный деревни решила за, запятой предупредила залетают на берегу.
		Речью всемогущая страна однажды рыбными великий приставка вдали, рекламных злых безорфографичный раз
		послушавшись обеспечивает пунктуация которой, толку диких свой коварный, буквоград гор за собрал? Что это
		продолжил дал ее не. Ее дорогу они власти до, выйти раз снова своего свой буквоград щеке океана коварных бросил
		мир рукописи. Парадигматическая мир, ручеек пор подзаголовок единственное от всех вскоре ты жизни переписали
		путь речью необходимыми запятой пояс большого щеке лучше грустный залетают назад продолжил домах вершину даже
		буквоград текст злых.
	</body>

	</html>
