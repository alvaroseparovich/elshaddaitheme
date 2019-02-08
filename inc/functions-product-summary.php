<?php


//Adicionar bottões para almentar unidades e diminuir, na página de Produtos.
function add_cart_button_less(){ 
    global $product;
    if(number_format( $product->stock,0,'','' ) > 1 or $product->manage_stock=="no") {
        echo'<button class="btElLess" type="button" onclick="removeItem(); return false;">-</button></div>';
        }
      }
  function add_cart_button_plus(){ 
    global $product;
    if(number_format( $product->stock,0,'','' ) > 1 or $product->manage_stock=="no") {
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