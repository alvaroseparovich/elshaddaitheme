<?php
/**
 * Single Product title
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/title.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @author     WooThemes
 * @package    WooCommerce/Templates
 * @version    1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

the_title( '<h1 class="product_title entry-title">', '' );

$post_id = get_post()->ID;
if(wp_get_post_terms( $post_id , 'pa_extencao')){
	echo '<i> | '.wp_get_post_terms( $post_id , 'pa_extencao')[0]->name . '</i>';
}elseif(wp_get_post_terms( $post_id , 'pa_autor')){
	echo '<i> | '.wp_get_post_terms( $post_id , 'pa_autor')[0]->name . '</i>';
}elseif(wp_get_post_terms( $post_id , 'pa_editora')){
	echo '<i> | '.wp_get_post_terms( $post_id , 'pa_editora')[0]->name . '</i>';
}
echo '</h1>';
