<?php
/**
 * Default theme options.
 *
 * @package Trade_Line
 */

if ( ! function_exists( 'trade_line_get_default_theme_options' ) ) :

	/**
	 * Get default theme options
	 *
	 * @since 1.0.0
	 *
	 * @return array Default theme options.
	 */
	function trade_line_get_default_theme_options() {

		$defaults = array();

		// Header.
		$defaults['site_logo']        = '';
		$defaults['show_title']       = true;
		$defaults['show_tagline']     = true;
		$defaults['social_in_header'] = true;
		$defaults['search_in_header'] = true;

		// Layout.
		$defaults['site_layout']             = 'boxed';
		$defaults['global_layout']           = 'right-sidebar';
		$defaults['archive_layout']          = 'full';
		$defaults['archive_image']           = 'large';
		$defaults['archive_image_alignment'] = 'center';
		$defaults['single_image']            = 'large';

		// Pagination.
		$defaults['pagination_type'] = 'default';

		// Footer.
		$defaults['copyright_text'] = esc_html__( 'Copyright &copy; All rights reserved.', 'trade-line' );

		// Blog.
		$defaults['excerpt_length']  = 40;
		$defaults['read_more_text']  = esc_html__( 'Read More ...', 'trade-line' );
		$defaults['exclude_categories'] = '';

		// Author Bio.
		$defaults['author_bio_in_single'] = true;

		// Breadcrumb.
		$defaults['breadcrumb_type'] = 'simple';

		// Advanced.
		$defaults['custom_css'] = '';

		// Slider Options.
		$defaults['featured_slider_status']              = 'disabled';
		$defaults['featured_slider_transition_effect']   = 'fadeout';
		$defaults['featured_slider_transition_delay']    = 3;
		$defaults['featured_slider_transition_duration'] = 1;
		$defaults['featured_slider_enable_caption']      = true;
		$defaults['featured_slider_enable_arrow']        = true;
		$defaults['featured_slider_enable_pager']        = true;
		$defaults['featured_slider_enable_autoplay']     = true;
		$defaults['featured_slider_type']                = 'featured-page';
		$defaults['featured_slider_number']              = 3;

		// Featured Content Options.
		$defaults['featured_content_status']         = 'disabled';
		$defaults['featured_content_number']         = 3;
		$defaults['featured_content_type']           = 'featured-page';
		$defaults['featured_content_excerpt_length'] = 40;

		// Pass through filter.
		$defaults = apply_filters( 'trade_line_filter_default_theme_options', $defaults );
		return $defaults;
	}

endif;
