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
global $post;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}$complement_name_product = retrieve_var1_replacement();
the_title( '<div class="title-entry-p"><h1 class="product_title entry-title"><span>', "</span><i>".retrieve_var1_replacement()."</i></h1>" );
if ( $post->post_excerpt ) {
	echo '<h2 class="subtitle"><i>';
	echo apply_filters( 'woocommerce_short_description', $post->post_excerpt );
	echo '</i></h2>';
}
echo "</div>";
