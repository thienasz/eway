<?php
/**
 * Theme Options related to featured content.
 *
 * @package Trade_Line
 */

$default = trade_line_get_default_theme_options();

// Add Featured Content Panel.
$wp_customize->add_panel( 'theme_featured_content_panel',
	array(
		'title'      => __( 'Featured Content', 'trade-line' ),
		'priority'   => 100,
		'capability' => 'edit_theme_options',
	)
);

// Featured Content Type Section.
$wp_customize->add_section( 'section_theme_featured_content_type',
	array(
		'title'      => __( 'Featured Content Type', 'trade-line' ),
		'priority'   => 100,
		'capability' => 'edit_theme_options',
		'panel'      => 'theme_featured_content_panel',
	)
);

// Setting featured_content_status.
$wp_customize->add_setting( 'theme_options[featured_content_status]',
	array(
		'default'           => $default['featured_content_status'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'trade_line_sanitize_select',
	)
);
$wp_customize->add_control( 'theme_options[featured_content_status]',
	array(
		'label'    => __( 'Enable Featured Content', 'trade-line' ),
		'section'  => 'section_theme_featured_content_type',
		'type'     => 'select',
		'priority' => 100,
		'choices'  => trade_line_get_featured_content_status_options(),
	)
);

// Setting featured_content_number.
$wp_customize->add_setting( 'theme_options[featured_content_number]',
	array(
		'default'           => $default['featured_content_number'],
		'capability'        => 'edit_theme_options',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'trade_line_sanitize_select',
	)
);
$wp_customize->add_control( 'theme_options[featured_content_number]',
	array(
		'label'           => __( 'No of Blocks', 'trade-line' ),
		'description'     => __( 'Save and refresh the page if No is changed. ', 'trade-line' ),
		'section'         => 'section_theme_featured_content_type',
		'type'            => 'select',
		'priority'        => 100,
		'choices'         => array( 3 => 3, 4 => 4 ),
		'active_callback' => 'trade_line_is_featured_content_active',
	)
);

// Setting featured_content_type.
$wp_customize->add_setting( 'theme_options[featured_content_type]',
	array(
		'default'           => $default['featured_content_type'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'esc_attr',
	)
);
$wp_customize->add_control( 'theme_options[featured_content_type]',
	array(
		'section'         => 'section_theme_featured_content_type',
		'type'            => 'hidden',
		'priority'        => 100,
		'active_callback' => 'trade_line_is_featured_content_active',
	)
);

$featured_content_number = absint( trade_line_get_option( 'featured_content_number' ) );

if ( $featured_content_number > 0 ) {
	for ( $i = 1; $i <= $featured_content_number; $i++ ) {
		$wp_customize->add_setting( "theme_options[featured_content_page_$i]",
			array(
				'default'           => isset( $default[ 'featured_content_page_' .$i ] ) ? $default[ 'featured_content_page_' .$i ] : '',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'trade_line_sanitize_dropdown_pages',
			)
		);
		$wp_customize->add_control( "theme_options[featured_content_page_$i]",
			array(
				'label'           => __( 'Featured Page', 'trade-line' ) . ' #' . $i,
				'section'         => 'section_theme_featured_content_type',
				'type'            => 'dropdown-pages',
				'priority'        => 100,
				'active_callback' => 'trade_line_is_featured_page_content_active',
			)
		);
	} // End for loop.
}

// Setting featured_content_excerpt_length.
$wp_customize->add_setting( 'theme_options[featured_content_excerpt_length]',
	array(
		'default'           => $default['featured_content_excerpt_length'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'trade_line_sanitize_positive_integer',
	)
);
$wp_customize->add_control( 'theme_options[featured_content_excerpt_length]',
	array(
		'label'           => __( 'Content Excerpt Length', 'trade-line' ),
		'section'         => 'section_theme_featured_content_type',
		'type'            => 'number',
		'priority'        => 100,
		'input_attrs'     => array( 'min' => 1, 'max' => 500, 'style' => 'width: 55px;' ),
		'active_callback' => 'trade_line_is_featured_content_active',
	)
);
