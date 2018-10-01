<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once '../wp-load.php';

// test buat woocommerce

$post_id = 590;
// $categories = array( 'my category' );
// wp_set_object_terms($post_id, $categories, 'product_cat');

function wpse_set_parent_terms($post_id, $post) {

    $post_type = 'product';      //set the post type you wish to operate on
    $taxonomy  = 'product_cat';  //set the taxonomy you wish to operate on

    if(get_post_type() !== $post_type) {
        return $post_id;
    }

    foreach(wp_get_post_terms($post_id, $taxonomy) as $term){

        while($term->parent !== 0 && !has_term($term->parent, $taxonomy, $post)) {

            wp_set_post_terms($post_id, array($term->parent), $taxonomy, true);

            $term = get_term($term->parent, $taxonomy);

        }

    }
}

wpse_set_parent_terms($post_id, null);
