<?php
//require_once ('training/Carousel_Slider_Admin.php');
// test admin
//add my page to to nav admin
if(!function_exists('david_admin_css')){
    function david_admin_css(){
        echo '<link rel="stylesheet" href="'.THEME_URL.'/css/bootstrap.min.css" >';
        echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">';
        echo '<script src="'.THEME_URL.'/js/jquery.min.js"></script>';
        echo '<script src="'.THEME_URL.'/js/bootstrap.min.js"></script>';

    }
    add_action('admin_head','david_admin_css');
};


add_action( 'admin_bar_menu', 'toolbar_link_to_mypage', 999 );

function toolbar_link_to_mypage( $wp_admin_bar ) {
    $args = array(
        'id'    => 'my_page',
        'title' => 'My Page',
        'href'  => 'http://mysite.com/my-page/',
        'meta'  => array( 'class' => 'my-toolbar-page' )
    );
    $wp_admin_bar->add_node( $args );
}
///customize name label in sidebar admin
// Rename Posts to News in Menu
//function wptutsplus_change_post_menu_label() {
//    global $menu;
//    global $submenu;
//    $menu[5][0] = 'News';
//    $submenu['edit.php'][5][0] = 'News Items';
//    $submenu['edit.php'][10][0] = 'Add News Item';
//}
//add_action( 'admin_menu', 'wptutsplus_change_post_menu_label' );
// add menu in sidebar
/**
 * Register a custom menu page.
 */
//add to sidebar
add_action( 'admin_menu', 'wpdocs_register_my_custom_menu_page' );//hook register menu admin
function wpdocs_register_my_custom_menu_page() {
    add_menu_page(
        __( 'Custom Menu Title', 'textdomain' ),
        'custom menu',
        'manage_options',
        'page-custom',
        'create_admin_page',
        'tht',
        99
    );
};
//add to setting
function create_admin_page(){
    ?>
    <div class="wrap">
        <div id="poststuff">
            <div id="post-body" class="metabox-holder columns-2">
                <div id="post-body-content">
                    <div class="meta-box-sortables ui-sortable">
                        <div class="postbox">
                            <h3><span class="dashicons dashicons-admin-generic"></span>Elegant Subscription Popup Settings</h3>
                            <div class="inside">
                                <form method="post" action="options.php">
                                    <?php
                                    // This prints out all hidden setting fields
                                    settings_fields( 'custom_page_group' ); //option group
                                    do_settings_sections( 'custom-page' ); //settings page slug
                                    submit_button(); ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div> <!--post-body-content-->
            </div>
        </div>
    </div>
    <?php
}
//add link page and settings
add_action("admin_init", "custom_page_init");// hook before admin load
function custom_page_init(){

    register_setting(
        'custom_page_group', // Option group dang ky option group su dung de phan biet
        'custom_page_name' // Option name
    );

    add_settings_section( //them 1 section cac field thuoc section
        'custom_page_section_1', // ID
        'thienth3_title', // Title
        'custom_page_section' , // Callback --> goi function in ra html// required
        'custom-page' // Page
    );

    add_settings_field(
        'cus1_id', // ID
        'cus1_id ID', // Title
        'cus1_function' , // Callback --> goi function in ra html
        'custom-page', // Page
        'custom_page_section_1' // Section
    );

    add_settings_field(
        'cus2_id', // ID
        'cus2_id Title', // Title
        'cus2_function', // Callback --> goi function in ra html
        'custom-page', // Page
        'custom_page_section_1' // Section
    );

    add_settings_field(
        'cus3_id', // ID
        'cus3_id Description', // Title
        'cus3_function', // Callback
        'custom-page', // Page
        'custom_page_section_1' // Section
    );

    add_settings_field(
        'cus4_id', // ID
        'cus4_id Logo', // Title
         'cus3_function' , // Callback
        'custom-page', // Page
        'custom_page_section_1' // Section
    );
    function custom_page_section(){

    }

    function cus1_function(){
        printf('<input type="text" id="feedBurner_id" name="custom_page[cus1_id]" value="%s" />',  isset( $options['cus1_id'] ) ? esc_attr( $options['cus1_id']) : '');
    }

    function cus2_function(){
        printf('<input type="text" id="popup_title" name="custom_page[cus1_id]" value="%s" />',  isset( $options['popup_title'] ) ? esc_attr( $options['popup_title']) : '');
    }

    function cus3_function(){
        printf('<textarea id="popup_description" rows="4" class="large-text" name="custom_page[cus1_id]">%s</textarea>',  isset( $options['popup_description'] ) ? esc_attr( $options['popup_description']) : '');
    }
}

//register post type -- post type events
function events_init() {
    $labels = array(
//        'name'                  => _x( 'Post Type', 'Post Type General Name', 'text_domain' ),
//        'singular_name'         => _x( 'Post Type', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'             => __( 'Events', 'text_domain' ),
//        'name_admin_bar'        => __( 'Post Type', 'text_domain' ),
        'archives'              => __( 'Item Archives', 'text_domain' ),
        'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
        'all_items'             => __( 'All Events', 'text_domain' ),
//        'add_new_item'          => __( 'Add New Event', 'text_domain' ),
        'add_new'               => __( 'Add New Event', 'text_domain' ),
        'new_item'              => __( 'New Event', 'text_domain' ),
        'edit_item'             => __( 'Edit Event', 'text_domain' ),
        'update_item'           => __( 'Update Event', 'text_domain' ),
        'view_item'             => __( 'View Event', 'text_domain' ),
        'search_items'          => __( 'Search Event', 'text_domain' ),
        'not_found'             => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
        'featured_image'        => __( 'Featured Image', 'text_domain' ),
        'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
        'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
        'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
        'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
        'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
        'items_list'            => __( 'Items list', 'text_domain' ),
        'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
        'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
    );
    $args = array(
        'label'                 => __( 'Post Type', 'text_domain' ),
        'description'           => __( 'Post Type Description', 'text_domain' ),
        'labels'                => $labels,
        'title'                 => __( 'Upcoming Events', 'text_domain' ),
        'supports'              => array( 'title', 'editor', 'thumbnail'),
        'taxonomies'            => array( 'category', 'post_tag' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
    );
    register_post_type('events', $args);
}
add_action('init', 'events_init');

// add custom field for admin post

/********************************************************************/
/* UNITS CUSTOM FIELDS */
/*********************************************************************/
add_action( 'admin_init', 'time_type_event_admin' );

function time_type_event_admin() {
    add_meta_box(
        'time_type_event_admin',
        'Event time', // name display
        'display_time_type_meta_box',
        'events',// for post type
        'normal',
        'high'
    );
}

function display_time_type_meta_box( $time_type ) {
    $event_date= esc_html( get_post_meta( $time_type->ID, 'event-date', true) );
    $event_time_begin= esc_html( get_post_meta( $time_type->ID, 'event-time-begin', true) );
    $event_time_end= esc_html( get_post_meta( $time_type->ID, 'event-time-end', true) );
    ?>
    <label for="event-date">Day held: </label>
    <input type="date" id="event-time" name="event-date"" value="<?php echo $event_date; ?>" /><br />

    <label for="event-time-begin">Time begin: </label>
    <input type="time" id="event-time-begin" name="event-time-begin" value="<?php echo $event_time_begin; ?>" /><br />

    <label for="event-time-end">Time end: </label>
    <input type="time" id="event-time-end" name="event-time-end" value="<?php echo $event_time_end; ?>" /><br />
    <?php

}

add_action( 'save_post', 'time_type_fields', 10, 2 );

function time_type_fields( $time_type_id, $time_type) {
    if ( $time_type->post_type == 'events') { // need to notice
        if ( isset( $_POST['event-date'] ) && $_POST['event-date'] != '' ) {
            update_post_meta( $time_type_id, 'event_date', $_POST['event-date'] );
        }
        if ( isset( $_POST['event-time-begin'] ) && $_POST['event-time-begin'] != '' ) {
            update_post_meta( $time_type_id, 'event_time_begin', $_POST['event-time-begin'] );
        }
        if ( isset( $_POST['event-time-end'] ) && $_POST['event-time-end'] != '' ) {
            update_post_meta( $time_type_id, 'event_time_end', $_POST['event-time-end'] );
        }
    }
}

//end post type events
// create post type news
function news_init() {
    $labels = array(
        'menu_name'             => __( 'News', 'text_domain' ),
        'archives'              => __( 'Item Archives', 'text_domain' ),
        'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
        'all_items'             => __( 'All News', 'text_domain' ),
        'add_new'               => __( 'Add New News', 'text_domain' ),
        'new_item'              => __( 'New News', 'text_domain' ),
        'edit_item'             => __( 'Edit News', 'text_domain' ),
        'update_item'           => __( 'Update News', 'text_domain' ),
        'view_item'             => __( 'View News', 'text_domain' ),
        'search_items'          => __( 'Search News', 'text_domain' ),
        'not_found'             => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
        'featured_image'        => __( 'Featured Image', 'text_domain' ),
        'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
        'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
        'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
        'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
        'uploaded_to_this_item' => __( 'Uploaded to this news', 'text_domain' ),
        'items_list'            => __( 'News list', 'text_domain' ),
        'items_list_navigation' => __( 'News list navigation', 'text_domain' ),
        'filter_items_list'     => __( 'Filter News list', 'text_domain' ),
    );
    $args = array(
        'label'                 => __( 'News Type', 'text_domain' ),
        'description'           => __( 'News Type Description', 'text_domain' ),
        'labels'                => $labels,
        'title'                 => __( 'School News', 'text_domain' ),
        'supports'              => array( 'title', 'editor', 'thumbnail'),
        'taxonomies'            => array( 'category', 'post_tag' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
    );
    register_post_type('news', $args);
}
add_action('init', 'news_init');

//film type post
function films_init() {
    $labels = array(
        'menu_name'             => __( 'Films', 'text_domain' ),
        'archives'              => __( 'Film Archives', 'text_domain' ),
        'parent_item_colon'     => __( 'Parent Film:', 'text_domain' ),
        'all_items'             => __( 'All Films', 'text_domain' ),
        'add_new'               => __( 'Add New Film', 'text_domain' ),
        'new_item'              => __( 'New Film', 'text_domain' ),
        'edit_item'             => __( 'Edit Film', 'text_domain' ),
        'update_item'           => __( 'Update Film', 'text_domain' ),
        'view_item'             => __( 'View Film', 'text_domain' ),
        'search_items'          => __( 'Search Film', 'text_domain' ),
        'not_found'             => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
        'featured_image'        => __( 'Featured Image', 'text_domain' ),
        'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
        'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
        'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
        'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
        'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
        'items_list'            => __( 'Films list', 'text_domain' ),
        'items_list_navigation' => __( 'Films list navigation', 'text_domain' ),
        'filter_items_list'     => __( 'Filter Films list', 'text_domain' ),
    );
    $args = array(
        'label'                 => __( 'Film Type', 'text_domain' ),
        'description'           => __( 'Film Type Description', 'text_domain' ),
        'labels'                => $labels,
        'title'                 => __( 'Upcoming Films', 'text_domain' ),
        'supports'              => array( 'title', 'editor', 'thumbnail'),
        'taxonomies'            => array( 'category', 'Film_tag' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
    );
    register_post_type('films', $args);
}
add_action('init', 'films_init');
//custom field for film
/********************************************************************/
/* UNITS CUSTOM FIELDS */
/*********************************************************************/
add_action( 'admin_init', 'cus_film_admin' );

function cus_film_admin() {
    add_meta_box(
        'time_type_event_admin',
        'Thông tin thêm', // name display
        'display_film_type_meta_box',
        'films',// for post type
        'normal',
        'high'
    );
}

function display_film_type_meta_box( $time_type ) {
    $film_star= esc_html( get_post_meta( $time_type->ID, 'film-star', true) );
    $film_source= esc_html( get_post_meta( $time_type->ID, 'film-source', true) );
    $film_sub= esc_html( get_post_meta( $time_type->ID, 'film-sub', true) );
    ?>
    <label for="film-star">Nổi bật: </label>
    <input type="checkbox" id="film-star" name="film-star" value="1"/><br />
    <input type="hidden" name="film-source" id="film-source" value="<?php echo $film_source; ?>">
    <input type="hidden" name="film-sub" id="film-sub" value="<?php echo $film_sub; ?>">
    <?php

}

add_action( 'save_post', 'film_type_fields', 10, 2 );

function film_type_fields( $film_type_id, $time_type) {
    if ( $time_type->post_type == 'films') { // need to notice
        if ( isset( $_POST['film-star'] ) && $_POST['film-star'] != '' ) {
            update_post_meta( $film_type_id, 'film_star', $_POST['film-star'] );
        }
        if ( isset( $_POST['film-source'] ) && $_POST['film-source'] != '' ) {
            update_post_meta( $film_type_id, 'film_source', $_POST['film-source'] );
        }
        if ( isset( $_POST['film-sub'] ) && $_POST['film-sub'] != '' ) {
            update_post_meta( $film_type_id, 'film_sub', $_POST['film-sub'] );
        }
    }
}

// add content film modal
add_action('admin_footer-post-new.php', 'modal_hook'); // insert modal to page
add_action('admin_footer-post.php', 'modal_hook'); // insert modal to page
function modal_hook(){
    ?>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Modal title</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="link-film" class="col-sm-3 control-label">Link film:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="link-film" value="" placeholder="nhập link vào đây!">
                        </div>
                    </div>
                </div>
                <div class="modal-footer col-ms-12">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Thoát</button>
                    <button type="button" class="btn btn-primary" id="sub-link-film">Lưu</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
<?php
}
// add embed support
wp_oembed_add_provider( 'http://site.com/watchvideo/*', 'http://site.com/oembedprovider' );
wp_oembed_add_provider( 'http://media.studyphim.vn/*', 'http://site.com/oembedprovider' );
// add media bottom
add_action('media_buttons', 'add_my_media_button');
function add_my_media_button() {
    echo '<a href="#" id="insert-link-film" class="button" data-toggle="modal" data-target="#myModal">Add link film</a>';
    echo '<a href="#" id="insert-sub-film" class="button">Add subtitle</a>';
}
//register js
function include_media_button_js_file() {
    wp_enqueue_script('media_button', THEME_URL.'/js/film_media_button.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_media', 'include_media_button_js_file');

// new tab to new media
add_filter('media_upload_tabs', 'my_upload_tab');
function my_upload_tab($tabs) {
    $tabs['mytabname'] = "My Tab Name";
    return $tabs;
}

// call the new tab with wp_iframe
add_action('media_upload_mytabname', 'add_my_new_form');
function add_my_new_form() {
    wp_iframe( 'my_new_form' );
}

// the tab content
function my_new_form() {
    echo media_upload_header(); // This function is used for print media uploader headers etc.
    echo '<p>Example HTML content goes here.</p>';
}
add_action('edit_form_after_title', 'add_div_before_editor');
function add_div_before_editor(){
    echo '<div id="film-preview"> </div>';
    echo '<div id="film-sub-preview"> </div>';
}

