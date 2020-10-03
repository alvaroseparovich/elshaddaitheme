<?php

function elshaddai_sale_flash($awe,$qwe,$product ){
    
    $reg = $product->get_regular_price();
    $sal = $product->get_price();
    $percent = 100 - round($sal*100/$reg); 

    return '<div class="sales-tag">' . $percent . '%</div>';
    return;
}
add_filter( 'woocommerce_sale_flash', 'elshaddai_sale_flash', 10,3 );

function estore_entry_title() {
    if (is_singular('post')):
        the_title( '<h1 class="entry-title"  style="margin: 0.4em 0 1em;">', '</h1>' );
    elseif ( is_singular() ) :
        the_title( '<h1 class="entry-title">', '</h1>' );
    elseif ( is_archive() ) :
        the_archive_title( '<h1 class="page-title">', '</h1>' );
    elseif ( is_404() ) :
        ?>
        <h1 class="page-title"> <?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'estore' ); ?></h1>
    <?php
    else :
        the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
    endif;
}