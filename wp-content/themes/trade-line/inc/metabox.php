<?php
/**
 * Implement theme metabox.
 *
 * @package Trade_Line
 */

if ( ! function_exists( 'trade_line_add_theme_meta_box' ) ) :

	/**
	 * Add the Meta Box
	 *
	 * @since 1.0.0
	 */
	function trade_line_add_theme_meta_box() {

		$apply_metabox_post_types = array( 'post', 'page' );

		foreach ( $apply_metabox_post_types as $key => $type ) {
			add_meta_box(
				'theme-settings',
				esc_html__( 'Theme Settings', 'trade-line' ),
				'trade_line_render_theme_settings_metabox',
				$type
			);
		}

	}

endif;

//add_action( 'add_meta_boxes', 'trade_line_add_theme_meta_box' );

if ( ! function_exists( 'trade_line_render_theme_settings_metabox' ) ) :

	/**
	 * Render theme settings meta box.
	 *
	 * @since 1.0.0
	 */
	function trade_line_render_theme_settings_metabox() {

		global $post;
		$post_id = $post->ID;

		// Meta box nonce for verification.
		wp_nonce_field( basename( __FILE__ ), 'trade_line_theme_settings_meta_box_nonce' );

		// Fetch Options list.
		$global_layout_options   = trade_line_get_global_layout_options();
		$image_size_options      = trade_line_get_image_sizes_options( true, array( 'disable', 'large' ), false );

		// Fetch values of current post meta.
		$values = get_post_meta( $post_id, 'theme_settings', true );
		$theme_settings_post_layout = isset( $values['post_layout'] ) ? esc_attr( $values['post_layout'] ) : '';
		$theme_settings_single_image = isset( $values['single_image'] ) ? esc_attr( $values['single_image'] ) : '';

	?>
    <!-- Layout option -->
    <p><strong><?php echo esc_html__( 'Choose Layout', 'trade-line' ); ?></strong></p>
    <select name="theme_settings[post_layout]" id="theme_settings_post_layout">
      <option value=""><?php echo esc_html__( 'Default', 'trade-line' ); ?></option>
		<?php if ( ! empty( $global_layout_options ) ) :  ?>
        <?php foreach ( $global_layout_options as $key => $val ) :  ?>

          <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $theme_settings_post_layout, $key ); ?> ><?php echo esc_html( $val ); ?></option>

        <?php endforeach ?>
		<?php endif ?>
    </select>
    <!-- Image in single post/page -->
    <p><strong><?php echo esc_html__( 'Choose Image Size in Single Post/Page', 'trade-line' ); ?></strong></p>
    <select name="theme_settings[single_image]" id="theme_settings_single_image">
      <option value=""><?php echo esc_html__( 'Default', 'trade-line' ); ?></option>
		<?php if ( ! empty( $image_size_options ) ) :  ?>
        <?php foreach ( $image_size_options as $key => $val ) :  ?>

          <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $theme_settings_single_image, $key ); ?> ><?php echo esc_html( $val ); ?></option>

        <?php endforeach ?>
		<?php endif ?>
    </select>
    <?php
	}

endif;



if ( ! function_exists( 'trade_line_save_theme_settings_meta' ) ) :

	/**
	 * Save theme settings meta box value.
	 *
	 * @since 1.0.0
	 *
	 * @param int     $post_id Post ID.
	 * @param WP_Post $post Post object.
	 */
	function trade_line_save_theme_settings_meta( $post_id, $post ) {

		// Verify nonce.
		if ( ! isset( $_POST['trade_line_theme_settings_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['trade_line_theme_settings_meta_box_nonce'], basename( __FILE__ ) ) ) {
			  return;
		}

		// Bail if auto save or revision.
		if ( defined( 'DOING_AUTOSAVE' ) || is_int( wp_is_post_revision( $post ) ) || is_int( wp_is_post_autosave( $post ) ) ) {
			return;
		}

		// Check the post being saved == the $post_id to prevent triggering this call for other save_post events.
		if ( empty( $_POST['post_ID'] ) || $_POST['post_ID'] != $post_id ) {
			return;
		}

		// Check permission.
		if ( 'page' === $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}
		} else if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		if ( ! array_filter( $_POST['theme_settings'] ) ) {
			// No value.
			delete_post_meta( $post_id, 'theme_settings' );
		} else {
			$meta_fields = array(
				'post_layout' => array(
					'type' => 'select',
					),
				'single_image' => array(
					'type' => 'select',
					),
				);

			$sanitized_values = array();
			foreach ( $_POST['theme_settings'] as $mk => $mv ) {

				if ( isset( $meta_fields[ $mk ]['type'] ) ) {
					switch ( $meta_fields[ $mk ]['type'] ) {
						case 'select':
							$sanitized_values[ $mk ] = esc_attr( $mv );
							break;
						case 'checkbox':
							$sanitized_values[ $mk ] = absint( $mv ) > 0 ? 1 : 0;
							break;
						default:
							$sanitized_values[ $mk ] = esc_attr( $mv );
							break;
					}
				} // End if.

			}
			update_post_meta( $post_id, 'theme_settings', $sanitized_values );

		}

	}

endif;

add_action( 'save_post', 'trade_line_save_theme_settings_meta', 10, 3 );
