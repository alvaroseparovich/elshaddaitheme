<?php

function autor_widgets_start() {
	register_widget( "Autor_Search_Widget" );
}
add_action( 'widgets_init', 'autor_widgets_start' );


class Autor_Search_Widget extends WP_Widget {
    function __construct() {
        parent::__construct(

            /*Base ID of your widget*/
            'autor_product_search',

            /*Widget name will appear in UI*/
            esc_html__('Autor Product Search', 'autor'),

            /*Widget description*/
            array( 'description' => esc_html__( 'Search only on products', 'autor' ), )

        );
    }

    /*defaults values for fields*/
    private $defaults = array(
        'autor_search_placeholder'  => ''
    );

    //===================================
    function search_widget_form( $args , $start_num=0 , $placeholder="Procure o livro ou autor..." ){

        $url_arr = explode( "/" , substr($_SERVER['REQUEST_URI'] , 1 , -1 ) ) ;

        if( $url_arr[$start_num] == 'editora') {

            $elements = '<div id="button-return-editora"></div>';
            $elements =  $args['before_widget'];
            $elements .= '<div class="search-block"><form role="search" method="get" class="searchform" action="' . esc_url( home_url( '/'.$url_arr[$start_num].'/'.$url_arr[ $start_num + 1 ].'/' ) ) . '">';
            $elements .= '<input  id="menu-search" type="search" class="search-field basileia-search" placeholder="'.$placeholder.'" value="'.esc_attr( get_search_query()).'" name="s"><button id="searchsubmit" type="submit" class="fa fa-search" name="post_type" value="product"></button></form></div>';
            $elements .= $args['after_widget'];
            
            return $elements;

        }else{

            //Retornar para a editora
            $button_return = '<div id="button-return-editora"></div>';

            return $button_return;
        }
    }

    public function form( $instance ) {
        /*merging arrays*/
        $instance = wp_parse_args( (array) $instance, $this->defaults);
        $autor_search_placeholder = esc_attr( $instance['autor_search_placeholder'] );
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'autor_search_placeholder' ) ); ?>"><?php esc_html_e( 'Placeholder Text', 'online-shop' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'autor_search_placeholder' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'autor_search_placeholder' ) ); ?>" type="text" value="<?php echo esc_attr( $autor_search_placeholder ); ?>" />
        </p>
        <?php
    }


    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['autor_search_placeholder'] = ( isset( $new_instance['autor_search_placeholder'] ) ) ?  sanitize_text_field( $new_instance['autor_search_placeholder'] ): '';

        return $instance;
    }


    function widget( $args, $instance ) {

        $instance = wp_parse_args( (array) $instance, $this->defaults);
        global $autor_search_placeholder;
        $autor_search_placeholder = esc_attr( $instance['autor_search_placeholder'] );
        $url_arr = explode( "/" , substr($_SERVER['REQUEST_URI'] , 1 , -1 ) ) ;

        if($url_arr[0] == "wordpress"){

            echo $this->search_widget_form( $args, $start_num = 1 );

        }else{

            echo $this->search_widget_form($args);

        }
    }
}

