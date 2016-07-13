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
//		add_theme_support( 'post-formats', array(
//			'aside',
//			'image',
//			'video',
//			'quote',
//			'link',
//		) );

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


// create custom plugin settings menu
add_action('admin_menu', 'my_cool_plugin_create_menu');

function my_cool_plugin_create_menu() {

	//create new top-level menu
	add_menu_page('My home Settings', 'Home Settings', 'administrator', __FILE__, 'my_cool_plugin_settings_page');

	//call register settings function
	add_action( 'admin_init', 'register_my_cool_plugin_settings' );
}


function register_my_cool_plugin_settings() {
	//register our settings
	register_setting( 'my-cool-plugin-settings-group', 'value_section_1' );
	register_setting( 'my-cool-plugin-settings-group', 'title_section_1' );
	register_setting( 'my-cool-plugin-settings-group', 'value_section_21' );
	register_setting( 'my-cool-plugin-settings-group', 'title_section_2' );
	register_setting( 'my-cool-plugin-settings-group', 'value_section_22' );
	register_setting( 'my-cool-plugin-settings-group', 'title_section_21' );
	register_setting( 'my-cool-plugin-settings-group', 'title_section_22' );
	register_setting( 'my-cool-plugin-settings-group', 'value_section_3' );
}

function my_cool_plugin_settings_page() {
	?>
	<div class="wrap">
		<h2>Home section settings </h2>

		<form method="post" action="options.php">
			<?php settings_fields( 'my-cool-plugin-settings-group' ); ?>
			<?php do_settings_sections( 'my-cool-plugin-settings-group' ); ?>
			<table class="form-table">

				<tr valign="top">
					<th scope="row">Title for section 1</th>
					<td><input type="text" name="title_section_1" value="<?php echo esc_attr( get_option('title_section_1') ); ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">Category for section 1</th>
					<td>
						<select name="value_section_1">
							<?php
							$cates = get_categories();
							foreach ($cates as $cate){
								echo '<option ';
								echo 'value = "'.$cate->slug.'"';
								if($cate->slug == get_option('value_section_1') ) echo 'selected';
								echo '>';
								echo esc_html( $cate->name );
								echo '</option>';
							}
							?>
						</select>
					</td>
				</tr>


				<tr valign="top">
					<th scope="row">Title for section 2</th>
					<td><input type="text" name="title_section_2" value="<?php echo esc_attr( get_option('title_section_2') ); ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">Title for left section 2</th>
					<td><input type="text" name="title_section_21" value="<?php echo esc_attr( get_option('title_section_21') ); ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">Category for left section 2</th>
					<td>
						<select name="value_section_21">
							<?php
							$cates = get_categories();
							foreach ($cates as $cate){
								echo '<option ';
								echo 'value = "'.$cate->slug.'"';
								if($cate->slug == get_option('value_section_21') ) echo 'selected';
								echo '>';
								echo esc_html( $cate->name );
								echo '</option>';
							}
							?>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Title for right section 2</th>
					<td><input type="text" name="title_section_22" value="<?php echo esc_attr( get_option('title_section_22') ); ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">Category for right section 2</th>
					<td>
						<select name="value_section_22">
							<?php
							$cates = get_categories();
							foreach ($cates as $cate){
								echo '<option ';
								echo 'value = "'.$cate->slug.'"';
								if($cate->slug == get_option('value_section_22') ) echo 'selected';
								echo '>';
								echo esc_html( $cate->name );
								echo '</option>';
							}
							?>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Category for slider</th>
					<td>
						<select name="value_section_3">
							<?php
							$cates = get_categories();
							foreach ($cates as $cate){
								echo '<option ';
								echo 'value = "'.$cate->slug.'"';
								if($cate->slug == get_option('value_section_3') ) echo 'selected';
								echo '>';
								echo esc_html( $cate->name );
								echo '</option>';
							}
							?>
						</select>
					</td>
				</tr>

			</table>

			<?php submit_button(); ?>

		</form>
	</div>
<?php } ?>

<?php
	/* Define the custom box */

	// WP 3.0+
	add_action( 'add_meta_boxes', 'post_options_metabox' );

	// backwards compatible
	add_action( 'admin_init', 'post_options_metabox', 1 );

	/* Do something with the data entered */
	add_action( 'save_post', 'save_post_options' );

	/**
	*  Adds a box to the main column on the Post edit screen
	*
	*/
	function post_options_metabox() {
	add_meta_box( 'post_options', __( 'Post Options' ), 'post_options_code', 'post', 'normal', 'high' );
	}

	/**
	*  Prints the box content
	*/
	function post_options_code( $post ) {
	wp_nonce_field( plugin_basename( __FILE__ ), $post->post_type . '_noncename' );
	$meta_info = get_post_meta( $post->ID, 'malked_post', true) ? get_post_meta( $post->ID, 'malked_post', true) : 1; ?>
	<div class="alignleft">
		<input id="meta_default" type="radio" name="malked_post" value="5"<?php checked( '5', $meta_info ); ?> /> <label for="meta_default" class="selectit"><?php _e( 'Bài viết nổi bật' ); ?></label><br />
		<input id="show_meta" type="radio" name="malked_post" value="0"<?php checked( '0', $meta_info ); ?> <?php echo ( $meta_info == 1 )?' checked="checked"' : ''; ?>/> <label for="show_meta" class="selectit"><?php _e( 'Hủy nổi bật' ); ?></label><br />
	</div>
	<div class="clear"></div>
	<?php
}

/**
 * When the post is saved, saves our custom data
 */
function save_post_options( $post_id ) {
	// verify if this is an auto save routine.
	// If it is our form has not been submitted, so we dont want to do anything
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return;

	// verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times
	if ( !wp_verify_nonce( @$_POST[$_POST['post_type'] . '_noncename'], plugin_basename( __FILE__ ) ) )
		return;

	// Check permissions
	if ( !current_user_can( 'edit_post', $post_id ) )
		return;

	// OK, we're authenticated: we need to find and save the data
	if( 'post' == $_POST['post_type'] ) {
		if ( !current_user_can( 'edit_post', $post_id ) ) {
			return;
		} else {
			update_post_meta( $post_id, 'malked_post', $_POST['malked_post'] );
		}
	}

}
function wpb_widgets_init() {

	register_sidebar( array(
		'name' => __( 'Top header', 'wpb' ),
		'id' => 'sidebar-top',
		'description' => __( 'in header', 'wpb' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => '',
	) );

}

add_action( 'widgets_init', 'wpb_widgets_init' );