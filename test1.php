<?php

echo "Hello!<br>";

function binary_search($arr, $item) {
	$low = 0;
	$high = count($arr) - 1;
	while ($low <= $high) {
		$mid = intdiv($low + $high, 2);
		$guess = $arr[$mid];
		if ($guess == $item) {
			return $mid;
		} else if ($guess > $item) {
			$high = $mid - 1;
		} else {
			$low = $mid + 1;
		}
	}

	return null;
}

echo binary_search([1, 2, 3, 4, 5, 6, 7, 8, 9], 6);

?>
