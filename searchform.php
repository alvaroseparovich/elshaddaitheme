<?php
/**
 * The template for displaying search forms in estore.
 *
 * @package ThemeGrill
 * @subpackage estore
 * @since estore 1.0
 */
?>
<form role="search" method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="search" class="search-field" placeholder="Procurar Livro / Autor" value="<?php echo esc_attr( get_search_query() ); ?>" name="s">
	<button type="submit" class="searchsubmit" name="post_type" value="product"><i class="fa fa-search"></i></button>
</form>
