<?php
/**
 * Basic theme functions.
 *
 * This file contains hook functions attached to core hooks.
 *
 * @package Trade_Line
 */

if ( ! function_exists( 'trade_line_implement_excerpt_length' ) ) :

	/**
	 * Implement excerpt length
	 *
	 * @since 1.0.0
	 *
	 * @param int $length The number of words.
	 * @return int Excerpt length.
	 */
	function trade_line_implement_excerpt_length( $length ) {

		$excerpt_length = trade_line_get_option( 'excerpt_length' );
		if ( empty( $excerpt_length ) ) {
			$excerpt_length = $length;
		}
		return apply_filters( 'trade_line_filter_excerpt_length', esc_attr( $excerpt_length ) );

	}

endif;
add_filter( 'excerpt_length', 'trade_line_implement_excerpt_length', 999 );


if ( ! function_exists( 'trade_line_implement_read_more' ) ) :

	/**
	 * Implement read more in excerpt
	 *
	 * @since 1.0.0
	 *
	 * @param string $more The string shown within the more link.
	 * @return string The excerpt.
	 */
	function trade_line_implement_read_more( $more ) {

		$flag_apply_excerpt_read_more = apply_filters( 'trade_line_filter_excerpt_read_more', true );
		if ( true !== $flag_apply_excerpt_read_more ) {
			return $more;
		}

		$output = $more;
		$read_more_text = trade_line_get_option( 'read_more_text' );
		if ( ! empty( $read_more_text ) ) {
			$output = ' <a href="'. esc_url( get_permalink() ) . '" class="read-more">' . esc_html( $read_more_text ) . '</a>';
			$output = apply_filters( 'trade_line_filter_read_more_link' , $output );
		}
		return $output;

	}

endif;
add_filter( 'excerpt_more', 'trade_line_implement_read_more' );


if ( ! function_exists( 'trade_line_content_more_link' ) ) :

	/**
	 * Implement read more in content.
	 *
	 * @since 1.0.0
	 *
	 * @param string $more_link Read More link element.
	 * @param string $more_link_text Read More text.
	 * @return string Link.
	 */
	function trade_line_content_more_link( $more_link, $more_link_text ) {

		$flag_apply_excerpt_read_more = apply_filters( 'trade_line_filter_excerpt_read_more', true );
		if ( true !== $flag_apply_excerpt_read_more ) {
			return $more_link;
		}

		$read_more_text = trade_line_get_option( 'read_more_text' );
		if ( ! empty( $read_more_text ) ) {
			$more_link = str_replace( $more_link_text, $read_more_text, $more_link );
		}
		return $more_link;

	}

endif;

add_filter( 'the_content_more_link', 'trade_line_content_more_link', 10, 2 );


if ( ! function_exists( 'trade_line_custom_body_class' ) ) :
	/**
	 * Custom body class
	 *
	 * @since 1.0.0
	 *
	 * @param string|array $input One or more classes to add to the class list.
	 * @return array Array of classes.
	 */
	function trade_line_custom_body_class( $input ) {

		// Site layout.
		$site_layout = trade_line_get_option( 'site_layout' );
		$input[] = 'site-layout-' . esc_attr( $site_layout );

		// Global layout.
		global $post;
		$global_layout = trade_line_get_option( 'global_layout' );
		$global_layout = apply_filters( 'trade_line_filter_theme_global_layout', $global_layout );

		// Check if single.
		if ( $post  && is_singular() ) {
			$post_options = get_post_meta( $post->ID, 'theme_settings', true );
			if ( isset( $post_options['post_layout'] ) && ! empty( $post_options['post_layout'] ) ) {
				$global_layout = $post_options['post_layout'];
			}
		}

		$input[] = 'global-layout-' . esc_attr( $global_layout );

		// Common class for three columns.
		switch ( $global_layout ) {
		  case 'three-columns':
		    $input[] = 'three-columns-enabled';
		    break;

		  default:
		    break;
		}

		return $input;
	}
endif;

add_filter( 'body_class', 'trade_line_custom_body_class' );

if ( ! function_exists( 'trade_line_featured_image_instruction' ) ) :

	/**
	 * Message to show in the Featured Image Meta box.
	 *
	 * @since 1.0.0
	 *
	 * @param string $content Admin post thumbnail HTML markup.
	 * @param int    $post_id Post ID.
	 * @return string HTML.
	 */
	function trade_line_featured_image_instruction( $content, $post_id ) {

		$allowed = array( 'page' );
		if ( in_array( get_post_type( $post_id ), $allowed ) ) {
			$content .= '<strong>' . __( 'Recommended Image Sizes', 'trade-line' ) . ':</strong><br/>';
			$content .= __( 'Slider Image', 'trade-line' ) . ' : 1350px X 590px';
		}

		return $content;

	}

endif;
add_filter( 'admin_post_thumbnail_html', 'trade_line_featured_image_instruction', 10, 2 );

if ( ! function_exists( 'trade_line_custom_content_width' ) ) :

	/**
	 * Custom content width.
	 *
	 * @since 1.0.0
	 */
	function trade_line_custom_content_width() {

		global $post, $wp_query, $content_width;

		$global_layout = trade_line_get_option( 'global_layout' );
		$global_layout = apply_filters( 'trade_line_filter_theme_global_layout', $global_layout );

		// Check if single.
		if ( $post  && is_singular() ) {
		  $post_options = get_post_meta( $post->ID, 'theme_settings', true );
		  if ( isset( $post_options['post_layout'] ) && ! empty( $post_options['post_layout'] ) ) {
		    $global_layout = esc_attr( $post_options['post_layout'] );
		  }
		}
		switch ( $global_layout ) {

			case 'no-sidebar':
				$content_width = 1220;
				break;

			case 'three-columns':
				$content_width = 570;
				break;

			case 'left-sidebar':
			case 'right-sidebar':
				$content_width = 895;
				break;

			default:
				break;
		}

	}
endif;

add_filter( 'template_redirect', 'trade_line_custom_content_width' );

if( ! function_exists( 'trade_line_exclude_category_in_blog_page' ) ) :

  /**
   * Exclude category in blog page.
   *
   * @since 1.0.0
   */
  function trade_line_exclude_category_in_blog_page( $query ) {

    if( $query->is_home && $query->is_main_query()   ) {
      $exclude_categories = trade_line_get_option( 'exclude_categories' );
      if ( ! empty( $exclude_categories ) ) {
        $cats = explode( ',', $exclude_categories );
        $cats = array_filter( $cats, 'is_numeric' );
        $string_exclude = '';
        if ( ! empty( $cats ) ) {
          $string_exclude = '-' . implode( ',-', $cats);
          $query->set( 'cat', $string_exclude );
        }
      }
    }
    return $query;

  }

endif;

add_filter( 'pre_get_posts', 'trade_line_exclude_category_in_blog_page' );
