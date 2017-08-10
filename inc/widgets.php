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
	/*register_widget( "estore_child_product_slider_ban_atr_widget" );*/
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



<<<<<<< HEAD

/**
 * Contains all the functions related to sidebar and widget.
 *
 * @package ThemeGrill
 * @subpackage estore
 * @since estore 1.0
 */

add_action( 'widgets_init', 'estore_child_widgets_attr_init' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function estore_child_widgets_attr_init() {

	// Widgets Registration
	register_widget( "estore_child_product_slider_ban_attr_widget" );
}

=======
>>>>>>> 58c8d611e588c167f1eb7882fba09ac939bd1682
// Featured Category Product Slider Widget
class estore_child_product_slider_ban_attr_widget extends WP_Widget {

	function __construct() {
		$widget_ops = array(
			'classname'   => 'slider_wrapper category-slider clearfix product-ban',
			'description' => esc_html__( 'Display latest product or products of specific attribute, which will be used as the slider.', 'estore' ) );

		$control_ops = array(
			'width'  => 200,
			'height' => 250
		);

		parent::__construct( false,$name= esc_html__( 'TG-Child: Product Attr Slider', 'estore' ), $widget_ops);
	}

	function form( $instance ) {
		$tg_defaults['number']   = 4;
		$tg_defaults['type']     = 'latest';
		$tg_defaults['attribute'] = '';

		$instance = wp_parse_args( (array) $instance, $tg_defaults );

		$number   = $instance['number'];
		$type     = $instance['type'];
		$attribute = absint( $instance[ 'attribute' ] );
	?>

	<p>
		<label for="<?php echo $this->get_field_id('number'); ?>"><?php esc_html_e( 'Number of posts to display:', 'estore' ); ?></label>
		<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" />
	</p>

	<p>
		<input type="radio" <?php checked($type, 'latest') ?> id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" value="latest"/><?php esc_html_e( 'Show latest Posts', 'estore' );?><br />
		<input type="radio" <?php checked($type,'attribute') ?> id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" value="attribute"/><?php esc_html_e( 'Show posts from a attribute', 'estore' );?><br />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'attribute' ); ?>"><?php esc_html_e( 'Select attribute', 'estore' ); ?>:</label>
		<?php
		wp_dropdown_categories(
			array(
				'show_option_none' =>' ',
				'name'             => $this->get_field_name( 'attribute' ),
				'selected'         => $instance['attribute'],
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
		$instance[ 'attribute' ] = absint( $new_instance[ 'attribute' ] );

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		global $post;
		$number   = empty( $instance[ 'number' ] ) ? 4 : $instance[ 'number' ];
		$type     = isset( $instance[ 'type' ] ) ? $instance[ 'type' ] : 'latest' ;
		$attribute = isset( $instance[ 'attribute' ] ) ? $instance[ 'attribute' ] : '';

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
						'taxonomy'  => 'pa_autor',
						'field'     => 'id',
						'terms'     => $attribute
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
					<?php
						the_post_thumbnail($post->ID, 'estore-slider') ?> 
				</div> 
					<?php
				the_post_thumbnail( $post->ID, 'estore-slider', array( 'title' => esc_attr( $title_attribute ), 'alt' => esc_attr( $title_attribute ) ) );
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







