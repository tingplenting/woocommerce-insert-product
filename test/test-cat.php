<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once '../wp-load.php';

// https://stackoverflow.com/a/145348
function is_multi($a) {
	$rv = array_filter($a,'is_array');
	if(count($rv)>0) return true;
	return false;
}

function create_category($cat_name, $cat_parent = 0) {

	$my_cat = array(
			'cat_name' => $cat_name, 
			'category_nicename' => sanitize_title($cat_name), 
			'category_parent' => $cat_parent
		);

	$cat_ID =  get_cat_ID( $cat_name );

	if ($cat_ID == 0) {
		require_once (ABSPATH.'/wp-admin/includes/taxonomy.php');
		wp_insert_category($my_cat); // add new category
	}

	$new_cat_ID = get_cat_ID($cat_name);

	return $new_cat_ID;
}


$countries_list = array(
  'Europe' => array(
    'Austria', 'France', 'Italy', 'Germany', 'Spain', 'United Kingdom'
  )
);

// create_category("Greece", 61);

if (is_multi($countries_list)) {
	foreach ($countries_list as $continent => $countries) {
		$parent_cat_ID = create_category($continent);
		echo "$parent_cat_ID<br>";
		foreach ($countries as $country) {
			$child_cat_ID = create_category($country, $parent_cat_ID);
			echo "$child_cat_ID<br>";
		}
	}
}

?>