<?php
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

}
require get_stylesheet_directory() . '/inc/widgets.php';


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
    return $fields;
}
add_filter( 'woocommerce_billing_fields', 'wc_elshaddai_bfield' );

function wc_elshaddai_sfield( $fields ) {
    $fields['shipping_number']['maxlength'] = 5;
    $fields['shipping_address_2']['maxlength'] = 30;
    $fields['shipping_neighborhood']['required'] = true;
    return $fields;
}
add_filter( 'woocommerce_shipping_fields', 'wc_elshaddai_sfield' );

//Adiciona %%produtoSeo%% no YOAST SEO quando adicionado esta tag, se possivel pega o autor, caso contrario editora.
function retrieve_var1_replacement( $var1 ) {
	if( is_product() ){
      if(wp_get_post_terms(get_post()->ID , 'pa_extencao')){
        $complement = wp_get_post_terms( get_post()->ID , 'pa_extencao')[0]->name;
      }elseif(wp_get_post_terms( get_post()->ID , 'pa_autor')){
    		$complement = wp_get_post_terms( get_post()->ID , 'pa_autor')[0]->name;
    	}elseif(wp_get_post_terms( get_post()->ID , 'pa_editora')){
    		$complement = wp_get_post_terms( get_post()->ID , 'pa_editora')[0]->name;
    	}else{
    		return ' ';
    	}
        $title_compl = ' | ' . $complement;
    }
	return $title_compl;}

function register_my_plugin_extra_replacements() {
	wpseo_register_var_replacement( '%%produtoSeo%%', 'retrieve_var1_replacement' );
}
add_action( 'wpseo_register_extra_replacements', 'register_my_plugin_extra_replacements' );
