<?php

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
  