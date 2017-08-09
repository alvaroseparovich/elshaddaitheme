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
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post;

echo '<div class="woocommerce-product-details__short-description">';


echo '<div  class="short-detail">';

$post_id = get_post()->ID;
	echo '<div class="title line"> Nome: ';
	the_title( '<p><i>', '</i></p>' );
	echo '</div>';
	if(wp_get_post_terms( $post_id , 'pa_autor')){
		echo '<div class="autor line"> Autor: <h2><a href="'. esc_url( get_term_link( wp_get_post_terms( $post_id , 'pa_autor')[0]->term_id , 'pa_autor' ) ) . '">';  
		echo wp_get_post_terms( $post_id , 'pa_autor')[0]->name . '</a></h2></div>';

	}

	if(wp_get_post_terms( $post_id , 'pa_editora')){
		
		echo '<div class="editora line">Editora: <h2><a href="'. esc_url( get_term_link( wp_get_post_terms( $post_id , 'pa_editora')[0]->term_id , 'pa_editora' ) ) . '">';

		echo wp_get_post_terms( $post_id , 'pa_editora')[0]->name . '</a></h2></div>';}

echo '</div>';

if ( $post->post_excerpt ) {
     echo apply_filters( 'woocommerce_short_description', $post->post_excerpt ); 
}
?>
</div>
