<?php
/**
 * Template Name: eStore Elshaddai nicho 1
 *
 */

get_header(); ?>

	<div id="content" class="clearfix nicho">

	<section id="top_slider_section" class="clearfix">
		<div class="tg-container">
			<div class="big-slider">
			<?php
				if( is_active_sidebar( 'elshaddai_nicho_1_banner_principal' ) ) {
					if ( !dynamic_sidebar( 'elshaddai_nicho_1_banner_principal' ) ):
					endif;
				}
			?>
			</div>

			<div class="small-slider-wrapper">
			<?php
				if( is_active_sidebar( 'elshaddai_nicho_1_lateral_do_banner' ) ) {
					if ( !dynamic_sidebar( 'elshaddai_nicho_1_lateral_do_banner' ) ):
					endif;
				}
			?>
			</div>
		</div>
	</section>

	<?php
	if( is_active_sidebar( 'elshaddai_nicho_1_corpo_da_pagina' ) ) {
		if ( !dynamic_sidebar( 'elshaddai_nicho_1_corpo_da_pagina' ) ):
			endif;
	}
	?>

	</div>

<?php get_footer(); ?>
