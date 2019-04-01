<?php

// Add term page
function add_meta_field() {
    // this will add the custom field to the add new term page
    ?>
    <div class="form-field">
        <label for="tag-description">Widget special area</label>
        <input type="text" name="term_meta[description_el]" id="term_meta[description_el]" value="" class="regular-text" /><br>
        <p>Put here what you want to show after the header.</p>
    </div>
    <?php
}
add_action( 'pa_editora_add_form_fields', 'add_meta_field', 10, 2 );
add_action( 'product_cat_add_form_fields', 'add_meta_field', 10, 2 );



// Edit term page
function edit_meta_field($term) {
	
	// put the term ID into a variable
	$t_id = $term->term_id;
	// retrieve the existing value(s) for this img field. This returns an array
	$term_meta = get_option( "taxonomy_term_{$t_id}" );

    ?>
	<tr class="form-field">
    <th>Widget special area</th>
		<td>
            <textarea type="text" name="term_meta[description_el]" id="term_meta[description_el]" value="" class="regular-text caixa_com_texto"> <?php echo esc_attr( $term_meta['description_el'] ); ?> </textarea>
		<br>
		<p class="description">Put here what you want to show after the header.</p>
		</td>
	</tr>

<?php
}

add_action( 'pa_editora_edit_form_fields', 'edit_meta_field', 10, 2 );
add_action( 'product_cat_edit_form_fields', 'edit_meta_field', 10, 2 );

// Save extra taxonomy img callback function.
function save_field_meta( $term_id ) {
	if ( isset( $_POST['term_meta'] ) ) {
		$t_id = $term_id;
		$term_meta = get_option( "taxonomy_term_$t_id" );
		$cat_keys = array_keys( $_POST['term_meta'] );
		foreach ( $cat_keys as $key ) {
			if ( isset ( $_POST['term_meta'][$key] ) ) {
				$term_meta[$key] = $_POST['term_meta'][$key];
			}
		}
		// Save the option array.
		update_option( "taxonomy_term_$t_id", $term_meta );
	}
}  
add_action( 'edited_pa_editora', 'save_field_meta', 10, 2 );  
add_action( 'create_pa_editora', 'save_field_meta', 10, 2 );
add_action( 'edited_product_cat', 'save_field_meta', 10, 2 );  
add_action( 'create_product_cat', 'save_field_meta', 10, 2 );