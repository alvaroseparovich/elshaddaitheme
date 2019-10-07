<?php

function my_theme_enqueue_styles() {

    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri().'/static/css/style-sheet.css' );
    wp_enqueue_script( 'custom-script', get_stylesheet_directory_uri() . '/js-el-shaddai.min.js' );
}

add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );