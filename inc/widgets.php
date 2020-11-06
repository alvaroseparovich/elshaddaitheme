<?php

require get_stylesheet_directory() . '/inc/widget/editoras-autores-especial.php';
require get_stylesheet_directory() . '/inc/widget/editoras-search.php';
require get_stylesheet_directory() . '/inc/widget/index.php';

add_action( 'widgets_init', 'estore_child_widgets_init' );


function wpdocs_remove_widgets() {
  unregister_widget( 'WP_Widget_Calendar' );  unregister_widget( 'WP_Widget_Archives' );  unregister_widget( 'WP_Widget_Links' );  unregister_widget( 'WP_Widget_Meta' );  unregister_widget( 'WP_Widget_Recent_Posts' );  unregister_widget( 'WP_Widget_Recent_Comments' );  unregister_widget( 'WP_Widget_RSS' );  unregister_widget( 'WP_Widget_Tag_Cloud' );  unregister_widget( 'WP_Widget_media_video' );  unregister_widget( 'WP_Widget_media_gallery' );
}
add_action( 'widgets_init', 'wpdocs_remove_widgets' );

function remove_some_widgets(){
	// Unregister some of the TwentyTen sidebars
	unregister_sidebar( 'estore_footer_sidebar1' );	unregister_sidebar( 'estore_footer_sidebar2' );	unregister_sidebar( 'estore_footer_sidebar3' );	unregister_sidebar( 'estore_footer_sidebar4' );
}
add_action( 'widgets_init', 'remove_some_widgets', 11 );

function estore_child_widgets_init() {

	// Widgets Registration
	register_widget( "estore_child_product_slider_ban_widget" );
	register_widget( "estore_child_woocommerce_product_attribute_grid" );
	register_widget( "estore_child_woocommerce_product_attribute_carousel" );
	register_widget( "elshaddai_woocommerce_vertical_promo_widget" );
	register_widget( "elshaddai_banner_img" );
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

		parent::__construct( false,$name= esc_html__( 'A-Child: Product Category Slider', 'estore' ), $widget_ops);
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
			$id_post_el = $post->ID;
			if( has_post_thumbnail() ) {
				$title_attribute = get_the_title( $id_post_el );
				?>
			<li>
				<div class="bg-ban">
				<div class="mask"></div>
					<img class="wp-post-image" src="<?php	 echo($img_slider_el = wp_get_attachment_image_src(get_post_thumbnail_id( $id_post_el), 'medium')[0]); ?>" alt="back-slider">
				</div>
				<a href="<?php the_permalink() ?>">
				<img  class="wp-post-image" src="<?php		echo($img_slider_el);?>" alt="img-slider">
			</a>
				<div class="slider-caption-wrapper">
					<h3 class="slider-title"> <a href="<?php the_permalink() ?>"><?php the_title(); ?></a> </h3>
					<div class="slider-content price"><?php echo 'R$ ' . wc_get_product($id_post_el)->get_price(); ?></div>
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

// Estore WooCommerce Product Grid Widget
class estore_child_woocommerce_product_attribute_grid extends WP_Widget {
	function __construct() {
		$widget_ops = array(
			'classname'   => 'widget-collection clearfix',
			'description' => esc_html__( 'Show WooCommerce Featured Products Grid.', 'elshaddai-estore-child' )
		);
		$control_ops = array(
			'width'  => 200,
			'height' => 250
		);
		parent::__construct( false, $name = esc_html__( 'A-C: Atribute Grid', 'el-shaddai' ), $widget_ops, $control_ops);
	}

	function form( $instance ) {
		$defaults[ 'title' ]            = '';
		$defaults[ 'subtitle' ]         = '';
		$defaults[ 'product_number' ]   = 10;
		$defaults[ 'attr_image_url' ]   = '';
		$defaults[ 'attr_image_link' ]  = '';
		$defaults[ 'align' ]            = 'collection-left-align';
		$defaults[ 'term_name']         = '';
		foreach (get_taxonomies() as $value) {
			$defaults[ $value ] 					= '';
		}

		$instance = wp_parse_args( (array) $instance, $defaults );

		$title            = esc_attr( $instance[ 'title' ] );
		$subtitle         = esc_textarea( $instance[ 'subtitle' ] );
		$attr_image_url    = esc_url( $instance[ 'attr_image_url' ] );
		$attr_image_link   = esc_url( $instance[ 'attr_image_link' ] );
		$product_number   = absint( $instance[ 'product_number' ] );
		$align            = $instance[ 'align' ];
		$term_name        = $instance[ 'term_name' ];
		foreach (get_taxonomies() as $value) {
			${$value} 				= $instance[ $value ];
		}
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'estore' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<?php esc_html_e( 'Description:','estore' );
		?>
		<textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id( 'subtitle' ); ?>" name="<?php echo $this->get_field_name('subtitle'); ?>"><?php echo $subtitle; ?></textarea>

		<label><?php esc_html_e( 'Add your Attribute Image here.', 'estore' ); ?></label>

		<p>
			<label for="<?php echo $this->get_field_id( 'attr_image_link' ); ?>"> <?php esc_html_e( 'Image Link', 'estore' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'attr_image_link' ); ?>" name="<?php echo $this->get_field_name( 'attr_image_link' ); ?>" value="<?php echo $instance[ 'attr_image_link' ]; ?>"/>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'attr_image_url' ); ?>"> <?php esc_html_e( 'Attribute Image', 'estore' ); ?></label>
			<div class="media-uploader" id="<?php echo $this->get_field_id( 'attr_image_url' ); ?>">
				<div class="custom_media_preview">
					<?php if ( $instance[ 'attr_image_url' ] != '' ) : ?>
						<img class="custom_media_preview_default" src="<?php echo esc_url( $instance[ 'attr_image_url' ] ); ?>" style="max-width:100%;" />
					<?php endif; ?>
				</div>
				<input type="text" class="widefat custom_media_input" id="<?php echo $this->get_field_id( 'attr_image_url' ); ?>" name="<?php echo $this->get_field_name( 'attr_image_url' ); ?>" value="<?php echo esc_url( $instance['attr_image_url'] ); ?>" style="margin-top:5px;" />
				<button class="custom_media_upload button button-secondary button-large" id="<?php echo $this->get_field_id( 'attr_image_url' ); ?>" data-choose="<?php esc_attr_e( 'Choose an image', 'estore' ); ?>" data-update="<?php esc_attr_e( 'Use image', 'estore' ); ?>" style="width:100%;margin-top:6px;margin-right:30px;"><?php esc_html_e( 'Select an Image', 'estore' ); ?></button>
			</div>
		</p>

		<label><?php esc_html_e( 'Choose where to align your image.', 'estore' ); ?></label>

		<p>
			<input type="radio" <?php checked( $align, 'collection-right-align' ) ?> id="<?php echo $this->get_field_id( 'align' ); ?>" name="<?php echo $this->get_field_name( 'align' ); ?>" value="collection-right-align" /><?php esc_html_e( 'Right Align', 'estore' );?><br />
			<input type="radio" <?php checked( $align,'collection-left-align' ) ?> id="<?php echo $this->get_field_id( 'align' ); ?>" name="<?php echo $this->get_field_name( 'align' ); ?>" value="collection-left-align" /><?php esc_html_e( 'Left Align', 'estore' );?><br />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'term_name' ); ?>"><?php esc_html_e( 'Termo de seleção:', 'El-shaddai' ); ?></label><br/>
			<?php
			foreach (get_taxonomies() as $key) {
				echo '<span style="display:none;">';
				$result_c = checked( $term_name, $key );
				echo'</span>';
				echo (sprintf('<input type="radio" %s id="%s" name="%s" " value="%s" />%s<br/>' , $result_c , $this->get_field_id( 'term_name' ) , $this->get_field_name( 'term_name' ) , $key, $key ));
				}
			?>
		</select>
		</p>
		<p>
			<?php
			foreach (get_taxonomies() as $value) {
				?><label for="<?php echo $this->get_field_id( $alue ); ?>"><?php esc_html_e( $value, 'estore' ); ?></label><?php

				wp_dropdown_categories(
					array(
						'show_option_none' => '',
						'name'             => $this->get_field_name( $value ),
						'selected'         => $instance[$value],
						'taxonomy'         => $value
					)
				);
			echo "<br/>";
			}
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
		$instance[ 'product_number' ] = absint( $new_instance[ 'product_number' ] );
		$instance[ 'attr_image_link' ] = esc_url_raw( $new_instance[ 'attr_image_link' ] );
		$instance[ 'attr_image_url' ]  = esc_url_raw( $new_instance[ 'attr_image_url' ] );
		$instance[ 'align' ]          = $new_instance[ 'align' ];
		$instance[ 'term_name' ]       = $new_instance[ 'term_name' ];
		foreach (get_taxonomies() as $value) {
			$instance[ $value ]       = absint( $new_instance[ $value ] );
		}

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		global $post;
		$title            = apply_filters( 'widget_title', isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '');
		$subtitle         = isset( $instance[ 'subtitle' ] ) ? $instance[ 'subtitle' ] : '';

		$attr_image_link   = isset( $instance[ 'attr_image_link' ] ) ? $instance[ 'attr_image_link' ] : '';
		$attr_image_url    = isset( $instance[ 'attr_image_url' ] ) ? $instance[ 'attr_image_url' ] : '';
		$align            = isset( $instance[ 'align' ] ) ? $instance[ 'align' ] : 'collection-left-align' ;

		$term_name         = isset( $instance[ 'term_name' ] ) ? $instance[ 'term_name' ] : '';
		$product_number   = isset( $instance[ 'product_number' ] ) ? $instance[ 'product_number' ] : '';
		${$term_name}         = isset( $instance[ $term_name ] ) ? $instance[ $term_name ] : '';

		$img_Pathern = get_stylesheet_directory_uri() . '/none.jpg';

		// For Multilingual compatibility
		if ( function_exists( 'icl_register_string' ) ) {
			icl_register_string( 'eStore', 'TG: Product Grid Subtitle' . $this->id, $subtitle );
			icl_register_string( 'eStore', 'TG: Product Grid Image' . $this->id, $attr_image_url );
			icl_register_string( 'eStore', 'TG: Product Grid Image Link' . $this->id, $attr_image_link );
			icl_register_string( 'eStore', 'TG: Product Grid Term Name' . $this->id, $term_name );
		}
		if ( function_exists( 'icl_t' ) ) {
			$subtitle       = icl_t( 'eStore', 'TG: Product Grid Subtitle'. $this->id, $subtitle );
			$attr_image_url  = icl_t( 'eStore', 'TG: Product Grid Image'. $this->id, $attr_image_url );
			$attr_image_link = icl_t( 'eStore', 'TG: Product Grid Image Link'. $this->id, $attr_image_link );
			$term_name = icl_t( 'eStore', 'TG: Product Grid Term Name'. $this->id, $term_name );
		}

		$args = array(
			'post_type' => 'product',
			'orderby'   => 'date',
			'tax_query' => array(
				array(
					'taxonomy'  => $term_name,
					'field'     => 'id',
					'terms'     => ${$term_name}
				)
			),
			'posts_per_page' => $product_number
		);

		echo $before_widget;
		?>
		<div class="tg-container estore-cat-color_<?php echo ${$term_name}; ?> <?php echo $align; ?>">
			<div class="section-title-wrapper clearfix">
				<div class="section-title-block">
					<?php if ( !empty( $title ) ) { ?>
					<h3 class="page-title"><a href="<?php echo esc_url( get_term_link( ${$term_name} , $term_name) ); ?>"><?php echo esc_html( $title );?></a></h3>
					<?php }
					if ( !empty( $subtitle ) ) { ?>
					<h4 class="page-sub-title"><?php echo esc_textarea( ${$term_name} );?></h4>
					<?php } ?>
				</div>
				<div class="sorting-form-wrapper">
					<a href="<?php echo esc_url( get_term_link( ${$term_name} , $term_name) ); ?>"><?php esc_html_e( 'View all', 'estore' ); ?></a>
				</div>
			</div>
			<div class="collection-block-wrapper tg-column-wrapper clearfix">
				<div class="tg-column-4 collection-block">
						<?php
						$output = '';
						if ( !empty( $attr_image_url ) ) {
							if ( !empty( $attr_image_link ) ) {
							$output .= '<a href="'.esc_url($attr_image_link).'" target="_blank" rel="nofollow">
											<img data-src="'.esc_url($attr_image_url).'" src="'.$img_Pathern.'" alt="'.esc_html($title).'" />
										</a>';
							} else {
								$output .= '<img src="'.esc_url($attr_image_url).'" alt="'.esc_html($title).'" />';
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
							$image_url = wp_get_attachment_image_src(get_post_thumbnail_id(),'estore-medium-image', false); ?>
							<figure class="hot-img">
								<a href="<?php the_permalink(); ?>">
									<?php if($image_url) { ?>
									<img src="<?php echo $img_Pathern; ?>" data-src="<?php echo esc_url( $image_url[0] ); ?>" alt="<?php the_title_attribute(); ?>">
									<?php } else { ?>
										<img data-src="<?php echo get_template_directory_uri() . '/images/placeholder-shop-380x250.jpg'; ?>" src="<?php echo($img_Pathern) ?>" alt="<?php the_title_attribute(); ?>" width="250" height="180" >
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
							$image_url = wp_get_attachment_image_src(get_post_thumbnail_id(),'elshaGrid1', false); ?>
							<figure class="product-list-img">
								<a href="<?php the_permalink(); ?>">
									<?php if($image_url[0]) { ?>
									<img data-src="<?php echo esc_url( $image_url[0] );?>" src="<?php echo( $img_Pathern) ?>"  alt="<?php the_title_attribute(); ?>">
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

// Estore WooCommerce Product Carousel Widget
class estore_child_woocommerce_product_attribute_carousel extends WP_Widget {
	function __construct() {
		$widget_ops = array(
			'classname'   => 'widget-featured-collection featured-collection-color clearfix attribute',
			'description' => esc_html__( 'Show WooCommerce Products Attribute Carousel.', 'elshaddai-estore-child' )
		);
		$control_ops = array(
			'width'  => 200,
			'height' => 250
		);
		parent::__construct( false, $name = esc_html__( 'A-Child: Products Attribute Carousel', 'estore' ), $widget_ops, $control_ops);
	}

	function form( $instance ) {
		$defaults[ 'title' ]            = '';
		$defaults[ 'subtitle' ]         = '';
		$defaults[ 'source' ]           = '';
		$defaults[ 'product_number' ]   = 10;
		$defaults[ 'hide_thumbnail_mask' ]   = 0;
		$defaults[ 'term_name']         = '';
		foreach (get_taxonomies() as $value) {
			$defaults[ $value ] 					= '';
		}

		$instance = wp_parse_args( (array) $instance, $defaults );

		$title            = esc_attr( $instance[ 'title' ] );
		$subtitle         = esc_textarea( $instance[ 'subtitle' ] );
		$source           = $instance[ 'source' ];
		$product_number   = absint( $instance[ 'product_number' ] );
		$hide_thumbnail_mask = $instance[ 'hide_thumbnail_mask' ] ? 'checked="checked"' : '';
		$term_name        = $instance[ 'term_name' ];
		foreach (get_taxonomies() as $value) {
			${$value} 				= $instance[ $value ];
		}
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'estore' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<?php esc_html_e( 'Description:','estore' ); ?>
		<textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id( 'subtitle' ); ?>" name="<?php echo $this->get_field_name('subtitle'); ?>"><?php echo $subtitle; ?></textarea>


		<p>
			<label for="<?php echo $this->get_field_id( 'term_name' ); ?>"><?php esc_html_e( 'Termo de seleção:', 'El-shaddai' ); ?></label><br/>
			<?php
			foreach (get_taxonomies() as $key) {
				echo '<span style="display:none;">';
				$result_c = checked( $term_name, $key );
				echo'</span>';
				echo (sprintf('<input type="radio" %s id="%s" name="%s" " value="%s" />%s<br/>' , $result_c , $this->get_field_id( 'term_name' ) , $this->get_field_name( 'term_name' ) , $key, $key ));
				}
			?>
		</select>
		</p>
		<p>
			<?php
			foreach (get_taxonomies() as $value) {
				?><label for="<?php echo $this->get_field_id( $alue ); ?>"><?php esc_html_e( $value, 'estore' ); ?></label><?php

				wp_dropdown_categories(
					array(
						'show_option_none' => '',
						'name'             => $this->get_field_name( $value ),
						'selected'         => $instance[$value],
						'taxonomy'         => $value
					)
				);
			echo "<br/>";
			}
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
		$instance[ 'product_number' ] = absint( $new_instance[ 'product_number' ] );
		$instance[ 'hide_thumbnail_mask' ]   = isset( $new_instance[ 'hide_thumbnail_mask' ] ) ? 1 : 0;
		$instance[ 'term_name' ]       = $new_instance[ 'term_name' ];
		foreach (get_taxonomies() as $value) {
			$instance[ $value ]       = absint( $new_instance[ $value ] );
		}

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		global $post;
		$title            = apply_filters( 'widget_title', isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '');
		$subtitle         = isset( $instance[ 'subtitle' ] ) ? $instance[ 'subtitle' ] : '';
		$source           = isset( $instance[ 'source' ] ) ? $instance[ 'source' ] : '';
		$product_number   = isset( $instance[ 'product_number' ] ) ? $instance[ 'product_number' ] : '';
		$hide_thumbnail_mask = isset( $instance[ 'hide_thumbnail_mask' ] ) ? $instance[ 'hide_thumbnail_mask' ] : 0;
		$term_name         = isset( $instance[ 'term_name' ] ) ? $instance[ 'term_name' ] : '';
		${$term_name}         = isset( $instance[ $term_name ] ) ? $instance[ $term_name ] : '';

		// For Multilingual compatibility
		if ( function_exists( 'icl_register_string' ) ) {
			icl_register_string( 'eStore', 'TG: Product Carousel Subtitle' . $this->id, $subtitle );
		}
		if ( function_exists( 'icl_t' ) ) {
			$subtitle  = icl_t( 'eStore', 'TG: Product Carousel Subtitle'. $this->id, $subtitle );
		}

		$args = array(
			'post_type' => 'product',
			'tax_query' => array(
				array(
					'taxonomy'  => $term_name,
					'field'     => 'id',
					'terms'     => ${$term_name}
				)
			),
			'posts_per_page' => $product_number
		);

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
						$image_url = wp_get_attachment_image_src(get_post_thumbnail_id(),'estore-medium-image111', false); ?>
						<figure class="featured-img">
							<?php if($image_url[0]) { ?>
								<a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>" alt="<?php the_title(); ?>"><img data-src="<?php echo esc_url( $image_url[0] ); ?>" src="<?php echo( get_stylesheet_directory_uri() . '/none.jpg') ?>" alt="<?php the_title_attribute(); ?>"></a>
							<?php } else { ?>
								<a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>" alt="<?php the_title(); ?>"><img data-src="<?php echo estore_woocommerce_placeholder_img_src(); ?>" src="<?php echo( get_stylesheet_directory_uri() . '/none.jpg') ?>" alt="<?php the_title_attribute(); ?>"></a>
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
								<span class="price"><?php echo $price_html; ?></span>
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

// Vertical Promo Widget
class elshaddai_woocommerce_vertical_promo_widget extends WP_Widget {
	function __construct() {
		$widget_ops = array(
					'classname'   => 'widget_vertical_promo collection-wrapper clearfix',
					'description' => esc_html__( 'Display a link in vertical image.', 'elshaddai' ) );
		$control_ops = array(
				'width'  => 200,
				'height' => 250
			);
		parent::__construct( false, $name = esc_html__( 'A-C: Vertical Promo Custom', 'elshaddai' ), $widget_ops, $control_ops);
	}

	function form( $instance ) {

		$defaults[ 'name_image1' ]   = '';
		$defaults[ 'attr_image_url1' ]   = '';
		$defaults[ 'attr_image_link1' ]  = '';
		$defaults[ 'name_image2' ]   = '';
		$defaults[ 'attr_image_url2' ]   = '';
		$defaults[ 'attr_image_link2' ]  = '';

		$instance = wp_parse_args( (array) $instance, $defaults );

		$name_image1 = esc_url( $instance[ 'name_image1' ] );
		$attr_image_url1 = esc_url( $instance[ 'attr_image_url1' ] );
		$attr_image_link1 = esc_url( $instance[ 'attr_image_link1' ] );
		$name_image2 = esc_url( $instance[ 'name_image2' ] );
		$attr_image_url2 = esc_url( $instance[ 'attr_image_url2' ] );
		$attr_image_link2 = esc_url( $instance[ 'attr_image_link2' ] );
		?>
		<label><h3><?php esc_html_e( 'Add your First Image here.', 'estore' ); ?></h3></label>
		<p>
			<label for="<?php echo $this->get_field_id( 'name_image1' ); ?>"> <b> <?php esc_html_e( 'Nome 1', 'estore' ); ?> </b></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'name_image1' ); ?>" name="<?php echo $this->get_field_name( 'name_image1' ); ?>" value="<?php echo $instance[ 'name_image1' ]; ?>"/>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'attr_image_link1' ); ?>"> <?php esc_html_e( 'Link 1', 'estore' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'attr_image_link1' ); ?>" name="<?php echo $this->get_field_name( 'attr_image_link1' ); ?>" value="<?php echo $instance[ 'attr_image_link1' ]; ?>"/>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'attr_image_url1' ); ?>"> <?php esc_html_e( 'Image 1', 'estore' ); ?></label>
			<div class="media-uploader" id="<?php echo $this->get_field_id( 'attr_image_url1' ); ?>">
				<div class="custom_media_preview">
					<?php if ( $instance[ 'attr_image_url1' ] != '' ) : ?>
						<img class="custom_media_preview_default" src="<?php echo esc_url( $instance[ 'attr_image_url1' ] ); ?>" style="max-width:100%;" />
					<?php endif; ?>
				</div>
				<input type="text" class="widefat custom_media_input" id="<?php echo $this->get_field_id( 'attr_image_url1' ); ?>" name="<?php echo $this->get_field_name( 'attr_image_url1' ); ?>" value="<?php echo esc_url( $instance['attr_image_url1'] ); ?>" style="margin-top:5px;" />
				<button class="custom_media_upload button button-secondary button-large" id="<?php echo $this->get_field_id( 'attr_image_url1' ); ?>" data-choose="<?php esc_attr_e( 'Choose an image', 'estore' ); ?>" data-update="<?php esc_attr_e( 'Use image', 'estore' ); ?>" style="width:100%;margin-top:6px;margin-right:30px;"><?php esc_html_e( 'Select an Image', 'estore' ); ?></button>
			</div>
		</p>

			<hr><hr>
		<label><h3><?php esc_html_e( 'Add your Second Image here.', 'estore' ); ?></h3></label>

		<p>
			<label for="<?php echo $this->get_field_id( 'name_image2' ); ?>"> <b> <?php esc_html_e( 'Nome 2', 'estore' ); ?> </b></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'name_image2' ); ?>" name="<?php echo $this->get_field_name( 'name_image2' ); ?>" value="<?php echo $instance[ 'name_image2' ]; ?>"/>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'attr_image_link2' ); ?>"> <?php esc_html_e( 'Link 2', 'elshaddai' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'attr_image_link2' ); ?>" name="<?php echo $this->get_field_name( 'attr_image_link2' ); ?>" value="<?php echo $instance[ 'attr_image_link2' ]; ?>"/>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'attr_image_url2' ); ?>"> <?php esc_html_e( 'Image 1', 'estore' ); ?></label>
			<div class="media-uploader" id="<?php echo $this->get_field_id( 'attr_image_url2' ); ?>">
				<div class="custom_media_preview">
					<?php if ( $instance[ 'attr_image_url2' ] != '' ) : ?>
						<img class="custom_media_preview_default" src="<?php echo esc_url( $instance[ 'attr_image_url2' ] ); ?>" style="max-width:100%;" />
					<?php endif; ?>
				</div>
				<input type="text" class="widefat custom_media_input" id="<?php echo $this->get_field_id( 'attr_image_url2' ); ?>" name="<?php echo $this->get_field_name( 'attr_image_url2' ); ?>" value="<?php echo esc_url( $instance['attr_image_url2'] ); ?>" style="margin-top:5px;" />
				<button class="custom_media_upload button button-secondary button-large" id="<?php echo $this->get_field_id( 'attr_image_url2' ); ?>" data-choose="<?php esc_attr_e( 'Choose an image', 'estore' ); ?>" data-update="<?php esc_attr_e( 'Use image', 'estore' ); ?>" style="width:100%;margin-top:6px;margin-right:30px;"><?php esc_html_e( 'Select an Image', 'estore' ); ?></button>
			</div>
		</p>



		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance[ 'name_image1' ] = sanitize_text_field( $new_instance[ 'name_image1' ]);
		$instance[ 'attr_image_url1' ] = esc_url_raw( $new_instance[ 'attr_image_url1' ] );
		$instance[ 'attr_image_link1' ]  = esc_url_raw( $new_instance[ 'attr_image_link1' ] );

		$instance[ 'name_image2' ] = sanitize_text_field($new_instance[ 'name_image2' ]);
		$instance[ 'attr_image_url2' ] = esc_url_raw( $new_instance[ 'attr_image_url2' ] );
		$instance[ 'attr_image_link2' ]  = esc_url_raw( $new_instance[ 'attr_image_link2' ] );

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		global $post;

		$name_image1   = isset( $instance[ 'name_image1' ] ) ? $instance[ 'name_image1' ] : '';
		$attr_image_url1   = isset( $instance[ 'attr_image_url1' ] ) ? $instance[ 'attr_image_url1' ] : '';
		$attr_image_link1    = isset( $instance[ 'attr_image_link1' ] ) ? $instance[ 'attr_image_link1' ] : '';
		$name_image2  = isset( $instance[ 'name_image2' ] ) ? $instance[ 'name_image2' ] : '';
		$attr_image_url2   = isset( $instance[ 'attr_image_url2' ] ) ? $instance[ 'attr_image_url2' ] : '';
		$attr_image_link2    = isset( $instance[ 'attr_image_link2' ] ) ? $instance[ 'attr_image_link2' ] : '';

		echo $before_widget; ?>
			<?php

				?>
				<div class="collection-block"><a href="<?php echo esc_url( $attr_image_link1 ); ?>" target="_blank">
					<figure class="slider-collection-img">
					<?php
					if ( $attr_image_url1  ) {
						echo '<img src="' . esc_url( $attr_image_url1  ) . '" alt="" />';
					}
					// @todo: Default Place holder image needed
					?>
					</figure>
					<h3 class="slider-title"><?php echo esc_html( $name_image1 ); ?></h3></a>
				</div>

				<div class="collection-block"><a href="<?php echo esc_url( $attr_image_link2 ); ?>" target="_blank">
					<figure class="slider-collection-img">
					<?php
					if ( $attr_image_url2  ) {
						echo '<img src="' . esc_url( $attr_image_url2  ) . '" alt="" />';
					}
					// @todo: Default Place holder image needed
					?>
					</figure>
					<h3 class="slider-title"><?php echo esc_html( $name_image2 ); ?></h3></a>
				</div>
			<?php
		echo $after_widget;
	}
}

// Elshaddai banner com imagem
class elshaddai_banner_img extends WP_Widget {
	function __construct() {
		$widget_ops = array(
					'classname'   => 'banner collection-wrapper clearfix',
					'description' => esc_html__( 'Display a responsive banner.', 'elshaddai' ) );
		$control_ops = array(
				'width'  => 200,
				'height' => 250
			);
		parent::__construct( false, $name = esc_html__( 'A-C: banner', 'elshaddai' ), $widget_ops, $control_ops);
	}

	function form( $instance ) {

		$defaults[ 'attr_link1' ]   = '';
		$defaults[ 'attr_image_1' ]  = '';
		$defaults[ 'attr_image_2' ]  = '';
		$defaults[ 'lazy' ]  = '';
		$defaults[ 'bg_color' ]  = '';

		$instance = wp_parse_args( (array) $instance, $defaults );

		$attr_link1 = esc_url( $instance[ 'attr_link1' ] );
		$attr_image_1 = esc_url( $instance[ 'attr_image_1' ] );
		$attr_image_2 = esc_url( $instance[ 'attr_image_2' ] );
		$lazy = $instance[ 'lazy' ];
		$bg_color = $instance[ 'bg_color' ];
		?>
		<label><h3><?php esc_html_e( 'Add your First Image here.', 'estore' ); ?></h3></label>
		<p>
			<label for="<?php echo $this->get_field_id( 'lazy' ); ?>"> <?php esc_html_e( 'Carregamento tardío', 'elshaddai' ); ?></label>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'lazy' ); ?>" name="<?php echo $this->get_field_name( 'lazy' ); ?>" <?php checked( $instance[ 'lazy' ], 'on' ); ?>/>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'bg_color' ); ?>"> <?php esc_html_e( 'Cor do Background', 'estore' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'bg_color' ); ?>" name="<?php echo $this->get_field_name( 'bg_color' ); ?>" value="<?php echo $instance[ 'bg_color' ]; ?>"/>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'attr_link1' ); ?>"> <?php esc_html_e( 'Link', 'estore' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'attr_link1' ); ?>" name="<?php echo $this->get_field_name( 'attr_link1' ); ?>" value="<?php echo $instance[ 'attr_link1' ]; ?>"/>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'attr_image_1' ); ?>"> <?php esc_html_e( 'Image full', 'estore' ); ?></label>
			<div class="media-uploader" id="<?php echo $this->get_field_id( 'attr_image_1' ); ?>">
				<div class="custom_media_preview">
					<?php if ( $instance[ 'attr_image_1' ] != '' ) : ?>
						<img class="custom_media_preview_default" src="<?php echo esc_url( $instance[ 'attr_image_1' ] ); ?>" style="max-width:100%;" />
					<?php endif; ?>
				</div>
				<input type="text" class="widefat custom_media_input" id="<?php echo $this->get_field_id( 'attr_image_1' ); ?>" name="<?php echo $this->get_field_name( 'attr_image_1' ); ?>" value="<?php echo esc_url( $instance['attr_image_1'] ); ?>" style="margin-top:5px;" />
				<button class="custom_media_upload button button-secondary button-large" id="<?php echo $this->get_field_id( 'attr_image_1' ); ?>" data-choose="<?php esc_attr_e( 'Choose an image', 'estore' ); ?>" data-update="<?php esc_attr_e( 'Use image', 'estore' ); ?>" style="width:100%;margin-top:6px;margin-right:30px;"><?php esc_html_e( 'Select Full Banner', 'estore' ); ?></button>
			</div>
		</p>
		<hr>
		<p>
			<label for="<?php echo $this->get_field_id( 'attr_image_2' ); ?>"> <?php esc_html_e( 'Image mobile', 'estore' ); ?></label>
			<div class="media-uploader" id="<?php echo $this->get_field_id( 'attr_image_2' ); ?>">
				<div class="custom_media_preview">
					<?php if ( $instance[ 'attr_image_2' ] != '' ) : ?>
						<img class="custom_media_preview_default" src="<?php echo esc_url( $instance[ 'attr_image_2' ] ); ?>" style="max-width:100%;" />
					<?php endif; ?>
				</div>
				<input type="text" class="widefat custom_media_input" id="<?php echo $this->get_field_id( 'attr_image_2' ); ?>" name="<?php echo $this->get_field_name( 'attr_image_2' ); ?>" value="<?php echo esc_url( $instance['attr_image_2'] ); ?>" style="margin-top:5px;" />
				<button class="custom_media_upload button button-secondary button-large" id="<?php echo $this->get_field_id( 'attr_image_2' ); ?>" data-choose="<?php esc_attr_e( 'Choose an image', 'estore' ); ?>" data-update="<?php esc_attr_e( 'Use image', 'estore' ); ?>" style="width:100%;margin-top:6px;margin-right:30px;"><?php esc_html_e( 'Select Mobile Banner', 'estore' ); ?></button>
			</div>
		</p>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance[ 'attr_link1' ] = esc_url_raw( $new_instance[ 'attr_link1' ]);
		$instance[ 'attr_image_1' ] = esc_url_raw( $new_instance[ 'attr_image_1' ] );
		$instance[ 'attr_image_2' ]  = esc_url_raw( $new_instance[ 'attr_image_2' ] );
		$instance[ 'lazy' ]  = $new_instance[ 'lazy' ];
		$instance[ 'bg_color' ]  = $new_instance[ 'bg_color' ];

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		global $post;

		$attr_link1   = isset( $instance[ 'attr_link1' ] ) ? $instance[ 'attr_link1' ] : '';
		$attr_image_1   = isset( $instance[ 'attr_image_1' ] ) ? $instance[ 'attr_image_1' ] : '';
		$attr_image_2    = isset( $instance[ 'attr_image_2' ] ) ? $instance[ 'attr_image_2' ] : '';
		$bg_color    = isset( $instance[ 'bg_color' ] ) ? $instance[ 'bg_color' ] : '';
		$lazy    = $instance[ 'lazy' ]? 'true' : 'false';

		$img_Pathern = get_stylesheet_directory_uri() . '/none.jpg';
		echo $before_widget; ?>
			<?php

				?>
				<div class="collection-block banner-adaptive">
					<a href="<?php echo esc_url( $attr_link1 ); ?>" target="_blank">
					<figure class="banner-adaptive-img" style="background:<?=$bg_color?>;">
					<?php
					if(!$lazy){
						?>
						<picture>
						  <source media="(min-width: 600px)" srcset="<?=esc_url( $attr_image_1)?>">
						  <img src="<?=esc_url( $attr_image_2 )?>" alt="Flowers" style="width:auto;">
						</picture>
						<?php
					}else{
						if ( $attr_image_1 and $attr_image_2 ) {
							echo '<img src="" full-src="' . esc_url( $attr_image_1  ) . '"  mobile-src="'. esc_url( $attr_image_2 ) . '" alt="" class="Normal-Ban" />';
					}}
					?>
					</figure>
				</a>
				</div>

			<?php
		echo $after_widget;
	}
}
