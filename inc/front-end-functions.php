<?php

function elshaddai_sale_flash($awe,$qwe,$product ){
    
    $reg = $product->get_regular_price();
    $sal = $product->get_price();
    $percent = 100 - round($sal*100/$reg); 

    return '<div class="sales-tag">' . $percent . '%</div>';
    return;
}
add_filter( 'woocommerce_sale_flash', 'elshaddai_sale_flash', 10,3 );