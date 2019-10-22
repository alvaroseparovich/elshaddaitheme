<?php


//Adicionar bottões para almentar unidades e diminuir, na página de Produtos.
function add_cart_button_less(){ 
    global $product;
    if(number_format( $product->stock,0,'','' ) > 1 or $product->manage_stock=="no" or $product->is_on_backorder( 1 )) {
        echo'<button class="btElLess" type="button" onclick="removeItem(); return false;">-</button></div>';
        }
      }
function add_cart_button_plus(){ 
    global $product;
    if(number_format( $product->stock,0,'','' ) > 1 or $product->manage_stock=="no" or $product->is_on_backorder( 1 )) {
        echo'<div class="counter"><button class="btElPlus" type="button" onclick="addItem(); return false;">+</button>';
        }
      }

function add_buttons_js_snippet(){echo'<script>
    function removeItem(){	e = document.querySelector("form.cart .quantity > input.input-text");	n = e.value;newN = parseInt(n)-1;  if (!(newN < e.min)){ e.value = newN; }}
    function addItem(){	e = document.querySelector("form.cart .quantity > input.input-text");	n = e.value;newN = parseInt(n)+1;  if (e.max==""){e.value = newN;}    if (!(newN > e.max)){ e.value = newN; }} 
  </script>';}
  add_filter('woocommerce_after_add_to_cart_quantity','add_cart_button_less', 0);
  add_filter('woocommerce_before_add_to_cart_quantity','add_cart_button_plus', 0);
  add_action('wp_head', 'add_buttons_js_snippet');


  /*product page*/
/*
  add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
  add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
  add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
  add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
  add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
  add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );*/

  //remove_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
add_action( 'woocommerce_single_product_summary', 'intro_block_summary', 12 );

add_action( 'woocommerce_single_product_summary', 'intro_block_p1', 12 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 12 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 13 );
add_action( 'woocommerce_single_product_summary', 'finish_block_div', 14 );
add_action( 'woocommerce_single_product_summary', 'finish_block_div', 14 );
add_action( 'woocommerce_single_product_summary', 'intro_block_p2', 16 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 20 );
add_action( 'woocommerce_single_product_summary', 'finish_block_div', 38 );
add_action( 'woocommerce_single_product_summary', 'finish_block_summary', 39 );

function intro_block_summary(){
  echo'<div class="bl-summary">';}
function finish_block_summary(){
  echo'</div>';}

  function intro_block_p1(){
    echo'<div class="bl-p1">';}
function intro_block_p2(){
  echo'<div class="bl-p2">';}
function finish_block_div(){
  echo'</div>';}


add_action('author_list','function_author_list');
add_action('editora_list','function_editora_list');

function function_author_list($arr){
  $author = $arr[0];
  $product = $arr[1];
  $aut_tax = $author->get_taxonomy_object();
  $aut_values = wc_get_product_terms( $product->get_id(), $author->get_name(), array( 'fields' => 'all' ) );
  $url = esc_url( get_term_link( $aut_values[0]->term_id, 'pa_autor' ) );
  if ($aut_values[0]->count > 1){
    echo "<h2 class='widget-title'><span>Outros produtos de {$aut_values[0]->name}</span></h2>";
    echo do_shortcode("[products attribute='autor' terms='{$aut_values[0]->name}' orderby='rand' limit='4' columns='4']");
    if( $aut_values[0]->count > 4 )
    { 
      echo "<a href='{$url}' style='margin-bottom:10px;'><button> Outros livros de {$aut_values[0]->name}</button></a>";
    }else{ echo "Todos os livros de {$aut_values[0]->name}"; }
  }
}
function function_editora_list($arr){
  $editora = $arr[0];
  $product = $arr[1];
  $edt_tax = $editora->get_taxonomy_object();
  $edt_values = wc_get_product_terms( $product->get_id(), $editora->get_name(), array( 'fields' => 'all' ) );
  $url = esc_url( get_term_link( $edt_values[0]->term_id, 'pa_editora' ) );
  if ($edt_values[0]->count > 1){
    echo "<h2 class='widget-title'><span>Outros produtos da Editora {$edt_values[0]->name}</span></h2>";
    echo do_shortcode("[products attribute='editora' terms='{$edt_values[0]->name}' orderby='rand' limit='4' columns='4']");
    if( $edt_values[0]->count > 4 )
    { 
      echo "<a href='{$url}' style='margin-bottom:10px;'><button> Outros livros da Editora {$edt_values[0]->name}</button></a>";
    }else{ echo "Todos os livros da Editora {$edt_values[0]->name}"; }
  }
}