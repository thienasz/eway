<?php
/**
 * Theme Options.
 *
 * @package Trade_Line
 */

$default = trade_line_get_default_theme_options();

// Add Panel.
$wp_customize->add_panel( 'theme_option_panel',
	array(
	'title'      => __( 'Theme Options', 'trade-line' ),
	'priority'   => 100,
	'capability' => 'edit_theme_options',
	)
);

// Header Section.
$wp_customize->add_section( 'section_header',
	array(
	'title'      => __( 'Header Options', 'trade-line' ),
	'priority'   => 100,
	'capability' => 'edit_theme_options',
	'panel'      => 'theme_option_panel',
	)
);

if ( ! function_exists( 'the_custom_logo' ) ) {
	// Setting site_logo.
	$wp_customize->add_setting( 'theme_options[site_logo]',
		array(
		'default'           => $default['site_logo'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'trade_line_sanitize_image',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control( $wp_customize, 'theme_options[site_logo]',
			array(
			'label'       => __( 'Logo', 'trade-line' ),
			'section'     => 'section_header',
			'settings'    => 'theme_options[site_logo]',
			)
		)
	);
}

// Setting show_title.
$wp_customize->add_setting( 'theme_options[show_title]',
	array(
	'default'           => $default['show_title'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'trade_line_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'theme_options[show_title]',
	array(
	'label'    => __( 'Show Site Title', 'trade-line' ),
	'section'  => 'section_header',
	'type'     => 'checkbox',
	'priority' => 100,
	)
);
// Setting show_tagline.
$wp_customize->add_setting( 'theme_options[show_tagline]',
	array(
	'default'           => $default['show_tagline'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'trade_line_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'theme_options[show_tagline]',
	array(
	'label'    => __( 'Show Tagline', 'trade-line' ),
	'section'  => 'section_header',
	'type'     => 'checkbox',
	'priority' => 100,
	)
);

// Setting social_in_header.
$wp_customize->add_setting( 'theme_options[social_in_header]',
	array(
		'default'           => $default['social_in_header'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'trade_line_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'theme_options[social_in_header]',
	array(
		'label'    => __( 'Enable Social Icons', 'trade-line' ),
		'section'  => 'section_header',
		'type'     => 'checkbox',
		'priority' => 100,
	)
);

$wp_customize->add_setting( 'theme_options[search_in_header]',
	array(
		'default'           => $default['search_in_header'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'trade_line_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'theme_options[search_in_header]',
	array(
		'label'    => __( 'Enable Search Form', 'trade-line' ),
		'section'  => 'section_header',
		'type'     => 'checkbox',
		'priority' => 100,
	)
);

// Layout Section.
$wp_customize->add_section( 'section_layout',
	array(
	'title'      => __( 'Layout Options', 'trade-line' ),
	'priority'   => 100,
	'capability' => 'edit_theme_options',
	'panel'      => 'theme_option_panel',
	)
);

// Setting global_layout.
$wp_customize->add_setting( 'theme_options[global_layout]',
	array(
	'default'           => $default['global_layout'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'trade_line_sanitize_select',
	)
);
$wp_customize->add_control( 'theme_options[global_layout]',
	array(
	'label'    => __( 'Global Layout', 'trade-line' ),
	'section'  => 'section_layout',
	'type'     => 'select',
	'choices'  => trade_line_get_global_layout_options(),
	'priority' => 100,
	)
);
// Setting archive_layout.
$wp_customize->add_setting( 'theme_options[archive_layout]',
	array(
	'default'           => $default['archive_layout'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'trade_line_sanitize_select',
	)
);
$wp_customize->add_control( 'theme_options[archive_layout]',
	array(
	'label'    => __( 'Archive Layout', 'trade-line' ),
	'section'  => 'section_layout',
	'type'     => 'select',
	'choices'  => trade_line_get_archive_layout_options(),
	'priority' => 100,
	)
);
// Setting archive_image.
$wp_customize->add_setting( 'theme_options[archive_image]',
	array(
	'default'           => $default['archive_image'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'trade_line_sanitize_select',
	)
);
$wp_customize->add_control( 'theme_options[archive_image]',
	array(
	'label'    => __( 'Image in Archive', 'trade-line' ),
	'section'  => 'section_layout',
	'type'     => 'select',
	'choices'  => trade_line_get_image_sizes_options( true, array( 'disable', 'thumbnail', 'medium', 'large', 'trade-line-thumb' ) ),
	'priority' => 100,
	)
);
// Setting archive_image_alignment.
$wp_customize->add_setting( 'theme_options[archive_image_alignment]',
	array(
	'default'           => $default['archive_image_alignment'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'trade_line_sanitize_select',
	)
);
$wp_customize->add_control( 'theme_options[archive_image_alignment]',
	array(
	'label'    => __( 'Image Alignment in Archive', 'trade-line' ),
	'section'  => 'section_layout',
	'type'     => 'select',
	'choices'  => trade_line_get_image_alignment_options(),
	'priority' => 100,
	)
);
// Setting single_image.
$wp_customize->add_setting( 'theme_options[single_image]',
	array(
	'default'           => $default['single_image'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'trade_line_sanitize_select',
	)
);
$wp_customize->add_control( 'theme_options[single_image]',
	array(
	'label'    => __( 'Image in Single Post/Page', 'trade-line' ),
	'section'  => 'section_layout',
	'type'     => 'select',
	'choices'  => trade_line_get_image_sizes_options( true, array( 'disable', 'large' ), false ),
	'priority' => 100,
	)
);

// Pagination Section.
$wp_customize->add_section( 'section_pagination',
	array(
	'title'      => __( 'Pagination Options', 'trade-line' ),
	'priority'   => 100,
	'capability' => 'edit_theme_options',
	'panel'      => 'theme_option_panel',
	)
);

// Setting pagination_type.
$wp_customize->add_setting( 'theme_options[pagination_type]',
	array(
	'default'           => $default['pagination_type'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'trade_line_sanitize_select',
	)
);
$wp_customize->add_control( 'theme_options[pagination_type]',
	array(
	'label'       => __( 'Pagination Type', 'trade-line' ),
	'section'     => 'section_pagination',
	'type'        => 'select',
	'choices'     => trade_line_get_pagination_type_options(),
	'priority'    => 100,
	)
);

// Footer Section.
$wp_customize->add_section( 'section_footer',
	array(
	'title'      => __( 'Footer Options', 'trade-line' ),
	'priority'   => 100,
	'capability' => 'edit_theme_options',
	'panel'      => 'theme_option_panel',
	)
);

// Setting copyright_text.
$wp_customize->add_setting( 'theme_options[copyright_text]',
	array(
	'default'           => $default['copyright_text'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'trade_line_sanitize_footer_content',
	)
);
$wp_customize->add_control( 'theme_options[copyright_text]',
	array(
	'label'    => __( 'Copyright Text', 'trade-line' ),
	'section'  => 'section_footer',
	'type'     => 'text',
	'priority' => 100,
	)
);

// Blog Section.
$wp_customize->add_section( 'section_blog',
	array(
	'title'      => __( 'Blog Options', 'trade-line' ),
	'priority'   => 100,
	'capability' => 'edit_theme_options',
	'panel'      => 'theme_option_panel',
	)
);

// Setting excerpt_length.
$wp_customize->add_setting( 'theme_options[excerpt_length]',
	array(
	'default'           => $default['excerpt_length'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'trade_line_sanitize_positive_integer',
	)
);
$wp_customize->add_control( 'theme_options[excerpt_length]',
	array(
	'label'       => __( 'Excerpt Length', 'trade-line' ),
	'description' => __( 'in words', 'trade-line' ),
	'section'     => 'section_blog',
	'type'        => 'number',
	'priority'    => 100,
	'input_attrs' => array( 'min' => 1, 'max' => 200, 'style' => 'width: 55px;' ),
	)
);
// Setting read_more_text.
$wp_customize->add_setting( 'theme_options[read_more_text]',
	array(
	'default'           => $default['read_more_text'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control( 'theme_options[read_more_text]',
	array(
	'label'    => __( 'Read More Text', 'trade-line' ),
	'section'  => 'section_blog',
	'type'     => 'text',
	'priority' => 100,
	)
);

// Setting exclude_categories.
$wp_customize->add_setting( 'theme_options[exclude_categories]',
	array(
	'default'           => $default['exclude_categories'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control( 'theme_options[exclude_categories]',
	array(
	'label'       => __( 'Exclude Categories in Blog', 'trade-line' ),
	'description' => __( 'Enter category ID to exclude in Blog Page. Separate with comma if more than one', 'trade-line' ),
	'section'     => 'section_blog',
	'type'        => 'text',
	'priority'    => 100,
	)
);

// Author Bio Section.
$wp_customize->add_section( 'section_author_bio',
	array(
		'title'       => __( 'Author Bio Options', 'trade-line' ),
		'description' => __( 'Author Box will be displayed in the single post article.', 'trade-line' ),
		'priority'    => 100,
		'capability'  => 'edit_theme_options',
		'panel'       => 'theme_option_panel',
	)
);
// Setting author_bio_in_single.
$wp_customize->add_setting( 'theme_options[author_bio_in_single]',
	array(
		'default'           => $default['author_bio_in_single'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'trade_line_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'theme_options[author_bio_in_single]',
	array(
		'label'    => __( 'Show Author Bio', 'trade-line' ),
		'section'  => 'section_author_bio',
		'type'     => 'checkbox',
		'priority' => 100,
	)
);

// Breadcrumb Section.
$wp_customize->add_section( 'section_breadcrumb',
	array(
	'title'      => __( 'Breadcrumb Options', 'trade-line' ),
	'priority'   => 100,
	'capability' => 'edit_theme_options',
	'panel'      => 'theme_option_panel',
	)
);

// Setting breadcrumb_type.
$wp_customize->add_setting( 'theme_options[breadcrumb_type]',
	array(
	'default'           => $default['breadcrumb_type'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'trade_line_sanitize_select',
	)
);
$wp_customize->add_control( 'theme_options[breadcrumb_type]',
	array(
	'label'       => __( 'Breadcrumb Type', 'trade-line' ),
	'description' => sprintf( __( 'Advanced: Requires %sBreadcrumb NavXT%s plugin', 'trade-line' ), '<a href="https://wordpress.org/plugins/breadcrumb-navxt/" target="_blank">','</a>' ),
	'section'     => 'section_breadcrumb',
	'type'        => 'select',
	'choices'     => trade_line_get_breadcrumb_type_options(),
	'priority'    => 100,
	)
);

// Advanced Section.
$wp_customize->add_section( 'section_advanced',
	array(
	'title'      => __( 'Advanced Options', 'trade-line' ),
	'priority'   => 100,
	'capability' => 'edit_theme_options',
	'panel'      => 'theme_option_panel',
	)
);

// Setting custom_css.
$wp_customize->add_setting( 'theme_options[custom_css]',
	array(
	'default'              => $default['custom_css'],
	'capability'           => 'edit_theme_options',
	'sanitize_callback'    => 'wp_strip_all_tags',
	)
);
$wp_customize->add_control( 'theme_options[custom_css]',
	array(
	'label'    => __( 'Custom CSS', 'trade-line' ),
	'section'  => 'section_advanced',
	'type'     => 'textarea',
	'choices'  => trade_line_get_breadcrumb_type_options(),
	'priority' => 100,
	)
);

