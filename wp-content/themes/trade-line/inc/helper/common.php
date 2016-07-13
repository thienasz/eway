<?php
/**
 * Common helper functions.
 *
 * @package Trade_Line
 */

if ( ! function_exists( 'trade_line_the_excerpt' ) ) :

	/**
	 * Generate excerpt.
	 *
	 * @since 1.0.0
	 *
	 * @param int     $length Excerpt length in words.
	 * @param WP_Post $post_obj WP_Post instance (Optional).
	 * @return string Excerpt.
	 */
	function trade_line_the_excerpt( $length = 40, $post_obj = null ) {

		global $post;
		if ( is_null( $post_obj ) ) {
			$post_obj = $post;
		}
		$length = absint( $length );
		if ( $length < 1 ) {
			$length = 40;
		}
		$source_content = $post_obj->post_content;
		if ( ! empty( $post_obj->post_excerpt ) ) {
			$source_content = $post_obj->post_excerpt;
		}
		$source_content = preg_replace( '`\[[^\]]*\]`', '', $source_content );
		$trimmed_content = wp_trim_words( $source_content, $length, '...' );
		return $trimmed_content;

	}

endif;

if ( ! function_exists( 'trade_line_simple_breadcrumb' ) ) :

	/**
	 * Simple breadcrumb.
	 *
	 * @since 1.0.0
	 */
	function trade_line_simple_breadcrumb() {

		if ( ! function_exists( 'breadcrumb_trail' ) ) {
			require_once get_template_directory() . '/lib/breadcrumbs.php';
		}

		$breadcrumb_args = array(
			'container'   => 'div',
			'show_browse' => false,
		);
		breadcrumb_trail( $breadcrumb_args );

	}

endif;

if ( ! function_exists( 'trade_line_fonts_url' ) ) :

	/**
	 * Return fonts URL.
	 *
	 * @since 1.0.0
	 * @return string Font URL.
	 */
	function trade_line_fonts_url() {

		$fonts_url = '';
		$fonts     = array();
		$subsets   = 'latin,latin-ext';

		/* translators: If there are characters in your language that are not supported by Philosopher, translate this to 'off'. Do not translate into your own language. */
		if ( 'off' !== _x( 'on', 'Philosopher font: on or off', 'trade-line' ) ) {
			$fonts[] = 'Philosopher:400,300,500,700s';
		}

		/* translators: If there are characters in your language that are not supported by Open Sans, translate this to 'off'. Do not translate into your own language. */
		if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'trade-line' ) ) {
			$fonts[] = 'Open Sans:400,300,500';
		}

		if ( $fonts ) {
			$fonts_url = add_query_arg( array(
				'family' => urlencode( implode( '|', $fonts ) ),
				'subset' => urlencode( $subsets ),
			), '//fonts.googleapis.com/css' );
		}

		return $fonts_url;

	}

endif;

if( ! function_exists( 'trade_line_get_sidebar_options' ) ) :

  /**
   * Get sidebar options.
   *
   * @since 1.0.0
   */
  function trade_line_get_sidebar_options(){

  	global $wp_registered_sidebars;

  	$output = array();

  	if ( ! empty( $wp_registered_sidebars ) && is_array( $wp_registered_sidebars ) ) {
  		foreach ( $wp_registered_sidebars as $key => $sidebar ) {
  			$output[$key] = $sidebar['name'];
  		}
  	}

  	return $output;

  }

endif;

if( ! function_exists( 'trade_line_primary_navigation_fallback' ) ) :

	/**
	 * Fallback for primary navigation.
	 *
	 * @since 1.0.0
	 */
	function trade_line_primary_navigation_fallback() {
		echo '<ul>';
		echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . __( 'Home', 'trade-line' ). '</a></li>';
		wp_list_pages( array(
			'title_li' => '',
			'depth'    => 1,
			'number'   => 7,
		) );
		echo '</ul>';

	}

endif;

if ( ! function_exists( 'trade_line_the_custom_logo' ) ) :

	/**
	 * Render logo.
	 *
	 * @since 1.1
	 */
	function trade_line_the_custom_logo() {

		if ( function_exists( 'the_custom_logo' ) ) {
			the_custom_logo();
		}
		else {
			$site_logo = trade_line_get_option( 'site_logo' );
			if ( ! empty( $site_logo ) ) {
				?>
				<div class="fix-logo">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo-link">
						<img src="<?php echo esc_url( $site_logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" />
					</a>
				</div>
				<?php
			}
		}
	}

endif;

if ( ! function_exists( 'trade_line_get_index_page_id' ) ) :

	/**
	 * Get front index page ID.
	 *
	 * @since 1.0.0
	 *
	 * @param string $type Type.
	 * @return int Corresponding Page ID.
	 */
	function trade_line_get_index_page_id( $type = 'front' ) {

		$page = '';

		switch ( $type ) {
			case 'front':
				$page = get_option( 'page_on_front' );
				break;

			case 'blog':
				$page = get_option( 'page_for_posts' );
				break;

			default:
				break;
		}
		$page = absint( $page );
		return $page;

	}
endif;

if ( ! function_exists( 'trade_line_render_select_dropdown' ) ) :

	/**
	 * Render select dropdown.
	 *
	 * @since 1.0.0
	 *
	 * @param array $main_args Main arguments.
	 * @param string $callback Callback method.
	 * @param array $callback_args Callback arguments.
	 * @return string Rendered markup.
	 */
	function trade_line_render_select_dropdown( $main_args, $callback, $callback_args = array() ) {

		$defaults = array(
			'id'       => '',
			'name'     => '',
			'selected' => 0,
			'echo'     => 1,
		);

		$r = wp_parse_args( $main_args, $defaults );
		$output = '';
		$choices = array();
		if ( is_callable( $callback ) ) {
			$choices = call_user_func_array( $callback, $callback_args );
		}

		if ( ! empty( $choices ) ) {

		  $output = "<select name='" . esc_attr( $r['name'] ) . "' id='" . esc_attr( $r['id'] ) . "'>\n";
		  foreach ( $choices as $key => $choice ) {
		    $output .= '<option value="' . esc_attr( $key ) . '" ';
		    $output .= selected( $r['selected'], $key, false );
		    $output .= '>' . esc_html( $choice ) . '</option>\n';
		  }
		  $output .= "</select>\n";
		}

		if ( $r['echo'] ) {
		  echo $output;
		}
		return $output;

	}

endif;
