<?php

include_once './login.php';

echo <<<_END
	<form method="POST">
		<input type="text" name="name" placeholder="name"><br>
		<input type="text" name="username" placeholder="username"><br>
		<input type="text" name="password" placeholder="password"><br>
		<input type="text" name="role" placeholder="role"><br>
		<button type="text" name="add_user">Enter</button>
	</form>
	_END;






