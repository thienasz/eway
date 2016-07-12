<?php
/**
 * Implementation of featured content.
 *
 * @package Trade_Line
 */

// Check status.
add_filter( 'trade_line_filter_featured_content_status', 'trade_line_check_featured_content_status' );

// Add featured content to the theme.
add_action( 'trade_line_action_before_content', 'trade_line_add_featured_content', 6 );

// Featured content details.
add_filter( 'trade_line_filter_featured_content_details', 'trade_line_get_featured_content_details' );

if ( ! function_exists( 'trade_line_get_featured_content_details' ) ) :
	/**
	 * Featured content details.
	 *
	 * @since 1.0.0
	 *
	 * @param array $input Featured content details.
	 */
	function trade_line_get_featured_content_details( $input ) {

		$featured_content_type   = trade_line_get_option( 'featured_content_type' );
		$featured_content_number = trade_line_get_option( 'featured_content_number' );
		$featured_content_excerpt_length = trade_line_get_option( 'featured_content_excerpt_length' );

		switch ( $featured_content_type ) {

			case 'featured-page':

				$ids = array();

				for ( $i = 1; $i <= $featured_content_number ; $i++ ) {
					$id = trade_line_get_option( 'featured_content_page_' . $i );
					if ( ! empty( $id ) ) {
						$ids[] = absint( $id );
					}
				}
				// Bail if no valid pages are selected.
				if ( empty( $ids ) ) {
					return $input;
				}

				$qargs = array(
					'posts_per_page' => esc_attr( $featured_content_number ),
					'no_found_rows'  => true,
					'orderby'        => 'post__in',
					'post_type'      => 'page',
					'post__in'       => $ids,
				);

				// Fetch posts.
				$all_posts = get_posts( $qargs );
				$contents = array();

				if ( ! empty( $all_posts ) ) {

					$cnt = 0;
					foreach ( $all_posts as $key => $post ) {

							$image_array = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'trade-line-thumb' );
							$contents[ $cnt ]['images']  = $image_array;
							$contents[ $cnt ]['title']   = esc_html( $post->post_title );
							$contents[ $cnt ]['url']     = esc_url( get_permalink( $post->ID ) );
							$contents[ $cnt ]['excerpt'] = trade_line_the_excerpt( apply_filters( 'trade_line_filter_featured_content_excerpt_length', absint( $featured_content_excerpt_length ) ), $post );

							$cnt++;
					}
				}
				if ( ! empty( $contents ) ) {
					$input = $contents;
				}
				break;

			default:
				break;
		}
		return $input;

	}
endif;

if ( ! function_exists( 'trade_line_add_featured_content' ) ) :

	/**
	 * Add featured content.
	 *
	 * @since 1.0.0
	 */
	function trade_line_add_featured_content() {

		$flag_apply_featured_content = apply_filters( 'trade_line_filter_featured_content_status', true );
		if ( true !== $flag_apply_featured_content ) {
			return false;
		}

		$content_details = array();
		$content_details = apply_filters( 'trade_line_filter_featured_content_details', $content_details );

		if ( empty( $content_details ) ) {
			return;
		}
		// Render content now.
		trade_line_render_featured_content( $content_details );

	}

endif;

if ( ! function_exists( 'trade_line_render_featured_content' ) ) :
	/**
	 * Render featured content.
	 *
	 * @since 1.0.0
	 *
	 * @param array $content_details Details of featured content.
	 */
	function trade_line_render_featured_content( $content_details = array() ) {

		if ( empty( $content_details ) ) {
			return;
		}
		$featured_content_number = trade_line_get_option( 'featured_content_number' );
		?>
		<div id="featured-content">
			<div class="container">
				<div class="inner-wrapper featured-content-column-<?php echo absint( $featured_content_number ); ?>">
				<?php foreach ( $content_details as $content ) : ?>
					<?php
						$link_open = '';
						$link_close = '';
						if ( ! empty( $content['url'] ) ) {
							$link_open = '<a href=" '. esc_url( $content['url'] ) . '">';
							$link_close = '</a>';
						}
					?>
					<article>
						<header class="entry-header">
							<h2 class="entry-title">
								<?php echo $link_open . esc_html( $content['title'] ) . $link_close; ?>
							</h2>
						</header>
						<?php if ( ! empty( $content['images'] ) ) : ?>
							<?php echo $link_open; ?>
							<img src="<?php echo esc_url( $content['images'][0]); ?>" alt="<?php echo esc_attr( $content['title'] ); ?>" width="<?php echo esc_attr( $content['images'][1]); ?>" height="<?php echo esc_attr( $content['images'][2]); ?>" />
							<?php echo $link_close; ?>
						<?php endif ?>
						<div class="entry-content">
							<p><?php echo $content['excerpt']; ?></p>
						</div>
					</article>
				<?php endforeach ?>
				</div>
			</div>
		</div>

		<?php

	}

endif;

if ( ! function_exists( 'trade_line_check_featured_content_status' ) ):

	/**
	 * Check status of featured content.
	 *
	 * @since 1.0.0
	 */
	function trade_line_check_featured_content_status( $input ) {

		global $post, $wp_query;
		$input = false;

	    // Featured content status.
		$featured_content_status = trade_line_get_option( 'featured_content_status' );

	    // Get Page ID outside Loop.
		$page_id = $wp_query->get_queried_object_id();

	    // Front page displays in Reading Settings.
		$page_on_front  = absint( get_option( 'page_on_front' ) );
		$page_for_posts = absint( get_option( 'page_for_posts' ) );

		switch ( $featured_content_status ) {
			case 'disabled':
				$input = false;
				break;
			case 'home-page':
				if ( $page_id > 0 && $page_id === $page_on_front ) {
					$input = true;
				}
				break;

			default:
				break;
		}

		return $input;

	}

endif;
