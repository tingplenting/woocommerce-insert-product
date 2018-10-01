<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once '../wp-load.php';


$categories = array(
		'DOTA 2 Heroes' => array(
				'Ember Spirit', 'Storm Spirit', 'Earth Spirit'
			)
	);

function wc_add_cat ($post_id, $cat_name, $taxonomy, $parent_id = 0) {
	$slug = sanitize_title($cat_name);
	$cek = term_exists( $cat_name, $taxonomy );

	if ( 0 !== $cek && null !== $cek ) {
		$term = get_term_by('slug', $slug, $taxonomy);
		$term_id = $term->term_id;
	} else {
		$set_term = wp_insert_term( $cat_name, $taxonomy, array( 'slug' => $slug, 'parent' => $parent_id ) );
		$term_id = isset( $set_term['term_id'] ) ? $set_term['term_id'] : 0;
	}

	$object_terms = array($term_id, $parent_id);
	wp_set_object_terms( $post_id, $object_terms, $taxonomy, true );

	return $term_id;
}

function new_wc_cat ($post_id, $categories, $taxonomy, $parent_id = 0) {

	foreach ($categories as $parent => $children) {

		$pid = wc_add_cat($post_id, $parent, $taxonomy);
		foreach ($children as $child) {
			$cid = wc_add_cat($post_id, $child, $taxonomy, $pid);
			var_dump($cid);
		}

	}

}

new_wc_cat(658, $categories, 'product_cat');
