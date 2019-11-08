<?php

//All statics files need to be loaded here
require get_stylesheet_directory() . '/static/index.php';

//All files related with widgets and sidebar
require get_stylesheet_directory() . '/inc/widgets.php';

//some changes in product page
require get_stylesheet_directory() . '/inc/functions-product-summary.php';

//Changes very specific to that store
require get_stylesheet_directory() . '/inc/elshaddai-important-changes-core.php';

//Theme Functions
require get_stylesheet_directory() . '/inc/front-end-functions.php';

//All functions related to imgs
require get_stylesheet_directory() . '/inc/img-functions.php';

//functions related to YoastSEO
require get_stylesheet_directory() . '/inc/yoast-seo-functions.php';

//Fuctions substituted from main parent theme or added
require get_stylesheet_directory() . '/woocommerce/archives-elshaddai/index.php';

//----------------------Thank You Page-----------
/*function correct_thank_you_page($text)
{ global $post;
  return ".Seu pedido foi recebido! 
  para verificar o stauts de seu pedido clique no botão abaixo!  
  <form action='http://google.com'>
      <button> Pedido </button>
  </form>". print_r($post)  ;
}
add_filter('woocommerce_thankyou_order_received_text', 'correct_thank_you_page');*/
/*
function sv_change_product_html( $price_html, $product ) {
	$unit_price = get_post_meta( $product->id, 'unit_price', true );
	$price_html = '<span class="amount">' .$product->get_regular_price() . ' per kg</span>';	
	
	return $price_html;
}
add_filter( 'woocommerce_get_price_html', 'sv_change_product_html', 10, 2 );*/