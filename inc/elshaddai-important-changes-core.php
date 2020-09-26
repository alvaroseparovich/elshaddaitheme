<?php
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

//------------------------------------------------
//-- checkout's checkbox to accept a posible calling after the payment.
$min_price_to_require_checkbox = 500;
function cw_custom_checkbox_fields( $checkout ) {
  global $min_price_to_require_checkbox;
  $the_order_total_price = WC()->cart->total;
  echo '<br><div class="cw_custom_class" style="padding:20px;"><h3>'.__('Confirmação das informações').'</h3>';
  echo '<p>Caso necessário poderemos entrar em contato para confirmar as informações e documentos informados neste formulário.</p>';
  if ($the_order_total_price >= $min_price_to_require_checkbox){
    woocommerce_form_field( 'custom_checkbox', array(
      'type'          => 'checkbox',
      'label'         => __('Estou ciente.'),
      'required'      => true,
      'id'            => 'colab_field',
    ), $checkout->get_value( 'custom_checkbox' ));
  }
  echo '</div>';
}
add_action('woocommerce_after_order_notes', 'cw_custom_checkbox_fields');

function cw_custom_process_checkbox() {
    global $min_price_to_require_checkbox;
    $the_order_total_price = WC()->cart->total;
    if( ($_POST['payment_method'] == 'pagarme-credit-card' ||
      $_POST['payment_method'] == 'woo-mercado-pago-custom'||
      $_POST['payment_method'] == 'bacs') && $the_order_total_price >= $min_price_to_require_checkbox ){
        if (!$_POST['custom_checkbox'])
          wc_add_notice( __( 'É necessário estar ciente da possivel confirmação de informações.' ), 'error' );
    }
    
}add_action('woocommerce_checkout_process', 'cw_custom_process_checkbox');

add_action('woocommerce_checkout_update_order_meta', 'cw_checkout_order_meta');
function cw_checkout_order_meta( $order_id ) {
    if ($_POST['custom_checkbox']) update_post_meta( $order_id, 'checkbox name', esc_attr($_POST['custom_checkbox']));
}


//Bling passa a atualizar o estoque, Gereciamento do Woocommerce é desativado
//Webhooks não podem ser agendadas Asyncronamente
add_filter("woocommerce_payment_complet_reduce_order_stock", false);
add_filter("woocommerce_payment_complete_reduce_order_stock",false);
add_filter("woocommerce_can_reduce_order_stock", false);
add_filter("woocommerce_webhook_deliver_async", false);


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


function shortcode_to_be_added( $arg ){
    echo do_shortcode( "[".$arg['shortcode']."]" ) ;
    return;
  
  }
  
function shortcode_to_add( $atts ) {
    add_action("especial_space_to_widgets", function() use ( $atts ) { shortcode_to_be_added( $atts ); });
  
    return ;
    
}
add_shortcode( 'before_loop', 'shortcode_to_add' );

//remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

// define the woocommerce_correios_shipping_args callback 
function filter_woocommerce_correios_shipping_args( $array, $this_id, $this_instance_id, $this_package ) { 
  //$array['nVlPeso'] = 1000;
  if($array['nVlPeso'] >= 30){
    return array('nCdServico' => null);
  }
  return $array; 
};
// add the filter 
add_filter( 'woocommerce_correios_shipping_args', 'filter_woocommerce_correios_shipping_args', 10, 4 );

// Some times some completed orders went back to processing, this function prevent this behavior.
add_filter( 'woocommerce_before_order_object_save', 'prevent_status_change_from_completed_to_processed', 1, 2 );
function prevent_status_change_from_completed_to_processed( $order, $data_store ) {
  $changes = $order->get_changes();
  # Only run if status Change
  if ( isset( $changes['status'] ) ) {
    $data = $order->get_data();
		$from_status = $data['status'];
    $to_status = $changes['status'];
    // if Status change from completed to processing, keep status completed
    if ($from_status == 'completed' && $to_status == 'processing'){
      $order->set_status('completed', 'Mudança de status Concluído para Processando Bloqueado | ');
    }
    // Se for pedido novo, do mercado pago com boleto, e status pending, muda o status para on-hold
	} elseif ($order->get_id() == 0 && $order->get_payment_method() === 'woo-mercado-pago-ticket' && $order->get_status() === 'pending') {
    $order->set_status('on-hold', 'Status de compra de boleto alterado de pending para on-hold | ');
  }
	return $order;
}