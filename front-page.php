<?php
/**
 * The front page template file
 *
 * @package Pixelpost
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Display homepage sections by default, or fallback to standard Blog / Page template if toggled off.
if ( ! pixelpost_get_setting( 'pixelpost_frontpage_show_sections' ) && ! is_customize_preview() ) {
	if ( 'posts' === get_option( 'show_on_front' ) ) {
		include get_home_template();
	} else {
		include get_page_template();
	}
	return;
}

get_header();

// Section order mapping
$pixelpost_section_order_str = pixelpost_get_setting( 'pixelpost_section_order' );
if ( empty( $pixelpost_section_order_str ) ) {
	$pixelpost_section_order_str = 'hero,stats,skills,experience,projects,posts,about,contact';
}

$pixelpost_sections = explode( ',', $pixelpost_section_order_str );

// Render sections in configured order
foreach ( $pixelpost_sections as $pixelpost_section ) {
	$pixelpost_section = trim( $pixelpost_section );
	switch ( $pixelpost_section ) {
		case 'hero':
			if ( pixelpost_get_setting( 'pixelpost_section_hero_show' ) ) {
				get_template_part( 'template-parts/homepage/hero' );
			}
			break;

		case 'stats':
			if ( pixelpost_get_setting( 'pixelpost_section_stats_show' ) ) {
				get_template_part( 'template-parts/homepage/statistics' );
			}
			break;

		case 'skills':
			if ( pixelpost_get_setting( 'pixelpost_section_skills_show' ) ) {
				get_template_part( 'template-parts/homepage/skills' );
			}
			break;

		case 'experience':
			if ( pixelpost_get_setting( 'pixelpost_section_experience_show' ) ) {
				get_template_part( 'template-parts/homepage/experience' );
			}
			break;

		case 'projects':
			if ( pixelpost_get_setting( 'pixelpost_section_projects_show' ) ) {
				get_template_part( 'template-parts/homepage/projects' );
			}
			break;

		case 'impact':
			if ( pixelpost_get_setting( 'pixelpost_section_impact_show' ) ) {
				get_template_part( 'template-parts/homepage/impact-metrics' );
			}
			break;

		case 'posts':
			if ( pixelpost_get_setting( 'pixelpost_section_posts_show' ) ) {
				get_template_part( 'template-parts/homepage/latest-posts' );
			}
			break;

		case 'about':
			if ( pixelpost_get_setting( 'pixelpost_section_about_show' ) ) {
				get_template_part( 'template-parts/homepage/about' );
			}
			break;

		case 'contact':
			if ( pixelpost_get_setting( 'pixelpost_section_contact_show' ) ) {
				get_template_part( 'template-parts/homepage/contact' );
			}
			break;
	}
}

get_footer();
