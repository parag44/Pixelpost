<?php
/**
 * Pixelpost Theme Customizer Setup & Controls
 *
 * @package Pixelpost
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Customizer settings and controls
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function pixelpost_customize_register( $wp_customize ) {

	// Ensure repeater control class is loaded
	if ( ! class_exists( 'Pixelpost_Repeater_Control' ) ) {
		require_once get_template_directory() . '/inc/class-pixelpost-repeater-control.php';
	}

	// Selective refresh for postMessage settings
	if ( $wp_customize->get_setting( 'blogname' ) ) {
		$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	}
	if ( $wp_customize->get_setting( 'blogdescription' ) ) {
		$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
	}

	/* ==========================================================================
	   PANEL 1: GLOBAL THEME SETTINGS
	   ========================================================================== */
	$wp_customize->add_panel(
		'pixelpost_theme_options',
		array(
			'title'       => __( 'Pixelpost: Global Settings', 'pixelpost' ),
			'description' => __( 'Site-wide configuration: colors, header, footer, and SEO meta tags.', 'pixelpost' ),
			'priority'    => 25,
		)
	);

	/* ==========================================================================
	   PANEL 2: HOMEPAGE SECTIONS
	   ========================================================================== */
	$wp_customize->add_panel(
		'pixelpost_homepage_panel',
		array(
			'title'       => __( 'Pixelpost: Homepage Sections', 'pixelpost' ),
			'description' => __( 'Configure and toggle individual homepage sections in top-to-bottom order.', 'pixelpost' ),
			'priority'    => 26,
		)
	);

	/* ==========================================================================
	   SECTION: GLOBAL DESIGN & COLORS
	   ========================================================================== */
	$wp_customize->add_section(
		'pixelpost_design_section',
		array(
			'title'    => __( 'Global Design & Colors', 'pixelpost' ),
			'panel'    => 'pixelpost_theme_options',
			'priority' => 10,
		)
	);

	// Background Color
	$wp_customize->add_setting(
		'pixelpost_color_bg',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_color_bg' ),
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'pixelpost_color_bg',
			array(
				'label'   => __( 'Primary Background Color', 'pixelpost' ),
				'section' => 'pixelpost_design_section',
			)
		)
	);

	// Surface Color
	$wp_customize->add_setting(
		'pixelpost_color_surface',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_color_surface' ),
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'pixelpost_color_surface',
			array(
				'label'   => __( 'Surface / Card Background Color', 'pixelpost' ),
				'section' => 'pixelpost_design_section',
			)
		)
	);

	// Primary Text Color
	$wp_customize->add_setting(
		'pixelpost_color_text',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_color_text' ),
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'pixelpost_color_text',
			array(
				'label'   => __( 'Text Color', 'pixelpost' ),
				'section' => 'pixelpost_design_section',
			)
		)
	);

	// Accent Color
	$wp_customize->add_setting(
		'pixelpost_color_accent',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_color_accent' ),
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'pixelpost_color_accent',
			array(
				'label'   => __( 'Accent Color (Terracotta)', 'pixelpost' ),
				'section' => 'pixelpost_design_section',
			)
		)
	);

	// Border Color
	$wp_customize->add_setting(
		'pixelpost_color_border',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_color_border' ),
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'pixelpost_color_border',
			array(
				'label'   => __( 'Border Divider Color', 'pixelpost' ),
				'section' => 'pixelpost_design_section',
			)
		)
	);

	// Container Max Width
	$wp_customize->add_setting(
		'pixelpost_container_max_width',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_container_max_width' ),
			'sanitize_callback' => 'absint',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'pixelpost_container_max_width',
		array(
			'label'       => __( 'Content Max Width (px)', 'pixelpost' ),
			'section'     => 'pixelpost_design_section',
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 960,
				'max'  => 1400,
				'step' => 20,
			),
		)
	);

	/* ==========================================================================
	   SECTION: HEADER
	   ========================================================================== */
	$wp_customize->add_section(
		'pixelpost_header_section',
		array(
			'title'    => __( 'Header Settings', 'pixelpost' ),
			'panel'    => 'pixelpost_theme_options',
			'priority' => 20,
		)
	);

	// Sticky Header
	$wp_customize->add_setting(
		'pixelpost_header_sticky',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_header_sticky' ),
			'sanitize_callback' => 'pixelpost_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'pixelpost_header_sticky',
		array(
			'label'   => __( 'Enable Sticky Header', 'pixelpost' ),
			'section' => 'pixelpost_header_section',
			'type'    => 'checkbox',
		)
	);

	// Show Tagline
	$wp_customize->add_setting(
		'pixelpost_header_tagline_show',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_header_tagline_show' ),
			'sanitize_callback' => 'pixelpost_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'pixelpost_header_tagline_show',
		array(
			'label'   => __( 'Display Tagline under Site Title', 'pixelpost' ),
			'section' => 'pixelpost_header_section',
			'type'    => 'checkbox',
		)
	);

	/* ==========================================================================
	   SECTION: HOMEPAGE SECTIONS VISIBILITY
	   ========================================================================== */
	$wp_customize->add_section(
		'pixelpost_sections_visibility',
		array(
			'title'       => __( 'Section Visibility & Order', 'pixelpost' ),
			'panel'       => 'pixelpost_homepage_panel',
			'description' => __( 'Toggle visibility and ordering of individual homepage sections.', 'pixelpost' ),
			'priority'    => 10,
		)
	);

	$sections_to_toggle = array(
		'pixelpost_frontpage_show_sections' => __( 'Show Homepage Sections on Front Page', 'pixelpost' ),
		'pixelpost_section_hero_show'       => __( 'Show Hero Section', 'pixelpost' ),
		'pixelpost_section_stats_show'      => __( 'Show Statistics Strip', 'pixelpost' ),
		'pixelpost_section_skills_show'     => __( 'Show Skills & Technologies', 'pixelpost' ),
		'pixelpost_section_experience_show' => __( 'Show Work Experience Timeline', 'pixelpost' ),
		'pixelpost_section_projects_show'   => __( 'Show Projects & Products', 'pixelpost' ),
		'pixelpost_section_impact_show'     => __( 'Show Impact Metrics (Optional)', 'pixelpost' ),
		'pixelpost_section_posts_show'      => __( 'Show Latest Blog Posts', 'pixelpost' ),
		'pixelpost_section_about_show'      => __( 'Show About Me Section', 'pixelpost' ),
		'pixelpost_section_contact_show'    => __( 'Show Contact Section', 'pixelpost' ),
	);

	foreach ( $sections_to_toggle as $id => $label ) {
		$wp_customize->add_setting(
			$id,
			array(
				'default'           => pixelpost_get_theme_default( $id ),
				'sanitize_callback' => 'pixelpost_sanitize_checkbox',
			)
		);
		$wp_customize->add_control(
			$id,
			array(
				'label'   => $label,
				'section' => 'pixelpost_sections_visibility',
				'type'    => 'checkbox',
			)
		);
	}

	/* ==========================================================================
	   SECTION: HERO SECTION
	   ========================================================================== */
	$wp_customize->add_section(
		'pixelpost_hero_section',
		array(
			'title'    => __( '1. Hero Section', 'pixelpost' ),
			'panel'    => 'pixelpost_homepage_panel',
			'priority' => 20,
		)
	);

	// Eyebrow
	$wp_customize->add_setting(
		'pixelpost_hero_eyebrow',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_hero_eyebrow' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'pixelpost_hero_eyebrow',
		array(
			'label'   => __( 'Greeting / Eyebrow', 'pixelpost' ),
			'section' => 'pixelpost_hero_section',
			'type'    => 'text',
		)
	);

	// Headline Main
	$wp_customize->add_setting(
		'pixelpost_hero_headline',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_hero_headline' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'pixelpost_hero_headline',
		array(
			'label'   => __( 'Headline Prefix', 'pixelpost' ),
			'section' => 'pixelpost_hero_section',
			'type'    => 'text',
		)
	);

	// Headline Accent (Terracotta)
	$wp_customize->add_setting(
		'pixelpost_hero_accent',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_hero_accent' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'pixelpost_hero_accent',
		array(
			'label'   => __( 'Headline Accent (Your Name)', 'pixelpost' ),
			'section' => 'pixelpost_hero_section',
			'type'    => 'text',
		)
	);

	// Role / Subtitle
	$wp_customize->add_setting(
		'pixelpost_hero_role',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_hero_role' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'pixelpost_hero_role',
		array(
			'label'   => __( 'Professional Role / Title', 'pixelpost' ),
			'section' => 'pixelpost_hero_section',
			'type'    => 'text',
		)
	);

	// Description
	$wp_customize->add_setting(
		'pixelpost_hero_description',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_hero_description' ),
			'sanitize_callback' => 'sanitize_textarea_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'pixelpost_hero_description',
		array(
			'label'   => __( 'Introduction / Bio', 'pixelpost' ),
			'section' => 'pixelpost_hero_section',
			'type'    => 'textarea',
		)
	);

	// Primary Button
	$wp_customize->add_setting(
		'pixelpost_hero_btn_primary_text',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_hero_btn_primary_text' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'pixelpost_hero_btn_primary_text',
		array(
			'label'   => __( 'Primary Button Label', 'pixelpost' ),
			'section' => 'pixelpost_hero_section',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'pixelpost_hero_btn_primary_url',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_hero_btn_primary_url' ),
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'pixelpost_hero_btn_primary_url',
		array(
			'label'   => __( 'Primary Button URL', 'pixelpost' ),
			'section' => 'pixelpost_hero_section',
			'type'    => 'text',
		)
	);

	// Secondary Button
	$wp_customize->add_setting(
		'pixelpost_hero_btn_secondary_text',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_hero_btn_secondary_text' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'pixelpost_hero_btn_secondary_text',
		array(
			'label'   => __( 'Secondary Button Label', 'pixelpost' ),
			'section' => 'pixelpost_hero_section',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'pixelpost_hero_btn_secondary_url',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_hero_btn_secondary_url' ),
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'pixelpost_hero_btn_secondary_url',
		array(
			'label'   => __( 'Secondary Button URL', 'pixelpost' ),
			'section' => 'pixelpost_hero_section',
			'type'    => 'text',
		)
	);

	// Hero Headshot Image
	$wp_customize->add_setting(
		'pixelpost_hero_image',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_hero_image' ),
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'pixelpost_hero_image',
			array(
				'label'       => __( 'Hero Headshot Image', 'pixelpost' ),
				'description' => __( 'Upload your portrait photo (leave empty for theme default image).', 'pixelpost' ),
				'section'     => 'pixelpost_hero_section',
			)
		)
	);

	/* ==========================================================================
	   SECTION: HIGHLIGHTS & STATISTICS
	   ========================================================================== */
	$wp_customize->add_section(
		'pixelpost_stats_section',
		array(
			'title'       => __( '2. Highlights & Statistics', 'pixelpost' ),
			'panel'       => 'pixelpost_homepage_panel',
			'description' => __( 'Manage key statistics shown in the highlight strip below the Hero. You can add, reorder, duplicate, or remove items dynamically.', 'pixelpost' ),
			'priority'    => 30,
		)
	);

	// Repeater Control for Stats
	$wp_customize->add_setting(
		'pixelpost_stats_items',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_stats_items' ),
			'sanitize_callback' => 'pixelpost_sanitize_repeater',
		)
	);
	$wp_customize->add_control(
		new Pixelpost_Repeater_Control(
			$wp_customize,
			'pixelpost_stats_items',
			array(
				'label'             => __( 'Career Highlights & Statistics', 'pixelpost' ),
				'description'       => __( 'Add, reorder, duplicate, or delete highlight numbers and labels.', 'pixelpost' ),
				'section'           => 'pixelpost_stats_section',
				'item_label_key'    => 'label',
				'item_subtitle_key' => 'number',
				'add_item_label'    => __( '+ Add Statistic', 'pixelpost' ),
				'fields'            => array(
					array(
						'key'         => 'number',
						'label'       => __( 'Number / Metric', 'pixelpost' ),
						'type'        => 'text',
						'placeholder' => __( 'e.g. 200, 15, 10, 8', 'pixelpost' ),
						'default'     => '200',
					),
					array(
						'key'         => 'suffix',
						'label'       => __( 'Suffix Symbol (e.g. +, %)', 'pixelpost' ),
						'type'        => 'text',
						'placeholder' => __( '+ or %', 'pixelpost' ),
						'default'     => '+',
					),
					array(
						'key'         => 'label',
						'label'       => __( 'Metric Title', 'pixelpost' ),
						'type'        => 'text',
						'placeholder' => __( 'e.g. WordPress websites, Years in web development', 'pixelpost' ),
						'default'     => __( 'Statistic', 'pixelpost' ),
					),
					array(
						'key'         => 'desc',
						'label'       => __( 'Supporting Description', 'pixelpost' ),
						'type'        => 'text',
						'placeholder' => __( 'e.g. Built, maintained, and supported WordPress websites', 'pixelpost' ),
						'default'     => '',
					),
				),
			)
		)
	);

	/* ==========================================================================
	   SECTION: SKILLS & EXPERTISE
	   ========================================================================== */
	$wp_customize->add_section(
		'pixelpost_skills_section',
		array(
			'title'    => __( '3. Skills & Capabilities', 'pixelpost' ),
			'panel'    => 'pixelpost_homepage_panel',
			'priority' => 40,
		)
	);

	$wp_customize->add_setting(
		'pixelpost_skills_eyebrow',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_skills_eyebrow' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'pixelpost_skills_eyebrow',
		array(
			'label'   => __( 'Eyebrow', 'pixelpost' ),
			'section' => 'pixelpost_skills_section',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'pixelpost_skills_heading',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_skills_heading' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'pixelpost_skills_heading',
		array(
			'label'   => __( 'Heading', 'pixelpost' ),
			'section' => 'pixelpost_skills_section',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'pixelpost_skills_subtitle',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_skills_subtitle' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'pixelpost_skills_subtitle',
		array(
			'label'   => __( 'Subtitle', 'pixelpost' ),
			'section' => 'pixelpost_skills_section',
			'type'    => 'text',
		)
	);

	// Skills View All Link Toggle
	$wp_customize->add_setting(
		'pixelpost_skills_view_all_show',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_skills_view_all_show' ),
			'sanitize_callback' => 'pixelpost_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'pixelpost_skills_view_all_show',
		array(
			'label'       => __( 'Show "View Full Breakdown" Link', 'pixelpost' ),
			'description' => __( 'Display the call-to-action link in the Skills header.', 'pixelpost' ),
			'section'     => 'pixelpost_skills_section',
			'type'        => 'checkbox',
		)
	);

	// Skills View All Link Text
	$wp_customize->add_setting(
		'pixelpost_skills_view_all_text',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_skills_view_all_text' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'pixelpost_skills_view_all_text',
		array(
			'label'   => __( 'Link Text', 'pixelpost' ),
			'section' => 'pixelpost_skills_section',
			'type'    => 'text',
		)
	);

	// Skills View All Link URL
	$wp_customize->add_setting(
		'pixelpost_skills_view_all_url',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_skills_view_all_url' ),
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'pixelpost_skills_view_all_url',
		array(
			'label'       => __( 'Link URL', 'pixelpost' ),
			'description' => __( 'Destination URL for the link (e.g. #experience or page URL).', 'pixelpost' ),
			'section'     => 'pixelpost_skills_section',
			'type'        => 'url',
		)
	);

	// Skills Repeater Control
	$wp_customize->add_setting(
		'pixelpost_skills_items',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_skills_items' ),
			'sanitize_callback' => 'pixelpost_sanitize_repeater',
		)
	);
	$wp_customize->add_control(
		new Pixelpost_Repeater_Control(
			$wp_customize,
			'pixelpost_skills_items',
			array(
				'label'             => __( 'Skill Matrices by Domain (Repeater)', 'pixelpost' ),
				'description'       => __( 'Add, reorder, duplicate, or delete domain cards and their skill tags.', 'pixelpost' ),
				'section'           => 'pixelpost_skills_section',
				'item_label_key'    => 'title',
				'item_subtitle_key' => 'badge_value',
				'add_item_label'    => __( '+ Add Domain Matrix', 'pixelpost' ),
				'fields'            => array(
					array(
						'key'         => 'title',
						'label'       => __( 'Domain Title', 'pixelpost' ),
						'type'        => 'text',
						'placeholder' => __( 'e.g. Core Stack, DevOps & Hosting', 'pixelpost' ),
						'default'     => __( 'Core Stack', 'pixelpost' ),
					),
					array(
						'key'     => 'icon',
						'label'   => __( 'Domain Icon', 'pixelpost' ),
						'type'    => 'icon',
						'default' => 'code',
					),
					array(
						'key'         => 'tags',
						'label'       => __( 'Skill Tags (comma separated)', 'pixelpost' ),
						'type'        => 'textarea',
						'placeholder' => __( 'e.g. WordPress Core, PHP 8.x, MySQL, HTML5 / CSS3', 'pixelpost' ),
						'default'     => '',
					),
					array(
						'key'         => 'badge_label',
						'label'       => __( 'Bottom Badge Label', 'pixelpost' ),
						'type'        => 'text',
						'placeholder' => __( 'e.g. Proficiency, SLA Recovery', 'pixelpost' ),
						'default'     => __( 'Proficiency', 'pixelpost' ),
					),
					array(
						'key'         => 'badge_value',
						'label'       => __( 'Bottom Badge Value', 'pixelpost' ),
						'type'        => 'text',
						'placeholder' => __( 'e.g. Mastery, Production Grade, < 4 Hours', 'pixelpost' ),
						'default'     => __( 'Mastery', 'pixelpost' ),
					),
				),
			)
		)
	);

	/* ==========================================================================
	   SECTION: WORK EXPERIENCE
	   ========================================================================== */
	$wp_customize->add_section(
		'pixelpost_experience_section',
		array(
			'title'       => __( '4. Work Experience Timeline', 'pixelpost' ),
			'panel'       => 'pixelpost_homepage_panel',
			'description' => __( 'Manage your career journey. Add, reorder (drag or up/down), duplicate, or delete job entries.', 'pixelpost' ),
			'priority'    => 50,
		)
	);

	$wp_customize->add_setting(
		'pixelpost_exp_eyebrow',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_exp_eyebrow' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'pixelpost_exp_eyebrow',
		array(
			'label'   => __( 'Eyebrow', 'pixelpost' ),
			'section' => 'pixelpost_experience_section',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'pixelpost_exp_heading',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_exp_heading' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'pixelpost_exp_heading',
		array(
			'label'   => __( 'Heading', 'pixelpost' ),
			'section' => 'pixelpost_experience_section',
			'type'    => 'text',
		)
	);

	// Work Experience Repeater Control
	$wp_customize->add_setting(
		'pixelpost_experience_items',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_experience_items' ),
			'sanitize_callback' => 'pixelpost_sanitize_repeater',
		)
	);
	$wp_customize->add_control(
		new Pixelpost_Repeater_Control(
			$wp_customize,
			'pixelpost_experience_items',
			array(
				'label'             => __( 'Timeline Experience Entries', 'pixelpost' ),
				'description'       => __( 'Add, reorder, duplicate, or delete job experience entries in your career timeline.', 'pixelpost' ),
				'section'           => 'pixelpost_experience_section',
				'item_label_key'    => 'title',
				'item_subtitle_key' => 'company',
				'add_item_label'    => __( '+ Add Job Experience', 'pixelpost' ),
				'fields'            => array(
					array(
						'key'         => 'title',
						'label'       => __( 'Job Title', 'pixelpost' ),
						'type'        => 'text',
						'placeholder' => __( 'e.g. Associate Lead — Tech Support', 'pixelpost' ),
						'default'     => '',
					),
					array(
						'key'         => 'company',
						'label'       => __( 'Company / Client Name', 'pixelpost' ),
						'type'        => 'text',
						'placeholder' => __( 'e.g. Ollyo, MAGNIFYADS', 'pixelpost' ),
						'default'     => '',
					),
					array(
						'key'         => 'url',
						'label'       => __( 'Company Website URL (optional)', 'pixelpost' ),
						'type'        => 'url',
						'placeholder' => __( 'https://example.com', 'pixelpost' ),
						'default'     => '',
					),
					array(
						'key'         => 'date',
						'label'       => __( 'Employment Period / Date', 'pixelpost' ),
						'type'        => 'text',
						'placeholder' => __( 'e.g. 2020 – Present', 'pixelpost' ),
						'default'     => '',
					),
					array(
						'key'         => 'desc',
						'label'       => __( 'Job Description & Achievements', 'pixelpost' ),
						'type'        => 'textarea',
						'placeholder' => __( 'Describe your responsibilities and achievements...', 'pixelpost' ),
						'default'     => '',
					),
					array(
						'key'         => 'tags',
						'label'       => __( 'Technology / Skill Tags (comma separated)', 'pixelpost' ),
						'type'        => 'text',
						'placeholder' => __( 'e.g. Theme Customization, WooCommerce Triage', 'pixelpost' ),
						'default'     => '',
					),
				),
			)
		)
	);

	/* ==========================================================================
	   SECTION: PROJECTS & PRODUCTS
	   ========================================================================== */
	$wp_customize->add_section(
		'pixelpost_projects_section',
		array(
			'title'       => __( '5. Plugins & Products', 'pixelpost' ),
			'panel'       => 'pixelpost_homepage_panel',
			'description' => __( 'Manage your plugins, developer utilities, and products directly in the repeater below. Add, edit, reorder, duplicate, or delete project cards in real time without needing a custom post type.', 'pixelpost' ),
			'priority'    => 60,
		)
	);

	$wp_customize->add_setting(
		'pixelpost_projects_eyebrow',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_projects_eyebrow' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'pixelpost_projects_eyebrow',
		array(
			'label'   => __( 'Eyebrow', 'pixelpost' ),
			'section' => 'pixelpost_projects_section',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'pixelpost_projects_heading',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_projects_heading' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'pixelpost_projects_heading',
		array(
			'label'   => __( 'Heading', 'pixelpost' ),
			'section' => 'pixelpost_projects_section',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'pixelpost_projects_subtitle',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_projects_subtitle' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'pixelpost_projects_subtitle',
		array(
			'label'   => __( 'Subtitle', 'pixelpost' ),
			'section' => 'pixelpost_projects_section',
			'type'    => 'text',
		)
	);

	// Projects View All Link Toggle
	$wp_customize->add_setting(
		'pixelpost_projects_view_all_show',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_projects_view_all_show' ),
			'sanitize_callback' => 'pixelpost_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'pixelpost_projects_view_all_show',
		array(
			'label'       => __( 'Show "Request Custom Tool" Link', 'pixelpost' ),
			'description' => __( 'Display the call-to-action link in the Projects header.', 'pixelpost' ),
			'section'     => 'pixelpost_projects_section',
			'type'        => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'pixelpost_projects_view_all_text',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_projects_view_all_text' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'pixelpost_projects_view_all_text',
		array(
			'label'   => __( 'Link Text', 'pixelpost' ),
			'section' => 'pixelpost_projects_section',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'pixelpost_projects_view_all_url',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_projects_view_all_url' ),
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'pixelpost_projects_view_all_url',
		array(
			'label'       => __( 'Link URL', 'pixelpost' ),
			'description' => __( 'Destination URL for the link (e.g. #contact or external repo/hub).', 'pixelpost' ),
			'section'     => 'pixelpost_projects_section',
			'type'        => 'url',
		)
	);

	// Projects Repeater Control
	$wp_customize->add_setting(
		'pixelpost_projects_items',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_projects_items' ),
			'sanitize_callback' => 'pixelpost_sanitize_repeater',
		)
	);
	$wp_customize->add_control(
		new Pixelpost_Repeater_Control(
			$wp_customize,
			'pixelpost_projects_items',
			array(
				'label'             => __( 'Projects & Products (Repeater)', 'pixelpost' ),
				'description'       => __( 'Add, reorder, duplicate, or delete project and tool cards shown on the homepage.', 'pixelpost' ),
				'section'           => 'pixelpost_projects_section',
				'item_label_key'    => 'title',
				'item_subtitle_key' => 'badge1',
				'add_item_label'    => __( '+ Add Project / Product', 'pixelpost' ),
				'fields'            => array(
					array(
						'key'         => 'title',
						'label'       => __( 'Project / Tool Name', 'pixelpost' ),
						'type'        => 'text',
						'placeholder' => __( 'e.g. WP Stack Report, DebugZen', 'pixelpost' ),
						'default'     => __( 'New Project', 'pixelpost' ),
					),
					array(
						'key'         => 'description',
						'label'       => __( 'Project Summary / Description', 'pixelpost' ),
						'type'        => 'textarea',
						'placeholder' => __( 'Describe the product, features, or architectural purpose...', 'pixelpost' ),
						'default'     => '',
					),
					array(
						'key'         => 'url',
						'label'       => __( 'Project URL / Website', 'pixelpost' ),
						'type'        => 'url',
						'placeholder' => __( 'https://debugzen.com', 'pixelpost' ),
						'default'     => '#',
					),
					array(
						'key'     => 'icon',
						'label'   => __( 'Card Icon Badge', 'pixelpost' ),
						'type'    => 'icon',
						'default' => 'bug_report',
					),
					array(
						'key'         => 'badge1',
						'label'       => __( 'Category Badge (Top Left)', 'pixelpost' ),
						'type'        => 'text',
						'placeholder' => __( 'e.g. Free Tool, Utilities, Security', 'pixelpost' ),
						'default'     => __( 'Free Tool', 'pixelpost' ),
					),
					array(
						'key'         => 'badge2',
						'label'       => __( 'Status Badge (Top Right)', 'pixelpost' ),
						'type'        => 'text',
						'placeholder' => __( 'e.g. Active, Pro, Open Source, Production', 'pixelpost' ),
						'default'     => __( 'Active', 'pixelpost' ),
					),
					array(
						'key'         => 'type_label',
						'label'       => __( 'Bottom Type Label', 'pixelpost' ),
						'type'        => 'text',
						'placeholder' => __( 'e.g. Developer Utility, Admin Management, Access Control', 'pixelpost' ),
						'default'     => __( 'Developer Utility', 'pixelpost' ),
					),
					array(
						'key'     => 'type_icon',
						'label'   => __( 'Bottom Type Icon', 'pixelpost' ),
						'type'    => 'icon',
						'default' => 'terminal',
					),
				),
			)
		)
	);

	/* ==========================================================================
	   SECTION: LATEST POSTS
	   ========================================================================== */
	$wp_customize->add_section(
		'pixelpost_blog_section',
		array(
			'title'    => __( '6. Latest Posts / Knowledge Base', 'pixelpost' ),
			'panel'    => 'pixelpost_homepage_panel',
			'priority' => 70,
		)
	);

	$wp_customize->add_setting(
		'pixelpost_blog_eyebrow',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_blog_eyebrow' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'pixelpost_blog_eyebrow',
		array(
			'label'   => __( 'Eyebrow', 'pixelpost' ),
			'section' => 'pixelpost_blog_section',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'pixelpost_blog_heading',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_blog_heading' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'pixelpost_blog_heading',
		array(
			'label'   => __( 'Heading', 'pixelpost' ),
			'section' => 'pixelpost_blog_section',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'pixelpost_blog_subtitle',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_blog_subtitle' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'pixelpost_blog_subtitle',
		array(
			'label'   => __( 'Subtitle', 'pixelpost' ),
			'section' => 'pixelpost_blog_section',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'pixelpost_blog_posts_count',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_blog_posts_count' ),
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		'pixelpost_blog_posts_count',
		array(
			'label'       => __( 'Number of Posts to Display', 'pixelpost' ),
			'section'     => 'pixelpost_blog_section',
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 2,
				'max'  => 12,
				'step' => 1,
			),
		)
	);

	/* ==========================================================================
	   SECTION: ABOUT ME
	   ========================================================================== */
	$wp_customize->add_section(
		'pixelpost_about_section',
		array(
			'title'    => __( '7. About Me Section', 'pixelpost' ),
			'panel'    => 'pixelpost_homepage_panel',
			'priority' => 80,
		)
	);

	$wp_customize->add_setting(
		'pixelpost_about_eyebrow',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_about_eyebrow' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'pixelpost_about_eyebrow',
		array(
			'label'   => __( 'Eyebrow', 'pixelpost' ),
			'section' => 'pixelpost_about_section',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'pixelpost_about_heading',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_about_heading' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'pixelpost_about_heading',
		array(
			'label'   => __( 'Heading', 'pixelpost' ),
			'section' => 'pixelpost_about_section',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'pixelpost_about_text',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_about_text' ),
			'sanitize_callback' => 'wp_kses_post',
		)
	);
	$wp_customize->add_control(
		'pixelpost_about_text',
		array(
			'label'   => __( 'Bio / Story Content (HTML allowed)', 'pixelpost' ),
			'section' => 'pixelpost_about_section',
			'type'    => 'textarea',
		)
	);

	// About Portrait Image
	$wp_customize->add_setting(
		'pixelpost_about_image',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_about_image' ),
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'pixelpost_about_image',
			array(
				'label'       => __( 'About Section Portrait Image', 'pixelpost' ),
				'description' => __( 'Upload your portrait image (leave empty to use default photo).', 'pixelpost' ),
				'section'     => 'pixelpost_about_section',
			)
		)
	);

	// Feature Bullets Repeater Control
	$wp_customize->add_setting(
		'pixelpost_about_bullets',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_about_bullets' ),
			'sanitize_callback' => 'pixelpost_sanitize_repeater',
		)
	);
	$wp_customize->add_control(
		new Pixelpost_Repeater_Control(
			$wp_customize,
			'pixelpost_about_bullets',
			array(
				'label'          => __( 'Feature Bullets (Repeater)', 'pixelpost' ),
				'description'    => __( 'Add, reorder, duplicate, or delete feature highlight bullet points.', 'pixelpost' ),
				'section'        => 'pixelpost_about_section',
				'item_label_key' => 'text',
				'add_item_label' => __( '+ Add Bullet', 'pixelpost' ),
				'fields'         => array(
					array(
						'key'         => 'text',
						'label'       => __( 'Bullet Text', 'pixelpost' ),
						'type'        => 'text',
						'placeholder' => __( 'e.g. Root-Cause Analysis', 'pixelpost' ),
						'default'     => __( 'Feature Bullet', 'pixelpost' ),
					),
				),
			)
		)
	);

	// Backward compatibility settings for legacy bullet 1..4
	for ( $b = 1; $b <= 4; $b++ ) {
		$wp_customize->add_setting(
			"pixelpost_about_bullet{$b}",
			array(
				'default'           => pixelpost_get_theme_default( "pixelpost_about_bullet{$b}" ),
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
	}

	/* ==========================================================================
	   SECTION: CONTACT & COLLABORATION
	   ========================================================================== */
	$wp_customize->add_section(
		'pixelpost_contact_section',
		array(
			'title'    => __( '8. Contact Section', 'pixelpost' ),
			'panel'    => 'pixelpost_homepage_panel',
			'priority' => 90,
		)
	);

	// Eyebrow
	$wp_customize->add_setting(
		'pixelpost_contact_eyebrow',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_contact_eyebrow' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'pixelpost_contact_eyebrow',
		array(
			'label'   => __( 'Eyebrow Label', 'pixelpost' ),
			'section' => 'pixelpost_contact_section',
			'type'    => 'text',
		)
	);

	// Heading
	$wp_customize->add_setting(
		'pixelpost_contact_heading',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_contact_heading' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'pixelpost_contact_heading',
		array(
			'label'   => __( 'Heading (e.g. Let\'s Talk)', 'pixelpost' ),
			'section' => 'pixelpost_contact_section',
			'type'    => 'text',
		)
	);

	// Accent Heading
	$wp_customize->add_setting(
		'pixelpost_contact_heading_accent',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_contact_heading_accent' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'pixelpost_contact_heading_accent',
		array(
			'label'   => __( 'Accent Heading Text (e.g. WordPress)', 'pixelpost' ),
			'section' => 'pixelpost_contact_section',
			'type'    => 'text',
		)
	);

	// Description
	$wp_customize->add_setting(
		'pixelpost_contact_description',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_contact_description' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'pixelpost_contact_description',
		array(
			'label'   => __( 'Invitation Description', 'pixelpost' ),
			'section' => 'pixelpost_contact_section',
			'type'    => 'text',
		)
	);

	// Primary Button
	$wp_customize->add_setting(
		'pixelpost_contact_btn_primary',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_contact_btn_primary' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'pixelpost_contact_btn_primary',
		array(
			'label'   => __( 'Primary Button Label (Generates mailto:)', 'pixelpost' ),
			'section' => 'pixelpost_contact_section',
			'type'    => 'text',
		)
	);

	// Secondary Button
	$wp_customize->add_setting(
		'pixelpost_contact_btn_secondary',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_contact_btn_secondary' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'pixelpost_contact_btn_secondary',
		array(
			'label'   => __( 'Secondary Button Label (Schedule a Call)', 'pixelpost' ),
			'section' => 'pixelpost_contact_section',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'pixelpost_contact_btn_secondary_url',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_contact_btn_secondary_url' ),
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'pixelpost_contact_btn_secondary_url',
		array(
			'label'       => __( 'Schedule URL (Calendly, Cal.com, etc.)', 'pixelpost' ),
			'description' => __( 'Leave blank to hide the secondary button.', 'pixelpost' ),
			'section'     => 'pixelpost_contact_section',
			'type'        => 'text',
		)
	);

	// Contact Channel Cards Repeater Control
	$wp_customize->add_setting(
		'pixelpost_contact_items',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_contact_items' ),
			'sanitize_callback' => 'pixelpost_sanitize_repeater',
		)
	);
	$wp_customize->add_control(
		new Pixelpost_Repeater_Control(
			$wp_customize,
			'pixelpost_contact_items',
			array(
				'label'             => __( 'Contact Cards & Channels (Repeater)', 'pixelpost' ),
				'description'       => __( 'Add, reorder, duplicate, or delete contact cards, location info, and work status shown on the right.', 'pixelpost' ),
				'section'           => 'pixelpost_contact_section',
				'item_label_key'    => 'label',
				'item_subtitle_key' => 'value',
				'add_item_label'    => __( '+ Add Contact Card', 'pixelpost' ),
				'fields'            => array(
					array(
						'key'         => 'label',
						'label'       => __( 'Card Title / Label', 'pixelpost' ),
						'type'        => 'text',
						'placeholder' => __( 'e.g. Direct Inquiry, Current Base, Professional Focus', 'pixelpost' ),
						'default'     => __( 'Direct Inquiry', 'pixelpost' ),
					),
					array(
						'key'         => 'value',
						'label'       => __( 'Display Text / Info', 'pixelpost' ),
						'type'        => 'text',
						'placeholder' => __( 'e.g. hello@example.com or San Francisco, CA', 'pixelpost' ),
						'default'     => '',
					),
					array(
						'key'         => 'link',
						'label'       => __( 'Link URL / mailto: (optional)', 'pixelpost' ),
						'type'        => 'text',
						'placeholder' => __( 'mailto:name@example.com or https://...', 'pixelpost' ),
						'default'     => '',
					),
					array(
						'key'         => 'context',
						'label'       => __( 'Supporting Description / Subtitle', 'pixelpost' ),
						'type'        => 'text',
						'placeholder' => __( 'e.g. Typically responds within 24-48 business hours', 'pixelpost' ),
						'default'     => '',
					),
					array(
						'key'     => 'icon',
						'label'   => __( 'Method Icon', 'pixelpost' ),
						'type'    => 'icon',
						'default' => 'alternate_email',
					),
				),
			)
		)
	);

	// Legacy settings registered for backward compatibility
	$legacy_contact_settings = array(
		'pixelpost_contact_email_label',
		'pixelpost_contact_email',
		'pixelpost_contact_email_context',
		'pixelpost_contact_location_label',
		'pixelpost_contact_location',
		'pixelpost_contact_location_context',
		'pixelpost_contact_avail_label',
		'pixelpost_contact_availability_status',
		'pixelpost_contact_avail_context',
	);
	foreach ( $legacy_contact_settings as $lcs ) {
		$wp_customize->add_setting(
			$lcs,
			array(
				'default'           => pixelpost_get_theme_default( $lcs ),
				'sanitize_callback' => ( 'pixelpost_contact_email' === $lcs ) ? 'sanitize_email' : 'sanitize_text_field',
			)
		);
	}

	/* ==========================================================================
	   SECTION: FOOTER
	   ========================================================================== */
	$wp_customize->add_section(
		'pixelpost_footer_section',
		array(
			'title'    => __( 'Footer & Social Profiles', 'pixelpost' ),
			'panel'    => 'pixelpost_theme_options',
			'priority' => 30,
		)
	);

	$wp_customize->add_setting(
		'pixelpost_footer_tagline',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_footer_tagline' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'pixelpost_footer_tagline',
		array(
			'label'   => __( 'Footer Tagline', 'pixelpost' ),
			'section' => 'pixelpost_footer_section',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'pixelpost_footer_copyright',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_footer_copyright' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'pixelpost_footer_copyright',
		array(
			'label'       => __( 'Copyright Text', 'pixelpost' ),
			'description' => __( 'Use {year} for current year and {sitename} for site title.', 'pixelpost' ),
			'section'     => 'pixelpost_footer_section',
			'type'        => 'text',
		)
	);

	// Back to Top Link
	$wp_customize->add_setting(
		'pixelpost_footer_back_to_top_show',
		array(
			'default'           => true,
			'sanitize_callback' => 'pixelpost_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'pixelpost_footer_back_to_top_show',
		array(
			'label'   => __( 'Show "Back to Top" Link', 'pixelpost' ),
			'section' => 'pixelpost_footer_section',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'pixelpost_footer_back_to_top_text',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_footer_back_to_top_text' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'pixelpost_footer_back_to_top_text',
		array(
			'label'   => __( 'Back to Top Text', 'pixelpost' ),
			'section' => 'pixelpost_footer_section',
			'type'    => 'text',
		)
	);

	// Footer Navigation Controls
	$wp_customize->add_setting(
		'pixelpost_footer_nav_show',
		array(
			'default'           => true,
			'sanitize_callback' => 'pixelpost_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'pixelpost_footer_nav_show',
		array(
			'label'       => __( 'Show Footer Navigation Column', 'pixelpost' ),
			'description' => __( 'Toggle visibility of the navigation links column in the footer.', 'pixelpost' ),
			'section'     => 'pixelpost_footer_section',
			'type'        => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'pixelpost_footer_nav_title',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_footer_nav_title' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'pixelpost_footer_nav_title',
		array(
			'label'       => __( 'Footer Navigation Title', 'pixelpost' ),
			'description' => __( 'Heading displayed above the footer links (defaults to Navigation).', 'pixelpost' ),
			'section'     => 'pixelpost_footer_section',
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'pixelpost_footer_nav_help',
		array(
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'pixelpost_footer_nav_help',
			array(
				'label'       => __( 'Footer Menu Links', 'pixelpost' ),
				'description' => sprintf(
					/* translators: 1: opening button tag, 2: closing button tag */
					__( 'By default, demo links are displayed. To customize, add, or reorder links, assign a custom menu to the Footer Menu location in %1$sMenus%2$s.', 'pixelpost' ),
					'<br><button type="button" class="button button-secondary fp-btn-open-footer-menus" style="margin-top:8px;">' . esc_html__( 'Configure Footer Menu', 'pixelpost' ) . '</button><span style="display:none;">',
					'</span>'
				),
				'section'     => 'pixelpost_footer_section',
				'type'        => 'hidden',
			)
		)
	);

	// Footer Widgets Display Toggle
	$wp_customize->add_setting(
		'pixelpost_footer_widgets_show',
		array(
			'default'           => false,
			'sanitize_callback' => 'pixelpost_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'pixelpost_footer_widgets_show',
		array(
			'label'       => __( 'Show Footer Widgets Area', 'pixelpost' ),
			'description' => __( 'Enable to display widgets assigned to Footer Widgets under Appearance > Widgets.', 'pixelpost' ),
			'section'     => 'pixelpost_footer_section',
			'type'        => 'checkbox',
		)
	);

	// Social Profiles Repeater Control
	$wp_customize->add_setting(
		'pixelpost_social_links',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_social_links' ),
			'sanitize_callback' => 'pixelpost_sanitize_repeater',
		)
	);
	$wp_customize->add_control(
		new Pixelpost_Repeater_Control(
			$wp_customize,
			'pixelpost_social_links',
			array(
				'label'             => __( 'Social & Profile Links (Repeater)', 'pixelpost' ),
				'description'       => __( 'Add, reorder, duplicate, or delete social profile links in the footer.', 'pixelpost' ),
				'section'           => 'pixelpost_footer_section',
				'item_label_key'    => 'title',
				'item_subtitle_key' => 'url',
				'add_item_label'    => __( '+ Add Profile Link', 'pixelpost' ),
				'fields'            => array(
					array(
						'key'         => 'title',
						'label'       => __( 'Platform Name', 'pixelpost' ),
						'type'        => 'text',
						'placeholder' => __( 'e.g. GitHub, LinkedIn, X / Twitter, Email', 'pixelpost' ),
						'default'     => 'GitHub',
					),
					array(
						'key'         => 'url',
						'label'       => __( 'Profile URL or mailto: link', 'pixelpost' ),
						'type'        => 'text',
						'placeholder' => __( 'https://github.com/... or mailto:...', 'pixelpost' ),
						'default'     => '',
					),
					array(
						'key'     => 'icon',
						'label'   => __( 'Platform Icon', 'pixelpost' ),
						'type'    => 'icon',
						'default' => 'code',
					),
					array(
						'key'         => 'label',
						'label'       => __( 'Accessibility Label (optional)', 'pixelpost' ),
						'type'        => 'text',
						'placeholder' => __( 'e.g. Code Repositories', 'pixelpost' ),
						'default'     => '',
					),
				),
			)
		)
	);

	// Legacy Social Settings registered for backward compatibility
	$socials = array(
		'pixelpost_social_github'   => __( 'GitHub Profile URL', 'pixelpost' ),
		'pixelpost_social_linkedin' => __( 'LinkedIn Profile URL', 'pixelpost' ),
		'pixelpost_social_twitter'  => __( 'X / Twitter Profile URL', 'pixelpost' ),
		'pixelpost_social_email'    => __( 'Direct Email Address', 'pixelpost' ),
	);

	foreach ( $socials as $key => $label ) {
		$wp_customize->add_setting(
			$key,
			array(
				'default'           => pixelpost_get_theme_default( $key ),
				'sanitize_callback' => ( 'pixelpost_social_email' === $key ) ? 'sanitize_email' : 'esc_url_raw',
			)
		);
	}

	/* ==========================================================================
	   SECTION: SEO & SOCIAL META TAGS
	   ========================================================================== */
	$wp_customize->add_section(
		'pixelpost_seo_section',
		array(
			'title'       => __( 'SEO & Social Meta Tags', 'pixelpost' ),
			'panel'       => 'pixelpost_theme_options',
			'description' => __( 'Configure basic search engine meta descriptions and social media share cards. (Automatically yields if an SEO plugin like Yoast or Rank Math is active).', 'pixelpost' ),
			'priority'    => 40,
		)
	);

	// Enable SEO Meta
	$wp_customize->add_setting(
		'pixelpost_seo_enable',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_seo_enable' ),
			'sanitize_callback' => 'pixelpost_sanitize_checkbox',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'pixelpost_seo_enable',
		array(
			'label'       => __( 'Enable Basic SEO Meta Tags', 'pixelpost' ),
			'description' => __( 'Outputs meta description tags to satisfy search engine crawlers and Google Lighthouse audit requirements.', 'pixelpost' ),
			'section'     => 'pixelpost_seo_section',
			'type'        => 'checkbox',
		)
	);

	// Homepage / Default Meta Description
	$wp_customize->add_setting(
		'pixelpost_seo_meta_desc',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_seo_meta_desc' ),
			'sanitize_callback' => 'sanitize_textarea_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'pixelpost_seo_meta_desc',
		array(
			'label'       => __( 'Homepage Meta Description', 'pixelpost' ),
			'description' => __( 'Enter a concise summary of your site (recommended: 120–160 characters). Displayed in search engine results and satisfies Google Lighthouse audit.', 'pixelpost' ),
			'section'     => 'pixelpost_seo_section',
			'type'        => 'textarea',
			'input_attrs' => array(
				'rows'        => 3,
				'placeholder' => __( 'e.g. WordPress Technical Support Engineer solving complex architecture bottlenecks, plugin conflicts, and performance issues.', 'pixelpost' ),
			),
		)
	);

	// Enable Open Graph
	$wp_customize->add_setting(
		'pixelpost_seo_og_enable',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_seo_og_enable' ),
			'sanitize_callback' => 'pixelpost_sanitize_checkbox',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'pixelpost_seo_og_enable',
		array(
			'label'       => __( 'Enable Open Graph & Twitter Cards', 'pixelpost' ),
			'description' => __( 'Output rich sharing tags for Facebook, LinkedIn, Twitter/X, and messaging apps.', 'pixelpost' ),
			'section'     => 'pixelpost_seo_section',
			'type'        => 'checkbox',
		)
	);

	// Default Social Share Image
	$wp_customize->add_setting(
		'pixelpost_seo_og_image',
		array(
			'default'           => pixelpost_get_theme_default( 'pixelpost_seo_og_image' ),
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'pixelpost_seo_og_image',
			array(
				'label'       => __( 'Default Social Share Image', 'pixelpost' ),
				'description' => __( 'Fallback image (1200×630px recommended) used when sharing pages that do not have a featured image.', 'pixelpost' ),
				'section'     => 'pixelpost_seo_section',
			)
		)
	);
}
add_action( 'customize_register', 'pixelpost_customize_register' );

/**
 * Sanitize Checkbox
 *
 * @param bool $checked Checked status.
 * @return bool
 */
function pixelpost_sanitize_checkbox( $checked ) {
	return ( isset( $checked ) && true === (bool) $checked );
}

/**
 * Enqueue Customizer live preview scripts
 */
function pixelpost_customize_preview_js() {
	wp_enqueue_script(
		'pixelpost-customizer-preview',
		get_template_directory_uri() . '/assets/js/customizer-preview.js',
		array( 'customize-preview', 'jquery' ),
		filemtime( get_template_directory() . '/assets/js/customizer-preview.js' ),
		true
	);
}
add_action( 'customize_preview_init', 'pixelpost_customize_preview_js' );

/**
 * Enqueue controls pane script & styles to support repeater controls and preview-to-control deep linking.
 */
function pixelpost_customize_controls_js() {
	wp_enqueue_style(
		'pixelpost-customizer-repeater',
		get_template_directory_uri() . '/assets/css/customizer-repeater.css',
		array(),
		filemtime( get_template_directory() . '/assets/css/customizer-repeater.css' )
	);

	wp_enqueue_script(
		'pixelpost-customizer-repeater',
		get_template_directory_uri() . '/assets/js/customizer-repeater.js',
		array( 'customize-controls', 'jquery' ),
		filemtime( get_template_directory() . '/assets/js/customizer-repeater.js' ),
		true
	);

	wp_localize_script(
		'pixelpost-customizer-repeater',
		'pixelpostIconCatalog',
		pixelpost_get_available_icons()
	);

	wp_enqueue_script(
		'pixelpost-customizer-controls',
		get_template_directory_uri() . '/assets/js/customizer-controls.js',
		array( 'customize-controls', 'jquery', 'pixelpost-customizer-repeater' ),
		filemtime( get_template_directory() . '/assets/js/customizer-controls.js' ),
		true
	);
}
add_action( 'customize_controls_enqueue_scripts', 'pixelpost_customize_controls_js' );
