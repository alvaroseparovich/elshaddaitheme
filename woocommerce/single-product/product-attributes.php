<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$has_row    = false;
$alt        = 1;
$attributes = $product->get_attributes();

ob_start();

?>
<table class="shop_attributes">

	<?php if ( $product->enable_dimensions_display() ) : ?>

		<?php if ( $product->has_weight() ) : $has_row = true; ?>
			<tr class="<?php if ( ( $alt = $alt * -1 ) === 1 ) echo 'alt'; ?>">
				<th><?php _e( 'Weight', 'woocommerce' ) ?></th>
				<td class="product_weight"><?php echo wc_format_localized_decimal( $product->get_weight() ) . ' ' . esc_attr( get_option( 'woocommerce_weight_unit' ) ); ?></td>
			</tr>
		<?php endif; ?>

		<?php if ( $product->has_dimensions() ) : $has_row = true; ?>
			<tr class="<?php if ( ( $alt = $alt * -1 ) === 1 ) echo 'alt'; ?>">
				<th><?php _e( 'Dimensions', 'woocommerce' ) ?></th>
				<td class="product_dimensions"><?php echo $product->get_dimensions(); ?></td>
			</tr>
		<?php endif; ?>

	<?php endif; ?>

	<?php foreach ( $attributes as $attribute ) :
		if ( empty( $attribute['is_visible'] ) || ( $attribute['is_taxonomy'] && ! taxonomy_exists( $attribute['name'] ) ) ) {
			continue;
		} else {
			$has_row = true;
		}
		?>
		<tr class="<?php if ( ( $alt = $alt * -1 ) == 1 ) echo 'alt'; ?>">
			<th><?php echo wc_attribute_label( $attribute['name'] ); ?></th>
			<td><?php
				if ( $attribute['is_taxonomy'] ) {
					//COLOCO O LINK PARA A PAGINA DO AUTOR E DA EDITORA
					if(wc_attribute_label( $attribute['name'] ) == 'Autor'){
						//CAPTURA TODAS AS INFORMAÇÔES NECESSARIAS
						$url = site_url();
						$term =  wp_get_post_terms( $product->id, $attribute['name'], 'all' );
						$nome = wc_get_attribute_taxonomies();
						

						$values = wc_get_product_terms( $product->id, $attribute['name'], array( 'fields' => 'names' ) );
						foreach ($values as $key => $i) {
							//LAÇO PARA QUE CADA AUTOR FIQUE COM SEU LINK
							$slug = $term[$key]->slug;

							echo "<a href='$url/autor/$slug'>$i</a>";
							$slugKey = $key + 1;
							if (isset($term[$slugKey])) {
								echo ', ';
							}

						}

					}elseif(wc_attribute_label( $attribute['name'] ) == 'Editora'){
						//CAPTURA TODAS AS INFORMAÇÔES NECESSARIAS
						$url = site_url();
						$term =  wp_get_post_terms( $product->id, $attribute['name'], 'all' );
						$nome = wc_get_attribute_taxonomies();
						

						$values = wc_get_product_terms( $product->id, $attribute['name'], array( 'fields' => 'names' ) );
						foreach ($values as $key => $i) {
							//LAÇO PARA QUE CADA AUTOR FIQUE COM SEU LINK
							$slug = $term[$key]->slug;

							echo "<a href='$url/editora/$slug'>$i</a>";
							$slugKey = $key + 1;
							if (isset($term[$slugKey])) {
								echo ', ';
							}
						}

					}else{

						$values = wc_get_product_terms( $product->id, $attribute['name'], array( 'fields' => 'names' ) );
						echo apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );

					}

				} else {

					// Convert pipes to commas and display values
					$values = array_map( 'trim', explode( WC_DELIMITER, $attribute['value'] ) );
					echo apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );

				}
			?></td>
		</tr>
	<?php endforeach; ?>

</table>
<?php
if ( $has_row ) {
	echo ob_get_clean();
} else {
	ob_end_clean();
}
