<?php
/**
 * Custom theme functions.
 *
 * This file contains hook functions attached to theme hooks.
 *
 * @package Trade_Line
 */

if ( ! function_exists( 'trade_line_skip_to_content' ) ) :
	/**
	 * Add Skip to content.
	 *
	 * @since 1.0.0
	 */
	function trade_line_skip_to_content() {
	?><a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'trade-line' ); ?></a><?php
	}
endif;

add_action( 'trade_line_action_before', 'trade_line_skip_to_content', 15 );


if ( ! function_exists( 'trade_line_site_branding' ) ) :

	/**
	 * Site branding.
	 *
	 * @since 1.0.0
	 */
	function trade_line_site_branding() {
	?>
<div class="k-head-cus clearfix">
	<div class="col-sm-6">
		<div class="site-branding clearfix">

			<?php trade_line_the_custom_logo(); ?>

			<?php $show_title = trade_line_get_option( 'show_title' ); ?>
			<?php $show_tagline = trade_line_get_option( 'show_tagline' ); ?>
			<?php if ( true === $show_title || true === $show_tagline ) :  ?>
			<?php endif; ?>

		</div><!-- .site-branding -->
		<div id="site-identity">
			<?php if ( true === $show_title ) :  ?>
				<?php if ( is_front_page() && is_home() ) : ?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php else : ?>
					<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php endif; ?>
			<?php endif ?>

			<?php if ( true === $show_tagline ) :  ?>
				<p class="site-description"><?php bloginfo( 'description' ); ?></p>
			<?php endif ?>
		</div><!-- #site-identity -->
	</div>
	<div class="col-sm-6">

		<div class="right-head">
			<?php
			$search_in_header = trade_line_get_option( 'search_in_header' );
			if ( true === $search_in_header ) :
				?>
				<div class="search-box">
					<form action="<?php echo home_url( '/' ); ?>" method="get">
						<label for="search"></label>
						<input type="text" name="s" id="search" value="<?php the_search_query(); ?>" />
						<button type="submit" alt="Search" class="search-icon"> <i class="fa fa-search"></i></button>
					</form>
				</div>

			<?php endif; ?>
			<?php
			$social_in_header = trade_line_get_option( 'social_in_header' );
			?>
			<div class="social-links">
				<?php
				if ( true === $social_in_header ) {
					the_widget( 'Trade_Line_Social_Widget' );
				}
				?>
			</div>

		</div>

		<?php if ( is_active_sidebar( 'sidebar-top' ) ) : ?>
			<div id="secondary" class="widget-area" role="complementary">
				<?php dynamic_sidebar( 'sidebar-top' ); ?>
			</div>
		<?php endif; ?>

	</div>
</div>
    <?php

	}

endif;

add_action( 'trade_line_action_header', 'trade_line_site_branding' );

if ( ! function_exists( 'trade_line_add_primary_navigation' ) ) :

	/**
	 * Site branding.
	 *
	 * @since 1.0.0
	 */

	function trade_line_add_primary_navigation() {
		?>
		    <div id="main-nav" class="clear-fix">
		        <div class="container">
		        <nav id="site-navigation" class="main-navigation" role="navigation">
		            <div class="wrap-menu-content">
						<?php
						wp_nav_menu(
							array(
							'theme_location' => 'primary',
							'menu_id'        => 'primary-menu',
							'fallback_cb'    => 'trade_line_primary_navigation_fallback',
							)
						);
						?>
		            </div><!-- .menu-content -->
		        </nav><!-- #site-navigation -->
		       </div> <!-- .container -->
		    </div> <!-- #main-nav -->
    <?php
	}

endif;
add_action( 'trade_line_action_after_header', 'trade_line_add_primary_navigation', 20 );

if ( ! function_exists( 'trade_line_mobile_navigation' ) ) :

	/**
	 * Mobile navigation.
	 *
	 * @since 1.0.0
	 */
	function trade_line_mobile_navigation() {
		?>
		<a id="mobile-trigger" href="#mob-menu"><i class="fa fa-bars"></i></a>
		<div id="mob-menu">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => '',
				'fallback_cb'    => 'trade_line_primary_navigation_fallback',
				) );
			?>
		</div><!-- #mob-menu -->
		<?php

	}

endif;
add_action( 'trade_line_action_before', 'trade_line_mobile_navigation', 20 );

if ( ! function_exists( 'trade_line_add_sidebar' ) ) :

	/**
	 * Add sidebar.
	 *
	 * @since 1.0.0
	 */
	function trade_line_add_sidebar() {

		global $post;

		$global_layout = trade_line_get_option( 'global_layout' );
		$global_layout = apply_filters( 'trade_line_filter_theme_global_layout', $global_layout );

		// Check if single.
		if ( $post && is_singular() ) {
			$post_options = get_post_meta( $post->ID, 'theme_settings', true );
			if ( isset( $post_options['post_layout'] ) && ! empty( $post_options['post_layout'] ) ) {
				$global_layout = $post_options['post_layout'];
			}
		}

		// Include primary sidebar.
		if ( 'no-sidebar' !== $global_layout ) {
			get_sidebar();
		}
		// Include Secondary sidebar.
		switch ( $global_layout ) {
		  case 'three-columns':
		    get_sidebar( 'secondary' );
		    break;

		  default:
		    break;
		}

	}

endif;

add_action( 'trade_line_action_sidebar', 'trade_line_add_sidebar' );


if ( ! function_exists( 'trade_line_custom_posts_navigation' ) ) :
	/**
	 * Posts navigation.
	 *
	 * @since 1.0.0
	 */
	function trade_line_custom_posts_navigation() {

		$pagination_type = trade_line_get_option( 'pagination_type' );

		switch ( $pagination_type ) {

			case 'default':
				the_posts_navigation();
			break;

			case 'numeric':
				the_posts_pagination();
			break;

			default:
			break;
		}

	}
endif;

add_action( 'trade_line_action_posts_navigation', 'trade_line_custom_posts_navigation' );


if ( ! function_exists( 'trade_line_add_image_in_single_display' ) ) :

	/**
	 * Add image in single post.
	 *
	 * @since 1.0.0
	 */
	function trade_line_add_image_in_single_display() {

		global $post;

		if ( has_post_thumbnail() ) {

			$values = get_post_meta( $post->ID, 'theme_settings', true );
			$theme_settings_single_image = isset( $values['single_image'] ) ? esc_attr( $values['single_image'] ) : '';

			if ( ! $theme_settings_single_image ) {
				$theme_settings_single_image = trade_line_get_option( 'single_image' );
			}

			if ( 'disable' !== $theme_settings_single_image ) {
				$args = array(
					'class' => 'aligncenter',
				);
				the_post_thumbnail( esc_attr( $theme_settings_single_image ), $args );
			}
		}

	}

endif;

add_action( 'trade_line_single_image', 'trade_line_add_image_in_single_display' );

if ( ! function_exists( 'trade_line_add_breadcrumb' ) ) :

	/**
	 * Add breadcrumb.
	 *
	 * @since 1.0.0
	 */
	function trade_line_add_breadcrumb() {

		// Bail if Breadcrumb disabled.
		$breadcrumb_type = trade_line_get_option( 'breadcrumb_type' );
		if ( 'disabled' === $breadcrumb_type ) {
			return;
		}

		// Bail if Home Page.
		if ( is_front_page() || is_home() ) {
			return;
		}

		echo '<div id="breadcrumb"><div class="container">';
		switch ( $breadcrumb_type ) {
			case 'simple':
				trade_line_simple_breadcrumb();
				break;

			case 'advanced':
				if ( function_exists( 'bcn_display' ) ) {
					bcn_display();
				}
				else {
					trade_line_simple_breadcrumb();
				}
				break;

			default:
				break;
		}
		echo '</div><!-- .container --></div><!-- #breadcrumb -->';
		return;

	}

endif;

add_action( 'trade_line_action_before_content', 'trade_line_add_breadcrumb' , 7 );


if ( ! function_exists( 'trade_line_footer_goto_top' ) ) :

	/**
	 * Go to top.
	 *
	 * @since 1.0.0
	 */
	function trade_line_footer_goto_top() {

		echo '<a href="#page" class="scrollup" id="btn-scrollup"><i class="fa fa-angle-up"></i></a>';

	}

endif;

add_action( 'trade_line_action_after', 'trade_line_footer_goto_top', 20 );

if ( ! function_exists( 'trade_line_add_front_page_widget_area' ) ) :

	/**
	 * Add Front Page Widget area.
	 *
	 * @since 1.0.0
	 */
	function trade_line_add_front_page_widget_area() {

		$current_id = trade_line_get_index_page_id();
		if ( is_front_page() && get_queried_object_id() === $current_id && $current_id > 0 ) {

			if ( is_active_sidebar( 'sidebar-front-page-widget-area' ) ) {
				echo '<div id="sidebar-front-page-widget-area" class="widget-area">';
				echo '<div class="container">';
				dynamic_sidebar( 'sidebar-front-page-widget-area' );

				echo '</div><!-- .container -->';
				echo '</div><!-- #sidebar-front-page-widget-area -->';
			}
		}

	}
endif;

add_action( 'trade_line_action_before_content', 'trade_line_add_front_page_widget_area', 7 );
if ( ! function_exists( 'trade_line_add_front_page_widget_area_2' ) ) :

	/**
	 * Add Front Page Widget area.
	 *
	 * @since 1.0.0
	 */
	function trade_line_add_front_page_widget_area_2() {

		$current_id = trade_line_get_index_page_id();
		if ( is_front_page() && get_queried_object_id() === $current_id && $current_id > 0 ) {

			if ( is_active_sidebar( 'sidebar-front-page-widget-area-2' ) ) {
				echo '<div id="sidebar-front-page-widget-area" class="widget-area">';
				echo '<div class="container">';
				dynamic_sidebar( 'sidebar-front-page-widget-area-2' );
				echo '</div><!-- .container -->';
				echo '</div><!-- #sidebar-front-page-widget-area -->';
			}
		}

	}
endif;

add_action( 'trade_line_action_before_content_2', 'trade_line_add_front_page_widget_area_2', 7 );

if ( ! function_exists( 'trade_line_add_author_bio_in_single' ) ) :

	/**
	 * Display Author bio.
	 *
	 * @since 1.0.0
	 */
	function trade_line_add_author_bio_in_single() {

		// Bail if not single post.
		if ( ! is_singular( 'post' ) ) {
			return;
		}

		// Bail if there is not author description.
		if ( ! get_the_author_meta('description' ) ) {
			return;
		}

		// Bail if bio is disabled.
		$author_bio_in_single = trade_line_get_option( 'author_bio_in_single' );
		if ( true !== $author_bio_in_single ) {
			return;
		}
		get_template_part( 'template-parts/author-bio', 'single' );

	}
endif;

add_action( 'trade_line_author_bio', 'trade_line_add_author_bio_in_single' );
//
//if ( ! function_exists( 'trade_line_display_default_widget_in_front_page' ) ) :
//
//	/**
//	 * Display default widget in front page.
//	 *
//	 * @since 1.1
//	 */
//	function trade_line_display_default_widget_in_front_page() {
//
//		// Welcome.
//		$args = array(
//			'title'               => __( 'Welcome to Trade Line', 'trade-line' ),
//			'filter'              => true,
//			'primary_button_url'  => '#',
//			'primary_button_text' => __( 'Learn More', 'trade-line' ),
//			'text'                => __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dignissimos dolor possimus inventore ut sint et, blanditiis nobis tempore voluptatum, autem in. Provident fugiat sunt placeat quibusdam dolore, quasi repudiandae eius.', 'trade-line' ),
//		);
//		if ( current_user_can( 'edit_theme_options' ) ) {
//			$args['primary_button_url']  = esc_url( admin_url( 'widgets.php' ) );
//			$args['primary_button_text'] = __( 'Add Widgets', 'trade-line' );
//			$args['text']                = __( 'You are seeing this because there is no any widget in Front Page Widget Area. Go to Appearance->Widgets in admin panel to add widgets. All these widgets will be replaced when you start adding widgets.', 'trade-line' );
//		}
//
//		$widget_args = array(
//			'before_title' => '<h2 class="widget-title"><span>',
//			'after_title'  => '</span></h2>',
//		);
//		the_widget( 'Trade_Line_Call_To_Action_Widget', $args, $widget_args );
//
//		// Latest news.
//		$args = array(
//			'title' => __( 'Latest News', 'trade-line' ),
//		);
//
//		$widget_args = array(
//			'before_title' => '<h2 class="widget-title"><span>',
//			'after_title'  => '</span></h2>',
//		);
//		the_widget( 'Trade_Line_Latest_News_Widget', $args, $widget_args );
//
//	}
//
//endif;
//
//add_action( 'trade_line_action_default_front_page_widget_area', 'trade_line_display_default_widget_in_front_page' );
