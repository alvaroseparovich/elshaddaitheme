<?php 

add_action( 'widgets_init', 'autor_editora' );

function autor_editora() {
	// Widgets Registration
	register_widget( "editora_autor_especial_widget_elshaddai" );
}

class editora_autor_especial_widget_elshaddai extends WP_Widget {
	function __construct() {
		$widget_ops = array(
			'classname'   => 'autor-editora-widget',
			'description' => esc_html__( 'widget especial para pagina de Editora e Autores', 'elshaddai-estore-child' )
		);
		$control_ops = array(
			'width'  => 200,
			'height' => 250
		);
		parent::__construct( false, $name = esc_html__( 'AA: Autor Editora', 'el-shaddai' ), $widget_ops, $control_ops);
	}

	function form( $instance ) {
		$defaults[ 'title' ]            = '';
		$defaults[ 'number_of_names' ]         = '';

		$instance = wp_parse_args( (array) $instance, $defaults );

		$title            = esc_attr( $instance[ 'title' ] );
		$number_of_names  = esc_attr( $instance[ 'number_of_names' ] );
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'estore' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'number_of_names' ); ?>"><?php esc_html_e( 'Limite de nomes:', 'estore' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'number_of_names' ); ?>" name="<?php echo $this->get_field_name( 'number_of_names' ); ?>" type="text" value="<?php echo $number_of_names; ?>" />
		</p>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance[ 'title' ]          = sanitize_text_field( $new_instance[ 'title' ] );
		$instance['number_of_names']  = sanitize_text_field( $new_instance[ 'number_of_names' ] );

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		global $post;
		$title            = apply_filters( 'widget_title', isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '');
		$number_of_names  = apply_filters( 'number_of_names', isset( $instance[ 'number_of_names' ] ) ? $instance[ 'number_of_names' ] : '');

		echo $before_widget;
		?>
		<div class="tg-container estore-cat-color_">
		
			<h3 class="widget-title"><span><?php if($title){echo $title;}else{echo 'Autor da Editora';} ?></span></h3>
		
			<?php

				$url_arr = explode( "/" , substr($_SERVER['REQUEST_URI'] , 1 , -1 ) ) ;

				// Here define the product category SLUG
				$editora = array(
					'post_type' => 'product',
					'orderby'   => 'date',
					'tax_query' => array(
						'taxonomy'  => 'pa_autor',
						'field'     => 'id',
						'terms'     => $url_arr[1],
					)
				);

				$list_of_autors = array();

				foreach( wc_get_products($editora) as $products_of_editora ){

					foreach ( $products_of_editora->get_attributes()["pa_autor"]->get_terms() as $autor ){
						$list_of_autors[$autor->term_id] = array($autor->name, get_term_link($autor, "pa_autor"), $autor->count);
					}
				}
				?>
				<ul class="autores-da-editora">
					<?php 
					
					$i = 0;

					foreach($list_of_autors as $autor){

						if ($i >= $number_of_names ){ 

							echo'<li class="autor-limit"style="display:none;"><a href="' . $autor[1] . '" rel="noopener noreferrer">' . $autor[0] . ' (' . $autor[2] . ')</a></li>';

						}else{

							echo'<li><a href="' . $autor[1] . '" rel="noopener noreferrer">' . $autor[0] . ' (' . $autor[2] . ')</a></li>';	

						}
						$i++;
						if( $i == sizeof($list_of_autors) ){echo '<button id="btn-show-hide-autor" onclick="autores_show_hide()">Mastrar mais</button>';}
					}

					?>
				</ul>
				<script>
					function atualizaButton(key,arr,text){

						if(arr.length == key+1){
							document.querySelector("#btn-show-hide-autor").innerText = text;
						}
					}
					
					function changeStyle(element , key, arr) {
						
						if( element.style.display == 'none' ){

							element.style.display = 'list-item';
							atualizaButton(key,arr,"Mostrar menos");

						}else{
							
							element.style.display = 'none';
							atualizaButton(key,arr,"Mostrar mais");
							
							}
						}

						function autores_show_hide(){
							nodeList = document.querySelectorAll(".autor-limit");
							autoresList = Array.prototype.slice.call(nodeList);
							autoresList.forEach(changeStyle);
						}
				</script>
				<?php
			
			$featured_query = new WP_Query( $args );

			wp_reset_postdata();
			?>
			</div><!-- collection-block-wrapper tg-column-wrapper clearfix -->
			</div>
		<?php
		echo $after_widget;
    }
}
