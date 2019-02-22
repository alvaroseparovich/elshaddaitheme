<?php


/**
 * Page Title function.
 *
 * @param  bool $echo Should echo title.
 * @return string
 */
function woocommerce_page_title( $echo = true ) {

    if ( is_search() ) {
        /* translators: %s: search query */
        $page_title = sprintf( __( 'Search results: &ldquo;%s&rdquo;', 'woocommerce' ), get_search_query() );

        if ( get_query_var( 'paged' ) ) {
            /* translators: %s: page number */
            $page_title .= sprintf( __( '&nbsp;&ndash; Page %s', 'woocommerce' ), get_query_var( 'paged' ) );
        }
    } elseif ( is_tax() ) {

        $page_title = single_term_title( '', false );

    } else {

        $shop_page_id = wc_get_page_id( 'shop' );
        $page_title   = get_the_title( $shop_page_id );

    }

    $page_title = apply_filters( 'woocommerce_page_title', $page_title );

    if ( $echo ) {
        echo $page_title; // WPCS: XSS ok.
    } else {
        return $page_title;
    }
}