<?php

$countries_list = array(
	'Europe' => array(
		'Austria', 'France', 'Italy', 'Germany', 'Spain', 'United Kingdom'
	)
);

$countries = array(
		'Austria', 'France', 'Italy', 'Germany', 'Spain', 'United Kingdom'
	);

function is_multi($a) {
	$rv = array_filter($a,'is_array');
	if(count($rv)>0) return true;
	return false;
}

function test_recursive ($clist) {
	foreach ($clist as $key => $value) {
		if (is_array($value)) {
			var_dump($key);
			test_recursive($value);
		} else {
			var_dump($value);
		}
	}
	// if (!is_multi($clist)) {
	// 	foreach ($clist as $key => $value) {
	// 		var_dump($value);
	// 	}
	// } else {
	// 	test_recursive($clist);
	// }
}

test_recursive($countries_list);
echo "<br>";
test_recursive($countries);

function test($a = 2) {
	return $a + 1;
}

echo test();
