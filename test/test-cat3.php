<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once '../wp-load.php';


$post_id = 668;
$name = 'flux pavilion';
$slug = str_replace(' ', '', $name) . "slug";
$parent = 76;
$taxonomy = 'product_cat';

$term = term_exists( $name, $taxonomy );
if ( 0 !== $term && null !== $term ) {
	$get_term = get_term_by('slug', $slug, $taxonomy);
	$get_term_id = $get_term->term_id;
	$object_terms = array($get_term_id, $parent);
	wp_set_object_terms( $post_id, $object_terms, $taxonomy, true );
} else {
	$cid = wp_insert_term( $name, $taxonomy, array( 'slug' => $slug, 'parent' => $parent ) );

	if ( ! is_wp_error( $cid ) ) {
		// Get term_id, set default as 0 if not set
		$cat_id = isset( $cid['term_id'] ) ? $cid['term_id'] : 0;
		$object_terms = array($cat_id, $parent);
		wp_set_object_terms( $post_id, $object_terms, $taxonomy, true );
		var_dump($cat_id);
	} else {
		 // Trouble in Paradise:
		 var_dump($cid->get_error_message());
	}
}


