<?php
define('THEME_URL',get_stylesheet_directory_uri());
define('CORE',THEME_URL.'/core');
define('ADMIN',THEME_URL.'/admin');
define('THEME_LANGUAGE', THEME_URL."/languages");
load_theme_textdomain('localhost', THEME_LANGUAGE);

require_once ("admin/function-admin.php");
require_once('core/wp_menu_customize.php');
//require_once('core/wp_bootstrap_navwalker.php');
if(!isset($content_width)){
    $content_width = 620 ;
};

if(!function_exists('david_css')){
    function david_css(){
        echo '<link rel="stylesheet" href="'.THEME_URL.'/css/bootstrap.min.css" >';
        echo '<link rel="stylesheet" href="'.THEME_URL.'/css/jquery.videocontrols.css" >';
        echo '<link rel="stylesheet" href="'.THEME_URL.'/style.css" >';
        echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">';
        echo '<script src="'.THEME_URL.'/js/jquery.min.js"></script>';

    }
    add_action('wp_head','david_css');
};

if(!function_exists('david_js')){
    function david_js(){
        echo '<script src="'.THEME_URL.'/js/bootstrap.min.js"></script>';
        echo '<script src="'.THEME_URL.'/js/jquery.videocontrols.js"></script>';
    }
    add_action('wp_footer','david_js');
};

if(!function_exists('david_function_setup')){
    function david_function_setup(){

    }
    add_action('init','david_function_setup');
};

add_theme_support('automatic-feed-links'); // link rss

add_theme_support('post-thumbnails'); // show post thumbnails

add_theme_support('title-tag'); // auto insert title

add_theme_support('post-formats',
    array(
        'video',
        'gallery',
        'image',
        'quote',
        'link',
    )
); // add features formats for post

add_theme_support('custom-background',
    array(
        'default-color' => '#e8e8e8',
    )
); // support customize page background color

register_nav_menu('primary-menu','Primary Menu'); //register a menu

register_nav_menu('top-menu','Top Menu'); //register a menu

register_sidebar(
    array(
        'name'          => 'Main Sidebar',
        'id'            => 'main-sidebar',
        'description'   => 'Main sidebar for david theme',
        'class'         => 'main-sidebar',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    )
); //register a sidebar

//create header, not code in header --> confuse
if (!function_exists('david_logo')){
    function david_logo(){
        echo '<div class="logo">';
            echo '<div class=site-name">';
        if(is_home()){
            printf(
              '<h1><a href="%1$s" title="%2$s"> %3$s </a></h1> ',
                get_bloginfo('url'),
                get_bloginfo('description'),
                get_bloginfo('site-name')
            );
        } else {
            printf(
                '<p><a href="%1$s" title="%2$s"> %3$s </a></p>',
                get_bloginfo('url'),
                get_bloginfo('description'),
                get_bloginfo('site-name')
            );
        } //end if
        echo '</div>';
        echo '<div class="site-description">'.bloginfo('description').'</div>';
        echo '</div>';
    }
}

//customize menu
if(! function_exists('david_menu')){
    function david_menu($slug){ //$slug is primary-menu is declared before
        $menu= array(
            'theme_location'    => $slug,
            'container'         => 'nav',
            'container_class'   => $slug,
        );
        wp_nav_menu($menu);
    }
}

// create pagination for post
if (!function_exists('david_pagination')){
    function david_pagination(){
        // not show pagination if count pages < 2
        if( $GLOBALS['wp_query']->max_num_pages <2 ){
            return '';
        }?>
        <nav class="pagination" role="navigation">
            <?php if( get_next_post_link()) : ?>
            <div class="prev"><?php next_posts_link('Older Posts') ?></div>
            <?php endif; ?>

            <?php if( get_previous_posts_link()) : ?>
            <div class="next"><?php previous_posts_link('Newer Post') ?></div>
            <?php endif; ?>
        </nav>
<?php
    }
}

//show thumbnail in post
if(! function_exists('david_thumbnail')){
    function david_thumbnail($size)
    { //$size configured in dashboard
        //show thumbnail with post no password
        //image don't show in single page but show if image post
        if (!is_single() && has_post_thumbnail() && !post_password_required() || has_post_format('image')) { ?>
                <figure class="thumbnail"><?php the_post_thumbnail($size); ?></figure>
            <?php
        }
    }
}

//show header for post
if (!function_exists('david_entry_header')){
    function david_entry_header(){
        if( is_single()){ ?>
            <h1 class="archive-title">
                <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
                    <?php the_title(); ?>
                </a>
            </h1>
            <?php
        } else {
            ?>
            <h1 class="archive-title">
                <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
                    <?php the_title(); ?>
                </a>
            </h1>
            <?php
        }
    }
}

//show meta - some information about the post author, date,...
if (!function_exists('david_entry_meta')){
    function david_entry_meta(){
        if(!is_single()){
            ?>
        <div class="entry-meta">
            <span class="author-info">Post by <?php  echo get_the_author(); ?></span>
            <span class="date-published">at <?php echo get_the_date(); ?></span>
            <span class="category">in <?php echo get_the_category_list(','); ?></span>
        <?php if(comments_open()){ ?>
             <span class="meta-reply">
                 <?php echo comments_popup_link(
                     'Leave a comment',
                     'One comment',
                     '% comments',
                     'Read all comment'
                 )?>
             </span>
        <?php } ?>
        </div>
        <?php
        }
    }
}

//customize read more for post
function david_read_more(){
    return '...<a class="read-more" href="'.get_permalink( get_the_ID()).'">Read More </a>';
}
add_filter('excerpt_more', 'david_read_more');
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
        echo david_read_more();
    } else {
        echo $excerpt;
    }
}
// show content for post
// include single page and not
// show all of content in single post
if (!function_exists('david_entry_content')){
    function david_entry_content(){
        if(!is_single()){
            the_excerpt();
        }else{
            the_content();
            //code show pagination in single post
            $link_pages= array(
                'before'        => '<p>Page',
                'after'         => '</p>',
                'NextPageLink'  => 'Next Page',
                'PreviousPageLink'  => 'Previous Page',
            );
            wp_link_pages($link_pages);
        }
    }
}

//show tag for post
if(!function_exists('david_entry_tag')){
    function david_entry_tag(){
        if(has_tag()){
            echo '<div class="entry-tag">';
            echo 'Tag in '. get_the_tag_list('',',');
            echo '</div>';
        }
    }
}


//create breadcrumbs
// Breadcrumbs
function custom_breadcrumbs() {

    // Settings
    $separator          = '&gt;';
    $breadcrums_id      = 'breadcrumbs';
    $breadcrums_class   = 'breadcrumbs';
    $home_title         = 'Homepage';

    // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
    $custom_taxonomy    = 'product_cat';

    // Get the query & post information
    global $post,$wp_query;

    // Do not display on the homepage
    if ( !is_front_page() ) {

        // Build the breadcrums
        echo '<ul id="' . $breadcrums_id . '" class="' . $breadcrums_class . '">';

        // Home page
        echo '<li class="item-home"><a class="bread-link bread-home" href="' . get_home_url() . '" title="' . $home_title . '">' . $home_title . '</a></li>';
        echo '<li class="separator separator-home"> ' . $separator . ' </li>';

        if ( is_archive() && !is_tax() && !is_category() && !is_tag() ) {

            echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . post_type_archive_title($prefix, false) . '</strong></li>';

        } else if ( is_archive() && is_tax() && !is_category() && !is_tag() ) {

            // If post is a custom post type
            $post_type = get_post_type();

            // If it is a custom post type display name and link
            if($post_type != 'post') {

                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);

                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';

            }

            $custom_tax_name = get_queried_object()->name;
            echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . $custom_tax_name . '</strong></li>';

        } else if ( is_single() ) {

            // If post is a custom post type
            $post_type = get_post_type();

            // If it is a custom post type display name and link
            if($post_type != 'post') {

                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);

                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';

            }

            // Get post category info
            $category = get_the_category();

            if(!empty($category)) {

                // Get last category post is in
                $last_category = end(array_values($category));

                // Get parent any categories and create array
                $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','),',');
                $cat_parents = explode(',',$get_cat_parents);

                // Loop through parent categories and store in variable $cat_display
                $cat_display = '';
                foreach($cat_parents as $parents) {
                    $cat_display .= '<li class="item-cat">'.$parents.'</li>';
                    $cat_display .= '<li class="separator"> ' . $separator . ' </li>';
                }

            }

            // If it's a custom post type within a custom taxonomy
            $taxonomy_exists = taxonomy_exists($custom_taxonomy);
            if(empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {

                $taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
                $cat_id         = $taxonomy_terms[0]->term_id;
                $cat_nicename   = $taxonomy_terms[0]->slug;
                $cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
                $cat_name       = $taxonomy_terms[0]->name;

            }

            // Check if the post is in a category
            if(!empty($last_category)) {
                echo $cat_display;
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';

                // Else if post is in a custom taxonomy
            } else if(!empty($cat_id)) {

                echo '<li class="item-cat item-cat-' . $cat_id . ' item-cat-' . $cat_nicename . '"><a class="bread-cat bread-cat-' . $cat_id . ' bread-cat-' . $cat_nicename . '" href="' . $cat_link . '" title="' . $cat_name . '">' . $cat_name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';

            } else {

                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';

            }

        } else if ( is_category() ) {

            // Category page
            echo '<li class="item-current item-cat"><strong class="bread-current bread-cat">' . single_cat_title('', false) . '</strong></li>';

        } else if ( is_page() ) {

            // Standard page
            if( $post->post_parent ){

                // If child page, get parents
                $anc = get_post_ancestors( $post->ID );

                // Get parents in the right order
                $anc = array_reverse($anc);

                // Parent page loop
                foreach ( $anc as $ancestor ) {
                    $parents .= '<li class="item-parent item-parent-' . $ancestor . '"><a class="bread-parent bread-parent-' . $ancestor . '" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
                    $parents .= '<li class="separator separator-' . $ancestor . '"> ' . $separator . ' </li>';
                }

                // Display parent pages
                echo $parents;

                // Current page
                echo '<li class="item-current item-' . $post->ID . '"><strong title="' . get_the_title() . '"> ' . get_the_title() . '</strong></li>';

            } else {

                // Just display current page if not parents
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '"> ' . get_the_title() . '</strong></li>';

            }

        } else if ( is_tag() ) {

            // Tag page

            // Get tag information
            $term_id        = get_query_var('tag_id');
            $taxonomy       = 'post_tag';
            $args           = 'include=' . $term_id;
            $terms          = get_terms( $taxonomy, $args );
            $get_term_id    = $terms[0]->term_id;
            $get_term_slug  = $terms[0]->slug;
            $get_term_name  = $terms[0]->name;

            // Display the tag name
            echo '<li class="item-current item-tag-' . $get_term_id . ' item-tag-' . $get_term_slug . '"><strong class="bread-current bread-tag-' . $get_term_id . ' bread-tag-' . $get_term_slug . '">' . $get_term_name . '</strong></li>';

        } elseif ( is_day() ) {

            // Day archive

            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';

            // Month link
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><a class="bread-month bread-month-' . get_the_time('m') . '" href="' . get_month_link( get_the_time('Y'), get_the_time('m') ) . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('m') . '"> ' . $separator . ' </li>';

            // Day display
            echo '<li class="item-current item-' . get_the_time('j') . '"><strong class="bread-current bread-' . get_the_time('j') . '"> ' . get_the_time('jS') . ' ' . get_the_time('M') . ' Archives</strong></li>';

        } else if ( is_month() ) {

            // Month Archive

            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';

            // Month display
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><strong class="bread-month bread-month-' . get_the_time('m') . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</strong></li>';

        } else if ( is_year() ) {

            // Display year archive
            echo '<li class="item-current item-current-' . get_the_time('Y') . '"><strong class="bread-current bread-current-' . get_the_time('Y') . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</strong></li>';

        } else if ( is_author() ) {

            // Auhor archive

            // Get the author information
            global $author;
            $userdata = get_userdata( $author );

            // Display author name
            echo '<li class="item-current item-current-' . $userdata->user_nicename . '"><strong class="bread-current bread-current-' . $userdata->user_nicename . '" title="' . $userdata->display_name . '">' . 'Author: ' . $userdata->display_name . '</strong></li>';

        } else if ( get_query_var('paged') ) {

            // Paginated archives
            echo '<li class="item-current item-current-' . get_query_var('paged') . '"><strong class="bread-current bread-current-' . get_query_var('paged') . '" title="Page ' . get_query_var('paged') . '">'.__('Page') . ' ' . get_query_var('paged') . '</strong></li>';

        } else if ( is_search() ) {

            // Search results page
            echo '<li class="item-current item-current-' . get_search_query() . '"><strong class="bread-current bread-current-' . get_search_query() . '" title="Search results for: ' . get_search_query() . '">Search results for: ' . get_search_query() . '</strong></li>';

        } elseif ( is_404() ) {

            // 404 page
            echo '<li>' . 'Error 404' . '</li>';
        }

        echo '</ul>';

    }

}

