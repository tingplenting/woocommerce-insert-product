<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once '../wp-load.php';
include_once 'includes/functions.php';
include_once 'includes/attachments.php';

function insert_product ($product_data) 
{
	$new_post = array( // Set up the basic post data to insert for our product
		'post_author'  => 1,
		'post_content' => $product_data['description'],
		'post_excerpt' => $product_data['short_description'],
		'post_status'  => 'publish',
		'post_title'   => $product_data['name'],
		'post_parent'  => '',
		'post_type'    => 'product'
	);

	$post_id = wp_insert_post($new_post); // Insert the post returning the new post id

	if (!$post_id) // If there is no post id something has gone wrong so don't proceed
	{
		return false;
	}

	update_post_meta( $post_id, '_sku', $product_data['sku']); // Set its SKU
	update_post_meta( $post_id,'_visibility','visible'); // Set the product to visible, if not it won't show on the front end
	update_post_meta( $post_id, '_price', $product_data['price'] );
	update_post_meta( $post_id, '_regular_price', $product_data['price'] );
	update_post_meta( $post_id, '_stock_status', 'instock');
	update_post_meta( $post_id, 'total_sales', '0');
	update_post_meta( $post_id, '_downloadable', 'no'); // digital product
	update_post_meta( $post_id, '_virtual', 'no'); // digital product
	update_post_meta( $post_id, '_purchase_note', "" );
	update_post_meta( $post_id, '_featured', "no" );
	update_post_meta( $post_id, '_weight', 3 );
	update_post_meta( $post_id, '_length', 6 );
	update_post_meta( $post_id, '_width', 3 );
	update_post_meta( $post_id, '_height', 1 );
	update_post_meta( $post_id, '_sale_price_dates_from', "" );
	update_post_meta( $post_id, '_sale_price_dates_to', "" );
	update_post_meta( $post_id, '_sold_individually', "" );
	update_post_meta( $post_id, '_manage_stock', "no" );
	update_post_meta( $post_id, '_backorders', "no" );
	update_post_meta( $post_id, '_stock', 100 );

	wp_set_object_terms($post_id, $product_data['categories'], 'product_cat'); // Set up its categories

	$attachment_id = insert_product_attachment($product_data['attachment'], $post_id, $product_data['name']);

	add_post_meta($post_id, '_thumbnail_id', $attachment_id);
    
}

$product_data = array(
    "name" => "iphone xs",
    "sku" => "xs1",
    "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse ac erat maximus augue accumsan egestas. Quisque posuere augue quis libero molestie posuere.",
    "short_description" => "maximus augue accumsan egestas. Quisque posuere augue quis libero molestie posuere maximus augue accumsan egestas. Quisque posuere augue quis libero molestie posuere", 
    "categories" => array( 'apple' ),
    "price" => "17.99",
    "attachment" => 'tmp/iphone-xs.jpg'
);

insert_product($product_data);
echo "execute ok";
