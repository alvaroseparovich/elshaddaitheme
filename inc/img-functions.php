<?php

if ( ! function_exists( 'estore_setup' ) ) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function estore_1setup() {
      // Cropping the images to different sizes to be used in the theme
      add_image_size( 'estore-medium-image111', 240, 240);
      add_image_size( 'elshaGrid1', 110, 120);
  
      // Cropping the images to different sizes to be used in the theme **************REMOVE*****************
    remove_image_size( 'estore-featured-image');
    remove_image_size( 'estore-product-grid');
    remove_image_size( 'estore-square');
    remove_image_size( 'estore-slider');
    }
  endif; // estore_setup
  add_action( 'after_setup_theme', 'estore_1setup', 11 );