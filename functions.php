<?php


add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    check_css_archive();
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri().'/style.' . wp_get_theme()->get('Version'). '.css' );
    wp_enqueue_script( 'custom-script', get_stylesheet_directory_uri() . '/js-el-shaddai.min.js' );
}
/* Se qualquer mudança for feita no Css, a versão do thema deve ser atualizada para que nenhum
 * erro de cache aconteça com os clientes!
 *  */

require get_stylesheet_directory() . '/inc/widgets.php';
require get_stylesheet_directory() . '/inc/functions-product-summary.php';

function check_css_archive(){
  if (!file_exists(get_stylesheet_directory().'/style.' . wp_get_theme()->get('Version'). '.css' )){
    $newfile = fopen(get_stylesheet_directory().'/style.' . wp_get_theme()->get('Version'). '.css' , "w") or die("Unable to open file!");
    $txt = fopen( get_stylesheet_directory().'/style.root.css' , "r") or die("Unable to open file!");
    fwrite($newfile, fread($txt, filesize(get_stylesheet_directory().'/style.root.css')));
    fclose($newfile);
  }
}


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
    add_image_size( 'elshaGrid1', 110, 120);

    // Cropping the images to different sizes to be used in the theme **************REMOVE*****************
  remove_image_size( 'estore-featured-image');
  remove_image_size( 'estore-product-grid');
  remove_image_size( 'estore-square');
  remove_image_size( 'estore-slider');
  }
endif; // estore_setup
add_action( 'after_setup_theme', 'estore_1setup', 11 );


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
    $fields['billing_address_2']['label_class'] = array('');    
    $fields['billing_neighborhood']['required'] = true;
    return $fields;}
add_filter( 'woocommerce_billing_fields', 'wc_elshaddai_bfield' );
function wc_elshaddai_sfield( $fields ) {
    $fields['shipping_number']['maxlength'] = 5;
    $fields['shipping_address_2']['maxlength'] = 30;
    $fields['shipping_address_2']['label_class'] = array('');  
    $fields['shipping_neighborhood']['required'] = true;
    return $fields;}
add_filter( 'woocommerce_shipping_fields', 'wc_elshaddai_sfield' );
function wc_elshaddai_ordernote( $fields ) {
     unset($fields['order']['order_comments']);
     return $fields;}
add_filter( 'woocommerce_checkout_fields' , 'wc_elshaddai_ordernote' );

function retrieve_var1_replacement( $especial_attribute=0, $all=0 ) {
  //only run on products
  if( !is_product() ){return;}
  if (is_object($all) or is_array($all)) {
    $all = 0;
  }

  //run this if $var1 recived a term
  if($especial_attribute && $especial_attribute != 'produtoSeo'){
    print_r($especial_attribute);
    $post_term = wp_get_post_terms(get_post()->ID , $especial_attribute);
    if( $post_term && is_array($post_term) ){
      if ($all) {
        return get_all_array_term($post_term);
      }else{
        return ' | '.$post_term[0]->name;
      }
    }
    print_r($post_term);
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


//Bling passa a atualizar o estoque, Gereciamento do Woocommerce é desativado
//Webhooks não podem ser agendadas Asyncronamente
add_filter("woocommerce_payment_complet_reduce_order_stock", false);
add_filter("woocommerce_payment_complete_reduce_order_stock",false);
add_filter("woocommerce_can_reduce_order_stock", false);
add_filter("woocommerce_webhook_deliver_async", false);

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