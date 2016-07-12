<?php
/**
 * Theme functions and definitions.
 *
 * @link https://codex.wordpress.org/Functions_File_Explained
 *
 * @package Trade_Line
 */

if ( ! function_exists( 'trade_line_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function trade_line_setup() {
		/*
		 * Make theme available for translation.
		 */
		load_theme_textdomain( 'trade-line' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'trade-line-thumb', 360, 270 );

		// This theme uses wp_nav_menu() in four location.
		register_nav_menus( array(
			'primary'  => esc_html__( 'Primary Menu', 'trade-line' ),
			'footer'   => esc_html__( 'Footer Menu', 'trade-line' ),
			'social'   => esc_html__( 'Social Menu', 'trade-line' ),
			'notfound' => esc_html__( '404 Menu', 'trade-line' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		/*
		 * Enable support for Post Formats.
		 * See https://developer.wordpress.org/themes/functionality/post-formats/
		 */
		add_theme_support( 'post-formats', array(
			'aside',
			'image',
			'video',
			'quote',
			'link',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'trade_line_custom_background_args', array(
			'default-color' => 'dfdfd0',
			'default-image' => get_template_directory_uri().'/images/body-bg.png',
		) ) );

		/*
		 * Enable support for custom logo.
		 */
		add_theme_support( 'custom-logo' );

		/*
		 * Enable support for selective refresh of widgets in Customizer.
		 */
		add_theme_support( 'customize-selective-refresh-widgets' );

		$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		// Editor style.
		add_editor_style( 'css/editor-style' . $min . '.css' );

		// Enable support for footer widgets.
		add_theme_support( 'footer-widgets', 4 );

		// Load Supports.
		require get_template_directory() . '/inc/support.php';

		global $trade_line_default_options;
		$trade_line_default_options = trade_line_get_default_theme_options();

	}
endif;

add_action( 'after_setup_theme', 'trade_line_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function trade_line_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'trade_line_content_width', 640 );
}
add_action( 'after_setup_theme', 'trade_line_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function trade_line_widgets_init() {

	register_sidebar( array(
		'name'          => esc_html__( 'Primary Sidebar', 'trade-line' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here to appear in your Primary Sidebar.', 'trade-line' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Secondary Sidebar', 'trade-line' ),
		'id'            => 'sidebar-2',
		'description'   => esc_html__( 'Add widgets here to appear in your Secondary Sidebar.', 'trade-line' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Front Page Widget Area', 'trade-line' ),
		'id'            => 'sidebar-front-page-widget-area',
		'description'   => esc_html__( 'Add widgets here to appear in your Front Page.', 'trade-line' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Front Page Widget Area 2', 'trade-line-2' ),
		'id'            => 'sidebar-front-page-widget-area-2',
		'description'   => esc_html__( 'Add widgets here to appear in your Front Page.', 'trade-line-2' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

}
add_action( 'widgets_init', 'trade_line_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function trade_line_scripts() {

	$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/third-party/font-awesome/css/font-awesome' . $min . '.css', '', '4.6.1' );

	$fonts_url = trade_line_fonts_url();
	if ( ! empty( $fonts_url ) ) {
		wp_enqueue_style( 'trade-line-google-fonts', $fonts_url, array(), null );
	}

	wp_enqueue_style( 'sidr', get_template_directory_uri() .'/third-party/sidr/css/jquery.sidr.dark' . $min . '.css', '', '2.2.1' );

	wp_enqueue_style( 'trade-line-style', get_stylesheet_uri(), array(), '1.3.0' );

	if ( has_header_image() ) {
		$custom_css = '#masthead{ background-image: url("' . esc_url( get_header_image() ) . '"); background-repeat: no-repeat; background-position: center center; }';
		wp_add_inline_style( 'trade-line-style', $custom_css );
	}

	wp_enqueue_script( 'trade-line-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix' . $min . '.js', array(), '20130115', true );

	wp_enqueue_script( 'jquery-cycle2', get_template_directory_uri() . '/third-party/cycle2/js/jquery.cycle2' . $min . '.js', array( 'jquery' ), '2.1.6', true );

	wp_enqueue_script( 'sidr', get_template_directory_uri() . '/third-party/sidr/js/jquery.sidr' . $min . '.js', array( 'jquery' ), '2.2.1', true );

	wp_enqueue_script( 'trade-line-custom', get_template_directory_uri() . '/js/custom' . $min . '.js', array( 'jquery' ), '1.3.0', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}
add_action( 'wp_enqueue_scripts', 'trade_line_scripts' );

/**
 * Load init.
 */
//customize read more for post
function custom_excerpt_length( $length ) {
	return 35;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
//custom expert with length
function the_excerpt_max_length($length) {
	$excerpt = get_the_excerpt();
	$length++;

	if ( mb_strlen( $excerpt ) > $length ) {
		$sub = mb_substr( $excerpt, 0, $length - 5 );
		$words = explode( ' ', $sub );
		$cut = - ( mb_strlen( $words[ count( $words ) - 1 ] ) );
		if ( $cut < 0 ) {
			echo mb_substr( $sub, 0, $cut );
		} else {
			echo $sub;
		}
		echo '...';
	} else {
		echo $excerpt;
	}
}

require get_template_directory() . '/inc/init.php';
