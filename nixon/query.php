<?php

require_once 'login.php';


try {
	$pdo = new PDO($attr, $user, $pass, $opts);
} catch (PDOException $e) {
	throw new PDOException($e->getMessage(), (int) $e->getCode());
}

$query = "SELECT * FROM classics";
$result = $pdo->query($query);

while ($row = $result->fetch(PDO::FETCH_BOTH)) {
	echo zagolovok(htmlspecialchars($row["title"])). $br;
	echo "Author: " . htmlspecialchars($row["author"]) . $br;
	echo "Category: " . htmlspecialchars($row["type"]) . $br;
	echo "Year: " . htmlspecialchars($row["year"]) . $br.$br;
}

if (isset($_POST['delete']) && isset($_POST['isbn'])) {
	$isbn = get_post($pdo, 'isbn');
	$query = "DELETE FROM classics WHERE isbn=$isbn";
	$result = $pdo->query($query);
}

if (isset($_POST['author']) && isset($_POST['title']) && isset($_POST['category']) && isset($_POST['year']) && isset($_POST['isbn'])) {
	$author = get_post($pdo, 'author');
	$title = get_post($pdo, 'title');
	$category = get_post($pdo, 'category');
	$year = get_post($pdo, 'year');
	$isbn = get_post($pdo, 'isbn');

	$query = "INSERT INTO classics VALUES".
	"($author, $title, $category, $year, $isbn)";
	$result = $pdo->query($query);
}

echo <<<_END
<form action="" method="POST"><pre>
Author <input type="text" name="author">
Title <input type="text" name="title">
Category <input type="text" name="category">
Year <input type="text" name="year">
ISBN <input type="text" name="isbn">
<input type="submit" value="ADD RECORD">
</pre></form>
_END;

$query = "SELECT * FROM classics";

echo "hjello";

$result = $pdo->query($query);

?>