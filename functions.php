<?php
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_script( 'custom-script', get_stylesheet_directory_uri() . '/js-el-shaddai.min.js' );
}

require get_stylesheet_directory() . '/inc/widgets.php';

//Helper na dash board com  os autores
add_action('wp_dashboard_setup', 'attributes_on_dashboard_widgets');
function attributes_on_dashboard_widgets() {
  global $wp_meta_boxes;
  wp_add_dashboard_widget('custom_help_widget', 'Atributos dos Livros', 'custom_dashboard_help');
}
function custom_dashboard_help() {
  echo '<p>Abrir atributos</p>';
  echo('<a href="'. get_site_url() . '/wp-admin/edit-tags.php?taxonomy=pa_autor&post_type=product" class="button button-primary">Autores</a>');
  echo('<a href="'. get_site_url() . '/wp-admin/edit-tags.php?taxonomy=pa_editora&post_type=product" class="button button-primary">Editoras</a>');
  //print_r(get_terms('pa_autor'));
}

if ( ! function_exists( 'estore_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function estore_1setup() {
   // Cropping the images to different sizes to be used in the theme
	add_image_size( 'estore-medium-image111', 240, 240);
	add_image_size( 'elshaGrid1', 90, 90);
}
endif; // estore_setup
add_action( 'after_setup_theme', 'estore_1setup' );


//reduz estoque no boleto pagarme
function compra_com_boleto_reserva_estoque( $order_id ) {

	$order = new WC_Order( $order_id );

	if( get_post_meta( $order->id, '_payment_method', true ) == 'pagarme-banking-ticket'){

		$order->reduce_order_stock(); // reduz o estoque
		$order->add_order_note( "Livros reservados por comprar com o methodo: pagarme-Boleto"  );
	}
}
add_action( 'woocommerce_checkout_order_processed', 'compra_com_boleto_reserva_estoque' );

//checkout com os campos bairro obrigatorio, 5 numeros no numero, e 30 no complemento
function wc_elshaddai_bfield( $fields ) {
    $fields['billing_number']['maxlength'] = 5;
    $fields['billing_address_2']['maxlength'] = 30;
    $fields['billing_neighborhood']['required'] = true;
    return $fields;}
add_filter( 'woocommerce_billing_fields', 'wc_elshaddai_bfield' );
function wc_elshaddai_sfield( $fields ) {
    $fields['shipping_number']['maxlength'] = 5;
    $fields['shipping_address_2']['maxlength'] = 30;
    $fields['shipping_neighborhood']['required'] = true;
    return $fields;}
add_filter( 'woocommerce_shipping_fields', 'wc_elshaddai_sfield' );

function retrieve_var1_replacement( $especial_attribute=0, $all=0 ) {
  //only run on products
  if( !is_product() ){return;}

  //run this if $var1 recived a term
  if($especial_attribute){
    $post_term = wp_get_post_terms(get_post()->ID , $especial_attribute);
    if( $post_term && is_array($post_term) ){
      if ($all) {
        return get_all_array_term($post_term);
      }
      return ' | '.$post_term[0]->name;
    }
  return;
  }

  //run this if $var1 is left empty
  $terms = array( 'pa_extencao','pa_autor','pa_editora' );
  $pr_id = get_post()->ID;
  foreach ($terms as $key => $value) {
    $post_term = wp_get_post_terms($pr_id , $value);

    if(is_array($post_term) && $post_term != array() ){
      if ($all) {
        return get_all_array_term($post_term);
      }
      return ' | '.$post_term[0]->name;
    }
  }
}
function get_all_array_term($post_term){
  $array = array();
  foreach ($post_term as $key => $value) {
    array_push($array,$value->name);
  }
  return $array;
}

function register_my_plugin_extra_replacements() {
	wpseo_register_var_replacement( '%%produtoSeo%%', 'retrieve_var1_replacement' );
}
add_action( 'wpseo_register_extra_replacements', 'register_my_plugin_extra_replacements' );

/*product page*/
/*
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );*/

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 15 );
add_action( 'woocommerce_single_product_summary', 'intro_block_summary', 12 );
add_action( 'woocommerce_single_product_summary', 'finish_block_summary', 39 );

function intro_block_summary(){
  echo'<div class="bl-summary">';
}
function finish_block_summary(){
  echo'</div>';
}
