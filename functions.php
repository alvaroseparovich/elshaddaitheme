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


