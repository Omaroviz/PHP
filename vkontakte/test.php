<?php

echo substr(bin2hex(random_bytes(10)), 0, $length);

echo "<br>";

// Выведет дату ровно через 1 месяц от текущего дня
echo date('d/m/Y', strtotime('+12 month'));

