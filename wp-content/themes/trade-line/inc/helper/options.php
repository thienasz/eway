<?php
/**
 * Helper functions related to customizer and options.
 *
 * @package Trade_Line
 */

if ( ! function_exists( 'trade_line_get_global_layout_options' ) ) :

	/**
	 * Returns global layout options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Options array.
	 */
	function trade_line_get_global_layout_options() {

		$choices = array(
			'left-sidebar'  => esc_html__( 'Primary Sidebar - Content', 'trade-line' ),
			'right-sidebar' => esc_html__( 'Content - Primary Sidebar', 'trade-line' ),
			'three-columns' => esc_html__( 'Three Columns', 'trade-line' ),
			'no-sidebar'    => esc_html__( 'No Sidebar', 'trade-line' ),
		);
		$output = apply_filters( 'trade_line_filter_layout_options', $choices );
		return $output;

	}

endif;

if ( ! function_exists( 'trade_line_get_pagination_type_options' ) ) :

	/**
	 * Returns pagination type options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Options array.
	 */
	function trade_line_get_pagination_type_options() {

		$choices = array(
			'default' => esc_html__( 'Default (Older / Newer Post)', 'trade-line' ),
			'numeric' => esc_html__( 'Numeric', 'trade-line' ),
		);
		return $choices;

	}

endif;

if ( ! function_exists( 'trade_line_get_breadcrumb_type_options' ) ) :

	/**
	 * Returns breadcrumb type options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Options array.
	 */
	function trade_line_get_breadcrumb_type_options() {

		$choices = array(
			'disabled' => esc_html__( 'Disabled', 'trade-line' ),
			'simple'   => esc_html__( 'Simple', 'trade-line' ),
			'advanced' => esc_html__( 'Advanced', 'trade-line' ),
		);
		return $choices;

	}

endif;


if ( ! function_exists( 'trade_line_get_archive_layout_options' ) ) :

	/**
	 * Returns archive layout options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Options array.
	 */
	function trade_line_get_archive_layout_options() {

		$choices = array(
			'full'    => esc_html__( 'Full Post', 'trade-line' ),
			'excerpt' => esc_html__( 'Post Excerpt', 'trade-line' ),
		);
		$output = apply_filters( 'trade_line_filter_archive_layout_options', $choices );
		if ( ! empty( $output ) ) {
			ksort( $output );
		}
		return $output;

	}

endif;

if ( ! function_exists( 'trade_line_get_image_sizes_options' ) ) :

	/**
	 * Returns image sizes options.
	 *
	 * @since 1.0.0
	 *
	 * @param bool  $add_disable True for adding No Image option.
	 * @param array $allowed Allowed image size options.
	 * @return array Image size options.
	 */
	function trade_line_get_image_sizes_options( $add_disable = true, $allowed = array(), $show_dimension = true ) {

		global $_wp_additional_image_sizes;
		$get_intermediate_image_sizes = get_intermediate_image_sizes();
		$choices = array();
		if ( true === $add_disable ) {
			$choices['disable'] = esc_html__( 'No Image', 'trade-line' );
		}
		$choices['thumbnail'] = esc_html__( 'Thumbnail', 'trade-line' );
		$choices['medium']    = esc_html__( 'Medium', 'trade-line' );
		$choices['large']     = esc_html__( 'Large', 'trade-line' );
		$choices['full']      = esc_html__( 'Full (original)', 'trade-line' );

		if ( true === $show_dimension ) {
			foreach ( array( 'thumbnail', 'medium', 'large' ) as $key => $_size ) {
				$choices[ $_size ] = $choices[ $_size ] . ' (' . get_option( $_size . '_size_w' ) . 'x' . get_option( $_size . '_size_h' ) . ')';
			}
		}

		if ( ! empty( $_wp_additional_image_sizes ) && is_array( $_wp_additional_image_sizes ) ) {
			foreach ( $_wp_additional_image_sizes as $key => $size ) {
				$choices[ $key ] = $key;
				if ( true === $show_dimension ){
					$choices[ $key ] .= ' ('. $size['width'] . 'x' . $size['height'] . ')';
				}
			}
		}

		if ( ! empty( $allowed ) ) {
			foreach ( $choices as $key => $value ) {
				if ( ! in_array( $key, $allowed ) ) {
					unset( $choices[ $key ] );
				}
			}
		}

		return $choices;

	}

endif;


if ( ! function_exists( 'trade_line_get_image_alignment_options' ) ) :

	/**
	 * Returns image options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Options array.
	 */
	function trade_line_get_image_alignment_options() {

		$choices = array(
			'none'   => _x( 'None', 'Alignment', 'trade-line' ),
			'left'   => _x( 'Left', 'Alignment', 'trade-line' ),
			'center' => _x( 'Center', 'Alignment', 'trade-line' ),
			'right'  => _x( 'Right', 'Alignment', 'trade-line' ),
		);
		return $choices;

	}

endif;

if ( ! function_exists( 'trade_line_get_featured_slider_transition_effects' ) ) :

	/**
	 * Returns the featured slider transition effects.
	 *
	 * @since 1.0.0
	 *
	 * @return array Options array.
	 */
	function trade_line_get_featured_slider_transition_effects() {

		$choices = array(
			'fade'       => _x( 'fade', 'Transition Effect', 'trade-line' ),
			'fadeout'    => _x( 'fadeout', 'Transition Effect', 'trade-line' ),
			'none'       => _x( 'none', 'Transition Effect', 'trade-line' ),
			'scrollHorz' => _x( 'scrollHorz', 'Transition Effect', 'trade-line' ),
		);
		$output = apply_filters( 'trade_line_filter_featured_slider_transition_effects', $choices );
		if ( ! empty( $output ) ) {
			ksort( $output );
		}
		return $output;

	}

endif;

if ( ! function_exists( 'trade_line_get_featured_slider_content_options' ) ) :

	/**
	 * Returns the featured slider content options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Options array.
	 */
	function trade_line_get_featured_slider_content_options() {

		$choices = array(
			'home-page'   => esc_html__( 'Static Front Page Only', 'trade-line' ),
			'entire-site' => esc_html__( 'Entire Site', 'trade-line' ),
			'disabled'    => esc_html__( 'Disabled', 'trade-line' ),
		);
		$output = apply_filters( 'trade_line_filter_featured_slider_content_options', $choices );
		if ( ! empty( $output ) ) {
			ksort( $output );
		}
		return $output;

	}

endif;

if ( ! function_exists( 'trade_line_get_featured_slider_type' ) ) :

	/**
	 * Returns the featured slider type.
	 *
	 * @since 1.0.0
	 *
	 * @return array Options array.
	 */
	function trade_line_get_featured_slider_type() {

		$choices = array(
			'featured-page' => __( 'Featured Pages', 'trade-line' ),
		);
		$output = apply_filters( 'trade_line_filter_featured_slider_type', $choices );
		if ( ! empty( $output ) ) {
			ksort( $output );
		}
		return $output;

	}

endif;

if ( ! function_exists( 'trade_line_get_featured_content_status_options' ) ) :

	/**
	 * Returns the featured content options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Options array.
	 */
	function trade_line_get_featured_content_status_options() {

		$choices = array(
			'home-page' => esc_html__( 'Static Front Page Only', 'trade-line' ),
			'disabled'  => esc_html__( 'Disabled', 'trade-line' ),
		);
		$output = apply_filters( 'trade_line_filter_featured_content_status_options', $choices );
		if ( ! empty( $output ) ) {
			ksort( $output );
		}
		return $output;

	}

endif;

if ( ! function_exists( 'trade_line_get_featured_content_type' ) ) :

	/**
	 * Returns the featured content type.
	 *
	 * @since 1.0.0
	 *
	 * @return array Options array.
	 */
	function trade_line_get_featured_content_type() {

		$choices = array(
			'featured-page' => esc_html__( 'Featured Pages', 'trade-line' ),
		);
		$output = apply_filters( 'trade_line_filter_featured_content_type', $choices );
		if ( ! empty( $output ) ) {
			ksort( $output );
		}
		return $output;

	}

endif;
