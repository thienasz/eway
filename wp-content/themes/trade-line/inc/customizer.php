<?php
/**
 * Theme Customizer.
 *
 * @package Trade_Line
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function trade_line_customize_register( $wp_customize ) {

	// Load custom controls.
	require get_template_directory() . '/inc/customizer/control.php';

	// Load customize helpers.
	require get_template_directory() . '/inc/helper/options.php';

	// Load customize sanitize.
	require get_template_directory() . '/inc/customizer/sanitize.php';

	// Load customize callback.
	require get_template_directory() . '/inc/customizer/callback.php';

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

	// Load customize option.
	require get_template_directory() . '/inc/customizer/option.php';

	// Load slider customize option.
	require get_template_directory() . '/inc/customizer/slider.php';

	// Load featured content customize option.
	require get_template_directory() . '/inc/customizer/featured-content.php';

	// Modify default customizer options.
	$wp_customize->get_control( 'background_color' )->description = __( 'Note: Background Color is applicable only if no image is set as Background Image.', 'trade-line' );
}

add_action( 'customize_register', 'trade_line_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @since 1.0.0
 */
function trade_line_customize_preview_js() {

	$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	wp_enqueue_script( 'trade-line-customizer', get_template_directory_uri() . '/js/customizer' . $min . '.js', array( 'customize-preview' ), '1.3.0', true );

}
add_action( 'customize_preview_init', 'trade_line_customize_preview_js' );

/**
 * Load styles for Customizer.
 *
 * @since 1.0.0
 */
function trade_line_load_customizer_styles() {

	global $pagenow;

	if ( 'customize.php' === $pagenow ) {
		$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		wp_register_style( 'trade-line-customizer-style', get_template_directory_uri() . '/css/customizer' . $min . '.css', false, '1.3.0' );
		wp_enqueue_style( 'trade-line-customizer-style' );
	}

}

add_action( 'admin_enqueue_scripts', 'trade_line_load_customizer_styles' );

/**
 * Add Upgrade To Pro button.
 *
 * @since 1.3.0
 */
function trade_line_custom_customize_enqueue_scripts() {

	$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	wp_register_script( 'trade-line-customizer-button', get_template_directory_uri() . '/js/customizer-button' . $min . '.js', array( 'customize-controls' ), '1.3.0', true );
	$data = array(
		'updrade_button_text' => __( 'Buy Trade Line Pro', 'trade-line' ),
		'updrade_button_link' => esc_url( 'http://themepalace.com/downloads/trade-line-pro/' ),
	);
	wp_localize_script( 'trade-line-customizer-button', 'Trade_Line_Customizer_Object', $data );
	wp_enqueue_script( 'trade-line-customizer-button' );

}

add_action( 'customize_controls_enqueue_scripts', 'trade_line_custom_customize_enqueue_scripts' );
