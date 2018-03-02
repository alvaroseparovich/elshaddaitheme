<?php
/**
 * Single product short description
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/short-description.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post;

echo '<div class="woocommerce-product-details__short-description">';


echo '<div  class="short-detail">';

$post_id = get_post()->ID;

echo '<div class="title line"> Nome: ';
the_title( '<h2><i>', retrieve_var1_replacement().'</i></h2>' );
echo '</div>';

$retrieve = wp_get_post_terms( $post_id , 'pa_autor');
if($retrieve){
	echo '<div class="autor line"> Autor:';
	foreach ($retrieve as $key => $value) {
		echo ' <buttom><h2><a href="'.get_term_link( $value->slug, 'pa_autor' ) . '">';
		echo $value->name . '</a></h2></buttom> ';
	}
	echo'</h2></div>';
}

$retrieve = wp_get_post_terms( $post_id , 'pa_editora');
if($retrieve){
	echo '<div class="editora line"> Editora:';
	foreach ($retrieve as $key => $value) {
		echo ' <buttom><h2><a href="'. get_term_link( $value->slug , 'pa_editora' ) . '">';
		echo $value->name . '</a></h2></buttom> ';
	}
	echo'</h2></div>';
}

echo '</div>';
	?>

</div>
