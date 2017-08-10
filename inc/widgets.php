<?php
/**
 * Contains all the functions related to sidebar and widget.
 *
 * @package ThemeGrill
 * @subpackage estore
 * @since estore 1.0
 */

add_action( 'widgets_init', 'estore_child_widgets_init' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function estore_child_widgets_init() {

	// Widgets Registration
	register_widget( "estore_child_product_slider_ban_widget" );
	register_widget( "estore_child_woocommerce_product_carousel" );
	register_widget( "estore_child_woocommerce_product_grid" );
}

// Featured Category Product Slider Widget
class estore_child_product_slider_ban_widget extends WP_Widget {

	function __construct() {
		$widget_ops = array(
			'classname'   => 'slider_wrapper category-slider clearfix product-ban',
			'description' => esc_html__( 'Display latest product or products of specific category, which will be used as the slider.', 'estore' ) );

		$control_ops = array(
			'width'  => 200,
			'height' => 250
		);

		parent::__construct( false,$name= esc_html__( 'TG-Child: Product Category Slider', 'estore' ), $widget_ops);
	}

	function form( $instance ) {
		$tg_defaults['number']   = 4;
		$tg_defaults['type']     = 'latest';
		$tg_defaults['category'] = '';

		$instance = wp_parse_args( (array) $instance, $tg_defaults );

		$number   = $instance['number'];
		$type     = $instance['type'];
		$category = absint( $instance[ 'category' ] );
	?>

	<p>
		<label for="<?php echo $this->get_field_id('number'); ?>"><?php esc_html_e( 'Number of posts to display:', 'estore' ); ?></label>
		<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" />
	</p>

	<p>
		<input type="radio" <?php checked($type, 'latest') ?> id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" value="latest"/><?php esc_html_e( 'Show latest Posts', 'estore' );?><br />
		<input type="radio" <?php checked($type,'category') ?> id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" value="category"/><?php esc_html_e( 'Show posts from a category', 'estore' );?><br />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php esc_html_e( 'Select category', 'estore' ); ?>:</label>
		<?php
		wp_dropdown_categories(
			array(
				'show_option_none' =>' ',
				'name'             => $this->get_field_name( 'category' ),
				'selected'         => $instance['category'],
				'taxonomy'         => 'product_cat'
			)
		);
		?>
	</p>

	<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance[ 'number' ]   = absint( $new_instance[ 'number' ] );
		$instance[ 'type' ]     = $new_instance[ 'type' ];
		$instance[ 'category' ] = absint( $new_instance[ 'category' ] );

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		global $post;
		$number   = empty( $instance[ 'number' ] ) ? 4 : $instance[ 'number' ];
		$type     = isset( $instance[ 'type' ] ) ? $instance[ 'type' ] : 'latest' ;
		$category = isset( $instance[ 'category' ] ) ? $instance[ 'category' ] : '';

		if( $type == 'latest' ) {
			$get_featured_posts = new WP_Query( array(
				'posts_per_page'        => $number,
				'post_type'             => 'product',
				'ignore_sticky_posts'   => true
			) );
		}
		else {
		$get_featured_posts = new WP_Query( array(
			'posts_per_page'        => $number,
			'post_type'             => 'product',
			'tax_query' => array(
					array(
						'taxonomy'  => 'product_cat',
						'field'     => 'id',
						'terms'     => $category
					)
				)
			) );
		}
		echo $before_widget;
		?>
		<ul class="home-slider product-ban">
		<?php
		while( $get_featured_posts->have_posts() ):
			$get_featured_posts->the_post();
			if( has_post_thumbnail() ) { 

				$title_attribute = get_the_title( $post->ID );
				

				?>
			<li>
				<div class="bg-ban">
				<div class="mask"></div>
					<?php
						the_post_thumbnail($post->ID, 'shop_catalog') ?> 
				</div> 
					<?php
				the_post_thumbnail( $post->ID, 'shop_catalog', array( 'title' => esc_attr( $title_attribute ), 'alt' => esc_attr( $title_attribute ) ) );
			?>
				<div class="slider-caption-wrapper">
					<h3 class="slider-title"> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> </h3>
					<div class="slider-content price"><?php echo 'R$ ' . wc_get_product($post->ID)->get_price(); ?></div>
					<a href="<?php the_permalink(); ?>" class="slider-btn"><?php esc_html_e( 'Conferir', 'estore' ); ?></a>
				</div>
			</li>
		<?php
		}
		endwhile;
		// Reset Post Data
		wp_reset_postdata();
		?>
		</ul>
		<?php echo $after_widget;
	}
}


// Estore WooCommerce Product Carousel Widget
class estore_child_woocommerce_product_carousel extends WP_Widget {
	function __construct() {
		$widget_ops = array(
			'classname'   => 'widget-featured-collection featured-collection-color clearfix',
			'description' => esc_html__( 'Show WooCommerce Featured Products Carousel.', 'estore' )
		);
		$control_ops = array(
			'width'  => 200,
			'height' => 250
		);
		parent::__construct( false, $name = esc_html__( 'TG-Child: Products Carousel', 'estore' ), $widget_ops, $control_ops);
	}

	function form( $instance ) {
		$defaults[ 'title' ]            = '';
		$defaults[ 'subtitle' ]         = '';
		$defaults[ 'source' ]           = '';
		$defaults[ 'category' ]         = '';
		$defaults[ 'product_number' ]   = 10;
		$defaults[ 'hide_thumbnail_mask' ]   = 0;

		$instance = wp_parse_args( (array) $instance, $defaults );

		$title            = esc_attr( $instance[ 'title' ] );
		$subtitle         = esc_textarea( $instance[ 'subtitle' ] );
		$source           = $instance[ 'source' ];
		$category         = absint( $instance[ 'category' ] );
		$product_number   = absint( $instance[ 'product_number' ] );
		$hide_thumbnail_mask = $instance[ 'hide_thumbnail_mask' ] ? 'checked="checked"' : '';
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'estore' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<?php esc_html_e( 'Description:','estore' ); ?>
		<textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id( 'subtitle' ); ?>" name="<?php echo $this->get_field_name('subtitle'); ?>"><?php echo $subtitle; ?></textarea>

		<p>
			<label for="<?php echo $this->get_field_id( 'source' ); ?>"><?php esc_html_e( 'Product Source:', 'estore' ); ?></label>
			<select id="<?php echo $this->get_field_id( 'source' ); ?>" name="<?php echo $this->get_field_name( 'source' ); ?>">
				<option value="latest" <?php selected( $instance['source'], 'latest'); ?>><?php esc_html_e( 'Latest Products', 'estore' ); ?></option>
				<option value="featured" <?php selected( $instance['source'], 'featured'); ?>><?php esc_html_e( 'Featured Products', 'estore' ); ?></option>
				<option value="sale" <?php selected( $instance['source'], 'sale'); ?>><?php esc_html_e( 'On Sale Products', 'estore' ); ?></option>
				<option value="category" <?php selected( $instance['source'], 'category'); ?>><?php esc_html_e( 'Certain Category', 'estore' ); ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php esc_html_e( 'Category:', 'estore' ); ?></label>
			<?php
			wp_dropdown_categories(
				array(
					'show_option_none' => '',
					'name'             => $this->get_field_name( 'category' ),
					'selected'         => $instance['category'],
					'taxonomy'         => 'product_cat'
				)
			);
			?>
		</p>


		<p>
			<label for="<?php echo $this->get_field_id( 'product_number' ); ?>"><?php esc_html_e( 'Number of Products:', 'estore' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'product_number' ); ?>" name="<?php echo $this->get_field_name( 'product_number' ); ?>" type="number" value="<?php echo $product_number; ?>" />
		</p>
		<p>
	    	<input class="checkbox" <?php echo $hide_thumbnail_mask; ?> id="<?php echo $this->get_field_id( 'hide_thumbnail_mask' ); ?>" name="<?php echo $this->get_field_name( 'hide_thumbnail_mask' ); ?>" type="checkbox" />
	    	<label for="<?php echo $this->get_field_id('hide_thumbnail_mask'); ?>"><?php esc_html_e( 'Check to hide image hover effect.', 'estore' ); ?></label>
	   	</p>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance[ 'title' ]          = sanitize_text_field( $new_instance[ 'title' ] );
		if ( current_user_can('unfiltered_html') )
			$instance[ 'subtitle' ] =  $new_instance[ 'subtitle' ];
		else
			$instance[ 'subtitle' ] = stripslashes( wp_filter_post_kses( addslashes( $new_instance[ 'subtitle' ] ) ) );
		$instance[ 'source' ]         = $new_instance[ 'source' ];
		$instance[ 'category' ]       = absint( $new_instance[ 'category' ] );
		$instance[ 'product_number' ] = absint( $new_instance[ 'product_number' ] );
		$instance[ 'hide_thumbnail_mask' ]   = isset( $new_instance[ 'hide_thumbnail_mask' ] ) ? 1 : 0;

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		global $post;
		$title            = apply_filters( 'widget_title', isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '');
		$subtitle         = isset( $instance[ 'subtitle' ] ) ? $instance[ 'subtitle' ] : '';
		$source           = isset( $instance[ 'source' ] ) ? $instance[ 'source' ] : '';
		$category         = isset( $instance[ 'category' ] ) ? $instance[ 'category' ] : '';
		$product_number   = isset( $instance[ 'product_number' ] ) ? $instance[ 'product_number' ] : '';
		$hide_thumbnail_mask = isset( $instance[ 'hide_thumbnail_mask' ] ) ? $instance[ 'hide_thumbnail_mask' ] : 0;

		// For Multilingual compatibility
		if ( function_exists( 'icl_register_string' ) ) {
			icl_register_string( 'eStore', 'TG: Product Carousel Subtitle' . $this->id, $subtitle );
		}
		if ( function_exists( 'icl_t' ) ) {
			$subtitle  = icl_t( 'eStore', 'TG: Product Carousel Subtitle'. $this->id, $subtitle );
		}

		if ( $source == 'featured' ) {
			$args = array(
				'post_type'        => 'product',
				'posts_per_page'   => $product_number,
				'tax_query' => array(
					array(
						'taxonomy' => 'product_visibility',
						'field'    => 'name',
						'terms'    => 'featured',
					),
				)
			);
		} elseif ( $source == 'sale' ) {
			$args = array(
				'post_type'      => 'product',
				'meta_query'     => array(
				'relation' => 'OR',
					array( // Simple products type
						'key'           => '_sale_price',
						'value'         => 0,
						'compare'       => '>',
						'type'          => 'numeric'
					),
					array( // Variable products type
					'key'           => '_min_variation_sale_price',
					'value'         => 0,
					'compare'       => '>',
					'type'          => 'numeric'
					)
				),
				'posts_per_page'   => $product_number
			);
		} elseif ( $source == 'category' ){
			$args = array(
				'post_type' => 'product',
				'tax_query' => array(
					array(
						'taxonomy'  => 'product_cat',
						'field'     => 'id',
						'terms'     => $category
					)
				),
				'posts_per_page' => $product_number
			);
		} else {
			$args = array(
				'post_type' => 'product',
				'posts_per_page' => $product_number
			);
		}
		echo $before_widget; ?>
		<div class="tg-container">
			<div class="section-title-wrapper clearfix">
				<div class="section-title-block">
					<?php if ( !empty( $title ) ) { ?>
					<h3 class="page-title"><?php echo esc_html( $title ); ?></h3>
					<?php }
					if ( !empty( $subtitle ) ) { ?>
					<h4 class="page-sub-title"><?php echo esc_textarea( $subtitle );?></h4>
					<?php } ?>
				</div>
			</div>
			<div class="featured-wrapper clearfix">
				<ul class="featured-slider">
				<?php
				$featured_query = new WP_Query( $args );
				while ($featured_query->have_posts()) :
					$featured_query->the_post();
					$product = wc_get_product( $featured_query->post->ID ); ?>
					<li>
					<?php
						$image_id = get_post_thumbnail_id();
						$image_url = wp_get_attachment_image_src($image_id,'shop_single', false); ?>
						<figure class="featured-img">
							<?php if($image_url[0]) { ?>
								<a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>" alt="<?php the_title(); ?>"><img src="<?php echo esc_url( $image_url[0] ); ?>" alt="<?php the_title_attribute(); ?>"></a>
							<?php } else { ?>
								<a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>" alt="<?php the_title(); ?>"><img src="<?php echo estore_woocommerce_placeholder_img_src(); ?>" alt="<?php the_title_attribute(); ?>"></a>
							<?php } ?>
							<?php if ( $product->is_on_sale() ) : ?>
								<?php echo apply_filters( 'woocommerce_sale_flash', '<div class="sales-tag">' . esc_html__( 'Sale!', 'estore' ) . '</div>', $post, $product ); ?>
							<?php endif; ?>

							<?php if ( $hide_thumbnail_mask != 1 ) : ?>
								<div class="featured-hover-wrapper">
									<div class="featured-hover-block">
										<?php if($image_url[0]) { ?>
										<a href="<?php echo esc_url( $image_url[0] ); ?>" class="zoom" data-rel="prettyPhoto"><i class="fa fa-search-plus"> </i></a>
										<?php } else {?>
										<a href="<?php echo estore_woocommerce_placeholder_img_src(); ?>"  class="zoom" data-rel="prettyPhoto"><i class="fa fa-search-plus"> </i></a>
										<?php }
										woocommerce_template_loop_add_to_cart( $product ); ?>
									</div>
								</div><!-- featured hover end -->
							<?php endif; ?>
						</figure>
						<div class="featured-content-wrapper">
							<h3 class="featured-title"> <a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<div class="woocommerce-product-rating woocommerce"> <?php
								 if ( $rating_html = wc_get_rating_html( $product->get_average_rating() ) ) { ?>
										<?php echo $rating_html; ?>
									<?php } else {
										echo '<div class="star-rating"></div>' ;
									}?>
							</div>
							<?php if ( $price_html = $product->get_price_html() ) : ?>
								<span class="price"><span class="price-text"><?php esc_html_e('Price:', 'estore'); ?></span><?php echo $price_html; ?></span>
							<?php endif; ?>

							<?php
							if( function_exists( 'YITH_WCWL' ) ){
								$url = add_query_arg( 'add_to_wishlist', $product->get_id() );
							?>
							<a href="<?php echo esc_url($url); ?>" class="single_add_to_wishlist" ><?php esc_html_e('Add to Wishlist','estore'); ?><i class="fa fa-heart"></i></a>
							<?php } ?>
						</div><!-- featured content wrapper -->
					</li>
				<?php
				endwhile;
				?>
				</ul>
			</div>
		</div>

		<?php wp_reset_postdata(); ?>
		<?php
		echo $after_widget;
	}
}


// Estore WooCommerce Product Grid Widget
class estore_child_woocommerce_product_grid extends WP_Widget {
	function __construct() {
		$widget_ops = array(
			'classname'   => 'widget-collection clearfix',
			'description' => esc_html__( 'Show WooCommerce Featured Products Grid.', 'estore' )
		);
		$control_ops = array(
			'width'  => 200,
			'height' => 250
		);
		parent::__construct( false, $name = esc_html__( 'TG-Child: Product Grid', 'estore' ), $widget_ops, $control_ops);
	}

	function form( $instance ) {
		$defaults[ 'title' ]            = '';
		$defaults[ 'subtitle' ]         = '';
		$defaults[ 'category']          = '';
		$defaults[ 'product_number' ]   = 10;
		$defaults[ 'cat_image_url' ]    = '';
		$defaults[ 'cat_image_link' ]   = '';
		$defaults[ 'align' ]            = 'collection-left-align';

		$instance = wp_parse_args( (array) $instance, $defaults );

		$title            = esc_attr( $instance[ 'title' ] );
		$subtitle         = esc_textarea( $instance[ 'subtitle' ] );
		$cat_image_url    = esc_url( $instance[ 'cat_image_url' ] );
		$cat_image_link   = esc_url( $instance[ 'cat_image_link' ] );
		$align            = $instance[ 'align' ];
		$category         = absint( $instance[ 'category' ] );
		$product_number   = absint( $instance[ 'product_number' ] );
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'estore' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<?php esc_html_e( 'Description:','estore' ); ?>
		<textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id( 'subtitle' ); ?>" name="<?php echo $this->get_field_name('subtitle'); ?>"><?php echo $subtitle; ?></textarea>

		<label><?php esc_html_e( 'Add your Category Image here.', 'estore' ); ?></label>

		<p>
			<label for="<?php echo $this->get_field_id( 'cat_image_link' ); ?>"> <?php esc_html_e( 'Image Link', 'estore' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'cat_image_link' ); ?>" name="<?php echo $this->get_field_name( 'cat_image_link' ); ?>" value="<?php echo $instance[ 'cat_image_link' ]; ?>"/>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'cat_image_url' ); ?>"> <?php esc_html_e( 'Category Image', 'estore' ); ?></label>
			<div class="media-uploader" id="<?php echo $this->get_field_id( 'cat_image_url' ); ?>">
				<div class="custom_media_preview">
					<?php if ( $instance[ 'cat_image_url' ] != '' ) : ?>
						<img class="custom_media_preview_default" src="<?php echo esc_url( $instance[ 'cat_image_url' ] ); ?>" style="max-width:100%;" />
					<?php endif; ?>
				</div>
				<input type="text" class="widefat custom_media_input" id="<?php echo $this->get_field_id( 'cat_image_url' ); ?>" name="<?php echo $this->get_field_name( 'cat_image_url' ); ?>" value="<?php echo esc_url( $instance['cat_image_url'] ); ?>" style="margin-top:5px;" />
				<button class="custom_media_upload button button-secondary button-large" id="<?php echo $this->get_field_id( 'cat_image_url' ); ?>" data-choose="<?php esc_attr_e( 'Choose an image', 'estore' ); ?>" data-update="<?php esc_attr_e( 'Use image', 'estore' ); ?>" style="width:100%;margin-top:6px;margin-right:30px;"><?php esc_html_e( 'Select an Image', 'estore' ); ?></button>
			</div>
		</p>

		<label><?php esc_html_e( 'Choose where to align your image.', 'estore' ); ?></label>

		<p>
			<input type="radio" <?php checked( $align, 'collection-right-align' ) ?> id="<?php echo $this->get_field_id( 'align' ); ?>" name="<?php echo $this->get_field_name( 'align' ); ?>" value="collection-right-align" /><?php esc_html_e( 'Right Align', 'estore' );?><br />
			<input type="radio" <?php checked( $align,'collection-left-align' ) ?> id="<?php echo $this->get_field_id( 'align' ); ?>" name="<?php echo $this->get_field_name( 'align' ); ?>" value="collection-left-align" /><?php esc_html_e( 'Left Align', 'estore' );?><br />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php esc_html_e( 'Category:', 'estore' ); ?></label>
			<?php
			wp_dropdown_categories(
				array(
					'show_option_none' => '',
					'name'             => $this->get_field_name( 'category' ),
					'selected'         => $instance['category'],
					'taxonomy'         => 'product_cat'
				)
			);
			?>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'product_number' ); ?>"><?php esc_html_e( 'Number of Products:', 'estore' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'product_number' ); ?>" name="<?php echo $this->get_field_name( 'product_number' ); ?>" type="number" value="<?php echo $product_number; ?>" />
		</p>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance[ 'title' ]          = sanitize_text_field( $new_instance[ 'title' ] );
		if ( current_user_can('unfiltered_html') )
			$instance[ 'subtitle' ] =  $new_instance[ 'subtitle' ];
		else
			$instance[ 'subtitle' ] = stripslashes( wp_filter_post_kses( addslashes( $new_instance[ 'subtitle' ] ) ) );
		$instance[ 'category' ]       = absint( $new_instance[ 'category' ] );

		$instance[ 'product_number' ] = absint( $new_instance[ 'product_number' ] );

		$instance[ 'cat_image_link' ] = esc_url_raw( $new_instance[ 'cat_image_link' ] );
		$instance[ 'cat_image_url' ]  = esc_url_raw( $new_instance[ 'cat_image_url' ] );
		$instance[ 'align' ]          = $new_instance[ 'align' ];

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		global $post;
		$title            = apply_filters( 'widget_title', isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '');
		$subtitle         = isset( $instance[ 'subtitle' ] ) ? $instance[ 'subtitle' ] : '';

		$cat_image_link   = isset( $instance[ 'cat_image_link' ] ) ? $instance[ 'cat_image_link' ] : '';
		$cat_image_url    = isset( $instance[ 'cat_image_url' ] ) ? $instance[ 'cat_image_url' ] : '';
		$align            = isset( $instance[ 'align' ] ) ? $instance[ 'align' ] : 'collection-left-align' ;

		$category         = isset( $instance[ 'category' ] ) ? $instance[ 'category' ] : '';
		$product_number   = isset( $instance[ 'product_number' ] ) ? $instance[ 'product_number' ] : '';

		// For Multilingual compatibility
		if ( function_exists( 'icl_register_string' ) ) {
			icl_register_string( 'eStore', 'TG: Product Grid Subtitle' . $this->id, $subtitle );
			icl_register_string( 'eStore', 'TG: Product Grid Image' . $this->id, $cat_image_url );
			icl_register_string( 'eStore', 'TG: Product Grid Image Link' . $this->id, $cat_image_link );
		}
		if ( function_exists( 'icl_t' ) ) {
			$subtitle       = icl_t( 'eStore', 'TG: Product Grid Subtitle'. $this->id, $subtitle );
			$cat_image_url  = icl_t( 'eStore', 'TG: Product Grid Image'. $this->id, $cat_image_url );
			$cat_image_link = icl_t( 'eStore', 'TG: Product Grid Image Link'. $this->id, $cat_image_link );
		}

		$args = array(
			'post_type' => 'product',
			'orderby'   => 'date',
			'tax_query' => array(
				array(
					'taxonomy'  => 'product_cat',
					'field'     => 'id',
					'terms'     => $category
				)
			),
			'posts_per_page' => $product_number
		);
		echo $before_widget; ?>
		<div class="tg-container estore-cat-color_<?php echo $category; ?> <?php echo $align; ?>">
			<div class="section-title-wrapper clearfix">
				<div class="section-title-block">
					<?php if ( !empty( $title ) ) { ?>
					<h3 class="page-title"><a href="<?php echo esc_url( get_category_link( $category ) ); ?>"><?php echo esc_html( $title ); ?></a></h3>
					<?php }
					if ( !empty( $subtitle ) ) { ?>
					<h4 class="page-sub-title"><?php echo esc_textarea( $subtitle );?></h4>
					<?php } ?>
				</div>
				<div class="sorting-form-wrapper">
					<a href="<?php echo esc_url( get_category_link( $category ) ); ?>"><?php esc_html_e( 'View all', 'estore' ); ?></a>
				</div>
			</div>
			<div class="collection-block-wrapper tg-column-wrapper clearfix">
				<div class="tg-column-4 collection-block">
						<?php
						$output = '';
						if ( !empty( $cat_image_url ) ) {
							if ( !empty( $cat_image_link ) ) {
							$output .= '<a href="'.esc_url($cat_image_link).'" target="_blank" rel="nofollow">
											<img src="'.esc_url($cat_image_url).'" alt="'.esc_html($title).'" />
										</a>';
							} else {
								$output .= '<img src="'.esc_url($cat_image_url).'" alt="'.esc_html($title).'" />';
							}
							echo $output;
						} ?>
				</div>
				<?php
				$count = 1;
				$featured_query = new WP_Query( $args );
				while ($featured_query->have_posts()) :
					$featured_query->the_post();
					$product = wc_get_product( $featured_query->post->ID );
				if($count == 1){ ?>
				<div class="tg-column-4 collection-block">
					<div class="hot-product-block">
						<h3 class="hot-product-title"><?php esc_html_e( 'Hot products', 'estore' ); ?></h3>
						<div class="hot-product-content-wrapper clearfix">
							<?php
							$image_id = get_post_thumbnail_id();
							$image_url = wp_get_attachment_image_src($image_id,'estore-medium-image', false); ?>
							<figure class="hot-img">
								<a href="<?php the_permalink(); ?>">
									<?php if($image_url) { ?>
									<img src="<?php echo esc_url( $image_url[0] ); ?>" alt="<?php the_title_attribute(); ?>">
									<?php } else { ?>
										<img src="<?php echo get_template_directory_uri() . '/images/placeholder-shop-380x250.jpg'; ?>" alt="<?php the_title_attribute(); ?>" width="250" height="180" >
									<?php } ?>
								</a>
								<div class="cart-price-wrapper clearfix">
									<?php woocommerce_template_loop_add_to_cart( $product ); ?>
									<?php if ( $price_html = $product->get_price_html() ) : ?>
									<span class="hot-price price"><?php echo $price_html; ?></span>
								<?php endif; ?>
								</div>
								<?php if ( $product->is_on_sale() ) : ?>
									<?php echo apply_filters( 'woocommerce_sale_flash', '<div class="sales-tag">' . esc_html__( 'Sale!', 'estore' ) . '</div>', $post, $product ); ?>
								<?php endif; ?>
							</figure>
							<div class="hot-content-wrapper">
								<h3 class="hot-title"> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<div class="hot-content"><?php the_excerpt(); ?></div>
								<!-- Rating products -->
								<div class="woocommerce-product-rating woocommerce">
									<?php if ( $rating_html = wc_get_rating_html( $product->get_average_rating() ) ) { ?>
										<?php echo $rating_html; ?>
									<?php } else {
										echo '<div class="star-rating"></div>' ;
									}?>
								</div>
								<?php
								if( function_exists( 'YITH_WCWL' ) ){
									$url = add_query_arg( 'add_to_wishlist', $product->get_id() );
								?>
									<a href="<?php echo esc_url($url); ?>" class="single_add_to_wishlist" ><?php esc_html_e('Add to Wishlist','estore'); ?><i class="fa fa-heart"></i></a>
								<?php } ?>
							</div> <!-- hot-content-wrapper end -->
						</div> <!-- hot-product-content-wrapper end -->
					</div> <!-- hot product block end -->
				</div>
				<?php }

				if($count == 2 || $count == 7){ ?>
					<div class="tg-column-4 collection-block">
						<div class="product-list-wrap">
				<?php }
					if($count > 1 && $count < 7 || $count > 6) { ?>
						<div class="product-list-block clearfix child-product">
						<?php
							$image_id = get_post_thumbnail_id();
							$image_url = wp_get_attachment_image_src($image_id,'shop_thumbnail', false); ?>
							<figure class="product-list-img">
								<a href="<?php the_permalink(); ?>">
									<?php if($image_url[0]) { ?>
									<img src="<?php echo esc_url( $image_url[0] ); ?>" alt="<?php the_title_attribute(); ?>">
									<?php } else { ?>
										<img src="<?php echo estore_woocommerce_placeholder_img_src(); ?>" alt="<?php the_title_attribute(); ?>" width="75" height="75">
									<?php } ?>
								</a>
							</figure>
							<div class="product-list-content">
								<h3 class="product-list-title"> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> </h3>
								<?php if ( $price_html = $product->get_price_html() ) : ?>
									<span class="price"><span class="price-text"><?php esc_html_e('Price: ', 'estore'); ?></span><?php echo $price_html; ?></span>
								<?php endif; ?>
								<div class="cart-wishlist-btn">
								<?php
								if( function_exists( 'YITH_WCWL' ) ){
									$url = add_query_arg( 'add_to_wishlist', $product->get_id() );
								?>
									<a href="<?php echo esc_url($url); ?>" class="single_add_to_wishlist" ><?php esc_html_e('Add to Wishlist','estore'); ?><i class="fa fa-heart"></i></a>
								<?php }
									woocommerce_template_loop_add_to_cart( $product );
								?>

								</div> <!-- cart-wishlist-btn end -->
							</div>
						</div>
				<?php } // Closing div for columns
				if($count == 6){ ?>
					</div>
				</div>
				<?php }
				$count++;
				endwhile;
				wp_reset_postdata();
				?>
			</div><!-- collection-block-wrapper tg-column-wrapper clearfix -->
			</div>
		<?php
		echo $after_widget;
	}
}
