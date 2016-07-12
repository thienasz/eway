<?php
/**
 * Custom Header feature.
 *
 * @link http://codex.wordpress.org/Custom_Headers
 *
 * @package Trade_Line
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @since 1.0.0
 */
function trade_line_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'trade_line_custom_header_args', array(
			'default-image' => '',
			'width'         => 1350,
			'height'        => 130,
			'flex-height'   => true,
			'header-text'   => false,
	) ) );
}
add_action( 'after_setup_theme', 'trade_line_custom_header_setup' );
