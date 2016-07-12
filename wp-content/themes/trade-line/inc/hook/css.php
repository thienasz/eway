<?php
/**
 * CSS related hooks.
 *
 * This file contains hook functions which are related to CSS.
 *
 * @package Trade_Line
 */

if ( ! function_exists( 'trade_line_trigger_custom_css_action' ) ) :

	/**
	 * Do action theme custom CSS.
	 *
	 * @since 1.0.0
	 */
	function trade_line_trigger_custom_css_action() {

		/**
		 * Hook - trade_line_action_theme_custom_css.
		 *
		 * @hooked trade_line_add_option_custom_css - 99
		 */
		do_action( 'trade_line_action_theme_custom_css' );

	}

endif;

add_action( 'wp_head', 'trade_line_trigger_custom_css_action', 99 );

if ( ! function_exists( 'trade_line_add_option_custom_css' ) ) :

	/**
	 * Add custom CSS.
	 *
	 * @since 1.0.0
	 */
	function trade_line_add_option_custom_css() {

		$custom_css = trade_line_get_option( 'custom_css' );
		$output = '';
		if ( ! empty( $custom_css ) ) {
			$output = "\n" . '<style type="text/css">' . "\n";
			$output .= $custom_css;
			$output .= "\n" . '</style>' . "\n" ;
		}
		echo $output;

	}

endif;

add_action( 'trade_line_action_theme_custom_css', 'trade_line_add_option_custom_css', 99 );
