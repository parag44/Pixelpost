<?php
/**
 * Pixelpost Default Content & Configuration Helpers
 *
 * @package Pixelpost
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return default statistics array matching Parag Das's profile & design mockup
 *
 * @return array
 */
function pixelpost_get_default_stats() {
	return array(
		array(
			'number' => '200',
			'suffix' => '+',
			'label'  => __( 'WordPress websites', 'pixelpost' ),
			'desc'   => __( 'Built, maintained, and supported WordPress websites across a variety of projects.', 'pixelpost' ),
		),
		array(
			'number' => '15',
			'suffix' => '+',
			'label'  => __( 'Years in web development', 'pixelpost' ),
			'desc'   => __( 'Hands-on experience building for the web and solving real-world technical challenges.', 'pixelpost' ),
		),
		array(
			'number' => '10',
			'suffix' => '+',
			'label'  => __( 'Themes and plugins', 'pixelpost' ),
			'desc'   => __( 'Experience troubleshooting, customizing, and improving WordPress themes and plugins.', 'pixelpost' ),
		),
		array(
			'number' => '8',
			'suffix' => '+',
			'label'  => __( 'WordCamps attended', 'pixelpost' ),
			'desc'   => __( 'Connected with the WordPress community and engaged with fellow enthusiasts and contributors.', 'pixelpost' ),
		),
	);
}

/**
 * Return default skills array matching design mockup
 *
 * @return array
 */
function pixelpost_get_default_skills() {
	return array(
		array(
			'title'       => __( 'Core Stack', 'pixelpost' ),
			'icon'        => 'code',
			'tags'        => 'WordPress Core, PHP 8.x, MySQL / MariaDB, HTML5 / CSS3, Modern JavaScript',
			'badge_label' => __( 'Proficiency', 'pixelpost' ),
			'badge_value' => __( 'Mastery', 'pixelpost' ),
		),
		array(
			'title'       => __( 'Ecosystem & Extensibility', 'pixelpost' ),
			'icon'        => 'extension',
			'tags'        => 'WooCommerce, Elementor Pro, Advanced Custom Fields, Gutenberg Blocks, WPML & Polylang',
			'badge_label' => __( 'Custom Hooks', 'pixelpost' ),
			'badge_value' => __( 'Advanced', 'pixelpost' ),
		),
		array(
			'title'       => __( 'DevOps & Hosting', 'pixelpost' ),
			'icon'        => 'terminal',
			'tags'        => 'WP-CLI, Git / GitHub, cPanel & WHM, phpMyAdmin, Redis & Memcached',
			'badge_label' => __( 'Server Tuning', 'pixelpost' ),
			'badge_value' => __( 'Production Grade', 'pixelpost' ),
		),
		array(
			'title'       => __( 'Specialized Disciplines', 'pixelpost' ),
			'icon'        => 'security',
			'tags'        => 'Core Web Vitals, Malware Cleanup, Database Optimization, Plugin Architecture, REST API & Webhooks',
			'badge_label' => __( 'SLA Recovery', 'pixelpost' ),
			'badge_value' => '< 4 Hours',
		),
	);
}

/**
 * Return default job experiences array matching Parag Das's career timeline
 *
 * @return array
 */
function pixelpost_get_default_experience() {
	return array(
		array(
			'title'   => __( 'Associate Lead — Tech Support', 'pixelpost' ),
			'company' => 'Ollyo',
			'url'     => 'https://ollyo.com',
			'date'    => '2024 – Present',
			'current' => true,
			'desc'    => __( 'Lead complex technical investigations and provide advanced support for commercial WordPress themes and plugins. Troubleshoot compatibility issues, investigate bugs, resolve WooCommerce conflicts, and collaborate with development teams to improve product stability and customer experience.', 'pixelpost' ),
			'tags'    => 'Technical Troubleshooting, Theme & Plugin Support, QA Testing, WooCommerce, Bug Triage',
		),
		array(
			'title'   => __( 'Analyst, Tech Support', 'pixelpost' ),
			'company' => 'Ollyo',
			'url'     => 'https://ollyo.com',
			'date'    => '2021 – 2024',
			'current' => false,
			'desc'    => __( 'Provided technical support for WordPress products, helping customers resolve theme and plugin issues through systematic debugging, code analysis, and practical solutions. Investigated compatibility problems, reproduced reported bugs, and collaborated with internal teams to improve product quality and resolve complex technical issues.', 'pixelpost' ),
			'tags'    => 'WordPress Debugging, Plugin Compatibility, Issue Reproduction, Technical Documentation, Customer Support',
		),
		array(
			'title'   => __( 'Web Developer', 'pixelpost' ),
			'company' => 'MAGNIFYADS',
			'url'     => '',
			'date'    => '2017 – 2021',
			'current' => false,
			'desc'    => __( 'Developed and maintained WordPress websites, customized themes, and implemented client-specific functionality. Handled website migrations, resolved technical issues, configured hosting environments, and supported clients with ongoing website maintenance and troubleshooting.', 'pixelpost' ),
			'tags'    => 'WordPress Development, Theme Customization, Website Migrations, Hosting & DNS, Website Maintenance',
		),
	);
}

/**
 * Return default projects array matching Parag Das's tools & products
 *
 * @return array
 */
function pixelpost_get_default_projects() {
	return array(
		array(
			'title'       => 'WP Stack Report',
			'description' => __( 'A focused WordPress diagnostics and stack detection utility to quickly identify active themes, parent themes, plugins, and server environments for efficient troubleshooting and audits.', 'pixelpost' ),
			'icon'        => 'travel_explore',
			'badge1'      => __( 'Developer Tool', 'pixelpost' ),
			'badge2'      => __( 'Active', 'pixelpost' ),
			'type_label'  => __( 'Site Diagnostics', 'pixelpost' ),
			'type_icon'   => 'insights',
			'url'         => '#',
			'order'       => 1,
		),
		array(
			'title'       => 'DebugZen',
			'description' => __( 'A powerful, zero-bloat debug log viewer for WordPress. Parses massive debug.log files instantly via asynchronous streaming, highlighting fatal errors, notices, and stack traces with modern search and filter controls.', 'pixelpost' ),
			'icon'        => 'bug_report',
			'badge1'      => __( 'Free Tool', 'pixelpost' ),
			'badge2'      => __( 'Active', 'pixelpost' ),
			'type_label'  => __( 'Developer Utility', 'pixelpost' ),
			'type_icon'   => 'terminal',
			'url'         => '#',
			'order'       => 2,
		),
		array(
			'title'       => 'WP Command Center',
			'description' => __( 'Centralized WordPress administrative toolbar and utility deck. Execute cache flushes, trigger cron routines, toggle maintenance screens, and review database health directly from a sleek keyboard-driven command palette.', 'pixelpost' ),
			'icon'        => 'tune',
			'badge1'      => __( 'Utilities', 'pixelpost' ),
			'badge2'      => __( 'Active', 'pixelpost' ),
			'type_label'  => __( 'Admin Management', 'pixelpost' ),
			'type_icon'   => 'widgets',
			'url'         => '#',
			'order'       => 3,
		),
		array(
			'title'       => 'Editorial Theme Boilerplate',
			'description' => __( 'An ultra-fast, minimal, developer-first WordPress theme engineered for technical portfolios and content authors. Ships with strict type enforcement, minimal asset footprint (sub-25KB bundle), and zero legacy jQuery.', 'pixelpost' ),
			'icon'        => 'layers',
			'badge1'      => __( 'Boilerplate', 'pixelpost' ),
			'badge2'      => __( 'Open Source', 'pixelpost' ),
			'type_label'  => __( '100 PageSpeed', 'pixelpost' ),
			'type_icon'   => 'speed',
			'url'         => '#',
			'order'       => 4,
		),
	);
}

/**
 * Return default feature bullets for About Me section
 *
 * @return array
 */
function pixelpost_get_default_about_bullets() {
	return array(
		array( 'text' => __( 'Root-Cause Analysis', 'pixelpost' ) ),
		array( 'text' => __( 'Technical Troubleshooting', 'pixelpost' ) ),
		array( 'text' => __( 'Quality Assurance & Testing', 'pixelpost' ) ),
		array( 'text' => __( 'Clear Documentation & Communication', 'pixelpost' ) ),
	);
}

/**
 * Return default contact channel cards matching Parag Das's profile
 *
 * @return array
 */
function pixelpost_get_default_contact_items() {
	return array(
		array(
			'label'   => __( 'Direct Inquiry', 'pixelpost' ),
			'value'   => 'hello@example.com',
			'link'    => 'mailto:hello@example.com',
			'context' => __( 'Best for technical discussions, professional inquiries, and collaboration.', 'pixelpost' ),
			'icon'    => 'alternate_email',
		),
		array(
			'label'   => __( 'Current Base', 'pixelpost' ),
			'value'   => 'San Francisco, CA',
			'link'    => '',
			'context' => __( 'Connecting with the global WordPress community.', 'pixelpost' ),
			'icon'    => 'location_on',
		),
		array(
			'label'   => __( 'Professional Focus', 'pixelpost' ),
			'value'   => __( 'WordPress Technical Support & Development', 'pixelpost' ),
			'link'    => '',
			'context' => __( 'Focused on troubleshooting, quality assurance, and building better WordPress experiences.', 'pixelpost' ),
			'icon'    => 'check_circle',
		),
	);
}

/**
 * Return default blog posts for fallback display
 *
 * @return array
 */
function pixelpost_get_default_blog_posts() {
	return array(
		array(
			'title'     => __( 'Eliminating High Server Load Caused by WP-Cron Saturation', 'pixelpost' ),
			'date'      => 'SEP 04, 2026',
			'read_time' => '5 MIN READ',
			'category'  => 'Performance',
			'excerpt'   => __( 'How moving automated tasks to a real system crontab freed up critical PHP workers and slashed database contention during peak traffic spikes.', 'pixelpost' ),
			'url'       => '#',
		),
		array(
			'title'     => __( 'Diagnosing Transients and Object Cache Pollution', 'pixelpost' ),
			'date'      => 'AUG 18, 2026',
			'read_time' => '7 MIN READ',
			'category'  => 'Architecture',
			'excerpt'   => __( 'Why oversized autoloaded options silently cripple your initial response times, and the exact query commands to purge stale cache records.', 'pixelpost' ),
			'url'       => '#',
		),
		array(
			'title'     => __( 'Post-Mortem: Surgical Cleanup of Injected Backdoors', 'pixelpost' ),
			'date'      => 'JUL 29, 2026',
			'read_time' => '4 MIN READ',
			'category'  => 'Security',
			'excerpt'   => __( 'Step-by-step methodology for isolating malicious base64 obfuscations inside wp-content uploads without risking user media libraries.', 'pixelpost' ),
			'url'       => '#',
		),
		array(
			'title'     => __( 'Resolving WooCommerce Cart Fragments and AJAX Latency', 'pixelpost' ),
			'date'      => 'JUN 11, 2026',
			'read_time' => '6 MIN READ',
			'category'  => 'WooCommerce',
			'excerpt'   => __( 'Unpacking the legacy session polling routines that make store frontends sluggish, and modern script alternatives for instant client-side cart updates.', 'pixelpost' ),
			'url'       => '#',
		),
	);
}

/**
 * Return default social profile links
 *
 * @return array
 */
function pixelpost_get_default_social_links() {
	return array(
		array(
			'title' => 'GitHub',
			'url'   => 'https://github.com/',
			'icon'  => 'github',
			'label' => __( 'Code Repositories', 'pixelpost' ),
		),
		array(
			'title' => 'LinkedIn',
			'url'   => 'https://linkedin.com/',
			'icon'  => 'linkedin',
			'label' => __( 'Professional Network', 'pixelpost' ),
		),
		array(
			'title' => 'X / Twitter',
			'url'   => 'https://x.com/',
			'icon'  => 'twitter',
			'label' => __( 'Public Broadcasts', 'pixelpost' ),
		),
		array(
			'title' => 'Email',
			'url'   => 'mailto:hello@example.com',
			'icon'  => 'mail',
			'label' => __( 'Email Inquiry', 'pixelpost' ),
		),
	);
}

/**
 * Returns default values for all theme settings
 *
 * @param string $key Setting key.
 * @return mixed
 */
function pixelpost_get_theme_default( $key ) {
	$defaults = array(
		// Global Design
		'pixelpost_color_bg'                    => '#FBF9F5',
		'pixelpost_color_surface'               => '#FBF9F5',
		'pixelpost_color_text'                  => '#1B1C1A',
		'pixelpost_color_accent'                => '#994200',
		'pixelpost_color_border'                => '#E4E2DE',
		'pixelpost_container_max_width'         => '1200',

		// Header
		'pixelpost_header_sticky'               => true,
		'pixelpost_header_tagline_show'         => false,

		// SEO & Meta Tags
		'pixelpost_seo_enable'                  => true,
		'pixelpost_seo_meta_desc'               => 'WordPress Technical Support Engineer solving complex architecture bottlenecks, plugin conflicts, database corruptions, and performance issues.',
		'pixelpost_seo_og_enable'               => true,
		'pixelpost_seo_og_image'                => '',

		// Homepage Visibility
		'pixelpost_frontpage_show_sections'     => true,
		'pixelpost_section_hero_show'           => true,
		'pixelpost_section_stats_show'          => true,
		'pixelpost_section_skills_show'         => true,
		'pixelpost_section_experience_show'     => true,
		'pixelpost_section_projects_show'       => true,
		'pixelpost_section_impact_show'         => false,
		'pixelpost_section_posts_show'          => true,
		'pixelpost_section_about_show'          => true,
		'pixelpost_section_contact_show'        => true,

		// Section Order
		'pixelpost_section_order'               => 'hero,stats,skills,experience,projects,posts,about,contact',

		// Hero Section
		'pixelpost_hero_eyebrow'                => 'WordPress Support & Architecture',
		'pixelpost_hero_headline'               => 'Hi, I’m',
		'pixelpost_hero_accent'                 => 'Alex Rivera',
		'pixelpost_hero_role'                   => 'WordPress Technical Support Engineer & Core Problem Solver',
		'pixelpost_hero_description'            => 'Specializing in WordPress since 2010. Focused on technical support, theme and plugin troubleshooting, PHP debugging, compatibility testing, and building developer tools.',
		'pixelpost_hero_btn_primary_text'       => 'View My Work',
		'pixelpost_hero_btn_primary_url'        => '#projects',
		'pixelpost_hero_btn_secondary_text'     => 'Read My Articles',
		'pixelpost_hero_btn_secondary_url'      => '#blog',
		'pixelpost_hero_image'                  => '',

		// Statistics (Repeater + Flat fallbacks)
		'pixelpost_stats_items'                 => wp_json_encode( pixelpost_get_default_stats() ),
		'pixelpost_stat1_number'                => '200',
		'pixelpost_stat1_suffix'                => '+',
		'pixelpost_stat1_label'                 => 'WordPress websites',
		'pixelpost_stat1_desc'                  => 'Built, maintained, and supported WordPress websites across a variety of projects.',

		'pixelpost_stat2_number'                => '15',
		'pixelpost_stat2_suffix'                => '+',
		'pixelpost_stat2_label'                 => 'Years in web development',
		'pixelpost_stat2_desc'                  => 'Hands-on experience building for the web and solving real-world technical challenges.',

		'pixelpost_stat3_number'                => '10',
		'pixelpost_stat3_suffix'                => '+',
		'pixelpost_stat3_label'                 => 'Themes and plugins',
		'pixelpost_stat3_desc'                  => 'Experience troubleshooting, customizing, and improving WordPress themes and plugins.',

		'pixelpost_stat4_number'                => '8',
		'pixelpost_stat4_suffix'                => '+',
		'pixelpost_stat4_label'                 => 'WordCamps attended',
		'pixelpost_stat4_desc'                  => 'Connected with the WordPress community and engaged with fellow enthusiasts and contributors.',

		// Skills (Repeater + Legacy textarea fallback)
		'pixelpost_skills_eyebrow'              => 'Skills & Capabilities',
		'pixelpost_skills_heading'              => 'Tools, technologies & areas I work with',
		'pixelpost_skills_subtitle'             => 'A focused set of tools and technologies I use daily to solve production crashes, build robust extensions, and ensure seamless WordPress operations.',
		'pixelpost_skills_view_all_show'        => true,
		'pixelpost_skills_view_all_text'        => 'View full breakdown',
		'pixelpost_skills_view_all_url'         => '#experience',
		'pixelpost_skills_items'                => wp_json_encode( pixelpost_get_default_skills() ),
		'pixelpost_skills_list'                 => "WordPress Core\nPHP 8.x\nMySQL / MariaDB\nHTML5 / CSS3\nModern JavaScript\nWooCommerce\nElementor Pro\nAdvanced Custom Fields\nGutenberg Blocks\nWP-CLI\nGit / GitHub\ncPanel & WHM\nRedis & Memcached\nCore Web Vitals\nMalware Cleanup\nDatabase Optimization",

		// Experience (Repeater + Flat fallbacks)
		'pixelpost_exp_eyebrow'                 => 'Career Path',
		'pixelpost_exp_heading'                 => 'Work Experience',
		'pixelpost_exp_subtitle'                => 'Over a decade supporting leading marketplaces, digital agencies, and demanding enterprise web environments.',
		'pixelpost_experience_items'            => wp_json_encode( pixelpost_get_default_experience() ),

		'pixelpost_exp1_title'                  => 'Associate Lead — Tech Support',
		'pixelpost_exp1_company'                => 'Ollyo',
		'pixelpost_exp1_url'                    => 'https://ollyo.com',
		'pixelpost_exp1_date'                   => '2024 – Present',
		'pixelpost_exp1_desc'                   => 'Lead complex technical investigations and provide advanced support for commercial WordPress themes and plugins. Troubleshoot compatibility issues, investigate bugs, resolve WooCommerce conflicts, and collaborate with development teams to improve product stability and customer experience.',

		'pixelpost_exp2_title'                  => 'Analyst, Tech Support',
		'pixelpost_exp2_company'                => 'Ollyo',
		'pixelpost_exp2_url'                    => 'https://ollyo.com',
		'pixelpost_exp2_date'                   => '2021 – 2024',
		'pixelpost_exp2_desc'                   => 'Provided technical support for WordPress products, helping customers resolve theme and plugin issues through systematic debugging, code analysis, and practical solutions. Investigated compatibility problems, reproduced reported bugs, and collaborated with internal teams to improve product quality and resolve complex technical issues.',

		'pixelpost_exp3_title'                  => 'Web Developer',
		'pixelpost_exp3_company'                => 'MAGNIFYADS',
		'pixelpost_exp3_url'                    => '',
		'pixelpost_exp3_date'                   => '2017 – 2021',
		'pixelpost_exp3_desc'                   => 'Developed and maintained WordPress websites, customized themes, and implemented client-specific functionality. Handled website migrations, resolved technical issues, configured hosting environments, and supported clients with ongoing website maintenance and troubleshooting.',

		// Projects (Repeater)
		'pixelpost_projects_eyebrow'            => 'Open Source & Tools',
		'pixelpost_projects_heading'            => 'Plugins & Products',
		'pixelpost_projects_subtitle'           => 'Some of the developer utilities, administrative enhancements, and standalone products I have engineered and maintained for the WordPress community.',
		'pixelpost_projects_view_all_show'      => true,
		'pixelpost_projects_view_all_text'      => 'Request custom tool',
		'pixelpost_projects_view_all_url'       => '#contact',
		'pixelpost_projects_count'              => 4,
		'pixelpost_projects_items'              => wp_json_encode( pixelpost_get_default_projects() ),

		// Blog
		'pixelpost_blog_eyebrow'                => 'Knowledge Base',
		'pixelpost_blog_heading'                => 'Recently On The Blog',
		'pixelpost_blog_subtitle'               => 'Practical diagnostic walkthroughs, performance case studies, and engineering notes on modern WordPress systems.',
		'pixelpost_blog_view_all_text'          => 'View all posts',
		'pixelpost_blog_view_all_url'           => '',
		'pixelpost_blog_posts_count'            => 4,

		// About (Repeater + Flat fallbacks)
		'pixelpost_about_eyebrow'               => 'About Me',
		'pixelpost_about_heading'               => 'Bridging the gap between complex code and operational peace of mind.',
		'pixelpost_about_text'                  => "<p>I have been working on the web since 2009 and specializing in WordPress since 2010. Currently working at Ollyo as an Associate Lead in Tech Support, I focus on solving complex technical challenges across commercial themes and plugins, PHP debugging, quality assurance, and developer tools.</p>\n<p>Over the years, I have worked on 200+ WordPress websites and actively contributed to the open-source community. My approach is centered on root-cause analysis: understanding how systems work under the hood, reproducing issues accurately, and providing clear, sustainable solutions.</p>",
		'pixelpost_about_image'                 => '',
		'pixelpost_about_bullets'               => wp_json_encode( pixelpost_get_default_about_bullets() ),
		'pixelpost_about_bullet1'               => 'Root-Cause Analysis',
		'pixelpost_about_bullet2'               => 'Technical Troubleshooting',
		'pixelpost_about_bullet3'               => 'Quality Assurance & Testing',
		'pixelpost_about_bullet4'               => 'Clear Documentation & Communication',

		// Contact (Repeater + Flat fallbacks)
		'pixelpost_contact_eyebrow'             => 'Get In Touch',
		'pixelpost_contact_heading'             => 'Let’s Talk',
		'pixelpost_contact_heading_accent'      => 'WordPress',
		'pixelpost_contact_description'         => 'Have a critical question, need rapid emergency support, or want to collaborate on a long-term contract? I’m always open to discussing new technical projects and architecture challenges.',
		'pixelpost_contact_btn_primary'         => 'Send an Email',
		'pixelpost_contact_btn_secondary'       => 'Schedule a Call',
		'pixelpost_contact_btn_secondary_url'   => 'https://calendly.com',
		'pixelpost_contact_items'               => wp_json_encode( pixelpost_get_default_contact_items() ),

		'pixelpost_contact_email_label'         => 'Direct Inquiry',
		'pixelpost_contact_email'               => 'hello@example.com',
		'pixelpost_contact_email_context'       => 'Best for technical discussions, professional inquiries, and collaboration.',

		'pixelpost_contact_location_label'      => 'Current Base',
		'pixelpost_contact_location'            => 'San Francisco, CA',
		'pixelpost_contact_location_context'    => 'Connecting with the global WordPress community.',

		'pixelpost_contact_avail_label'         => 'Professional Focus',
		'pixelpost_contact_availability_status' => 'WordPress Technical Support & Development',
		'pixelpost_contact_avail_context'       => 'Focused on troubleshooting, quality assurance, and building better WordPress experiences.',

		// Footer (Repeater + Flat fallbacks)
		'pixelpost_footer_tagline'              => 'Dedicated WordPress Technical Support Engineer solving complex architecture bottlenecks, plugin conflicts, database corruptions, and performance issues with architectural precision.',
		'pixelpost_footer_nav_show'             => true,
		'pixelpost_footer_nav_title'            => 'Navigation',
		'pixelpost_footer_widgets_show'         => false,
		'pixelpost_footer_copyright'            => '© {year} {sitename}. All rights reserved.',
		'pixelpost_footer_back_to_top_show'     => true,
		'pixelpost_footer_back_to_top_text'     => 'Back to top',
		'pixelpost_social_links'                => wp_json_encode( pixelpost_get_default_social_links() ),
		'pixelpost_social_github'               => 'https://github.com',
		'pixelpost_social_linkedin'             => 'https://linkedin.com',
		'pixelpost_social_twitter'              => 'https://x.com',
		'pixelpost_social_email'                => 'hello@example.com',
	);

	return isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';
}

/**
 * Get setting value with fallback to default and legacy prefix
 *
 * @param string $key Theme mod name.
 * @return mixed
 */
function pixelpost_get_setting( $key ) {
	$default = pixelpost_get_theme_default( $key );
	$val     = get_theme_mod( $key, null );
	if ( null !== $val && '' !== $val ) {
		return $val;
	}

	// Fallback to legacy prefix if present in database
	if ( strpos( $key, 'pixelpost_' ) === 0 ) {
		$legacy_key = 'folio' . 'press_' . substr( $key, 10 );
		$legacy_val = get_theme_mod( $legacy_key, null );
		if ( null !== $legacy_val && '' !== $legacy_val ) {
			return $legacy_val;
		}
	}

	return $default;
}

/**
 * Sanitize repeater JSON data
 *
 * @param mixed $input Input string or array.
 * @return string JSON-encoded sanitized string.
 */
function pixelpost_sanitize_repeater( $input ) {
	if ( empty( $input ) ) {
		return '[]';
	}
	$decoded = is_array( $input ) ? $input : json_decode( $input, true );
	if ( ! is_array( $decoded ) || json_last_error() !== JSON_ERROR_NONE ) {
		return '[]';
	}

	$sanitized = array();
	foreach ( $decoded as $item ) {
		if ( ! is_array( $item ) ) {
			continue;
		}
		$clean_item = array();
		foreach ( $item as $key => $value ) {
			$clean_key = sanitize_key( $key );
			if ( is_bool( $value ) || '1' === $value || '0' === $value ) {
				$clean_item[ $clean_key ] = (bool) $value;
			} elseif ( strpos( $clean_key, 'url' ) !== false || strpos( $clean_key, 'link' ) !== false ) {
				$clean_item[ $clean_key ] = esc_url_raw( (string) $value );
			} elseif ( 'desc' === $clean_key || 'description' === $clean_key || 'content' === $clean_key ) {
				$clean_item[ $clean_key ] = sanitize_textarea_field( (string) $value );
			} else {
				$clean_item[ $clean_key ] = sanitize_text_field( (string) $value );
			}
		}
		if ( ! empty( $clean_item ) ) {
			$sanitized[] = $clean_item;
		}
	}

	return wp_json_encode( $sanitized );
}

/**
 * Helper to decode repeater theme mod with fallback
 *
 * @param string $mod_name Setting/theme mod name.
 * @param array  $fallback Fallback array.
 * @return array
 */
function pixelpost_get_repeater_data( $mod_name, $fallback = array() ) {
	$raw = get_theme_mod( $mod_name, null );

	if ( ( null === $raw || '' === $raw ) && strpos( $mod_name, 'pixelpost_' ) === 0 ) {
		$legacy_key = 'folio' . 'press_' . substr( $mod_name, 10 );
		$legacy_raw = get_theme_mod( $legacy_key, null );
		if ( null !== $legacy_raw && '' !== $legacy_raw ) {
			$raw = $legacy_raw;
		}
	}

	if ( null === $raw || '' === $raw ) {
		return $fallback;
	}

	if ( is_array( $raw ) ) {
		return ! empty( $raw ) ? $raw : $fallback;
	}

	if ( is_string( $raw ) ) {
		$decoded = json_decode( $raw, true );
		if ( is_array( $decoded ) && ! empty( $decoded ) ) {
			return $decoded;
		}
	}

	return $fallback;
}

/**
 * Get active experience items (repeater data with fallback to legacy flat theme mods)
 *
 * @return array
 */
function pixelpost_get_experience_items() {
	$defaults = pixelpost_get_default_experience();
	$items    = pixelpost_get_repeater_data( 'pixelpost_experience_items', array() );

	if ( ! empty( $items ) ) {
		return $items;
	}

	// Legacy per-field fallback check
	$legacy_items = array();
	for ( $i = 1; $i <= 3; $i++ ) {
		$title   = get_theme_mod( "pixelpost_exp{$i}_title", null );
		$company = get_theme_mod( "pixelpost_exp{$i}_company", null );
		$url     = get_theme_mod( "pixelpost_exp{$i}_url", null );
		$date    = get_theme_mod( "pixelpost_exp{$i}_date", null );
		$desc    = get_theme_mod( "pixelpost_exp{$i}_desc", null );

		if ( ! empty( $title ) ) {
			$legacy_items[] = array(
				'title'   => $title,
				'company' => $company,
				'url'     => $url,
				'date'    => $date,
				'desc'    => $desc,
			);
		}
	}

	if ( ! empty( $legacy_items ) ) {
		return $legacy_items;
	}

	return $defaults;
}

/**
 * Get active skills items (repeater data with fallback to legacy list)
 *
 * @return array
 */
function pixelpost_get_skills_items() {
	$defaults = pixelpost_get_default_skills();
	$items    = pixelpost_get_repeater_data( 'pixelpost_skills_items', array() );

	if ( ! empty( $items ) ) {
		return $items;
	}

	// Legacy textarea fallback
	$legacy_raw = get_theme_mod( 'pixelpost_skills_list', null );
	if ( ! empty( $legacy_raw ) ) {
		$lines  = explode( "\n", str_replace( "\r", '', $legacy_raw ) );
		$skills = array();
		foreach ( $lines as $line ) {
			$trimmed = trim( $line );
			if ( ! empty( $trimmed ) ) {
				$skills[] = array( 'name' => $trimmed );
			}
		}
		if ( ! empty( $skills ) ) {
			return $skills;
		}
	}

	return $defaults;
}

/**
 * Get active stats items (repeater data with fallback to legacy flat theme mods)
 *
 * @return array
 */
function pixelpost_get_stats_items() {
	$defaults = pixelpost_get_default_stats();
	$items    = pixelpost_get_repeater_data( 'pixelpost_stats_items', array() );

	if ( ! empty( $items ) ) {
		return $items;
	}

	// Legacy per-field fallback check
	$legacy_items = array();
	for ( $i = 1; $i <= 4; $i++ ) {
		$number = get_theme_mod( "pixelpost_stat{$i}_number", null );
		$suffix = get_theme_mod( "pixelpost_stat{$i}_suffix", null );
		$label  = get_theme_mod( "pixelpost_stat{$i}_label", null );
		$desc   = get_theme_mod( "pixelpost_stat{$i}_desc", null );

		if ( ! empty( $number ) || ! empty( $label ) ) {
			$legacy_items[] = array(
				'number' => $number,
				'suffix' => $suffix,
				'label'  => $label,
				'desc'   => $desc,
			);
		}
	}

	if ( ! empty( $legacy_items ) ) {
		return $legacy_items;
	}

	return $defaults;
}

/**
 * Get active projects items (repeater data with fallback)
 *
 * @return array
 */
function pixelpost_get_projects_items() {
	$defaults = pixelpost_get_default_projects();
	return pixelpost_get_repeater_data( 'pixelpost_projects_items', $defaults );
}

/**
 * Get active about me bullets (repeater data with fallback to legacy flat theme mods)
 *
 * @return array
 */
function pixelpost_get_about_bullets() {
	$defaults = pixelpost_get_default_about_bullets();
	$items    = pixelpost_get_repeater_data( 'pixelpost_about_bullets', array() );

	if ( ! empty( $items ) ) {
		return $items;
	}

	// Legacy flat fields check
	$legacy_bullets = array();
	for ( $b = 1; $b <= 4; $b++ ) {
		$val = get_theme_mod( "pixelpost_about_bullet{$b}", null );
		if ( ! empty( $val ) ) {
			$legacy_bullets[] = array( 'text' => $val );
		}
	}
	if ( ! empty( $legacy_bullets ) ) {
		return $legacy_bullets;
	}

	return $defaults;
}

/**
 * Get active contact items (repeater data with fallback to legacy flat theme mods)
 *
 * @return array
 */
function pixelpost_get_contact_items() {
	$defaults = pixelpost_get_default_contact_items();
	$items    = pixelpost_get_repeater_data( 'pixelpost_contact_items', array() );

	if ( ! empty( $items ) ) {
		return $items;
	}

	// Legacy individual flat theme mods check
	$email_label   = pixelpost_get_setting( 'pixelpost_contact_email_label' );
	$email_val     = pixelpost_get_setting( 'pixelpost_contact_email' );
	$email_context = pixelpost_get_setting( 'pixelpost_contact_email_context' );

	$loc_label     = pixelpost_get_setting( 'pixelpost_contact_location_label' );
	$loc_val       = pixelpost_get_setting( 'pixelpost_contact_location' );
	$loc_context   = pixelpost_get_setting( 'pixelpost_contact_location_context' );

	$avail_label   = pixelpost_get_setting( 'pixelpost_contact_avail_label' );
	$avail_val     = pixelpost_get_setting( 'pixelpost_contact_availability_status' );
	$avail_context = pixelpost_get_setting( 'pixelpost_contact_avail_context' );

	$legacy_items = array();

	if ( ! empty( $email_val ) ) {
		$legacy_items[] = array(
			'label'   => ! empty( $email_label ) ? $email_label : __( 'Direct Inquiry', 'pixelpost' ),
			'value'   => $email_val,
			'link'    => 'mailto:' . $email_val,
			'context' => ! empty( $email_context ) ? $email_context : '',
			'icon'    => 'alternate_email',
		);
	}

	if ( ! empty( $loc_val ) ) {
		$legacy_items[] = array(
			'label'   => ! empty( $loc_label ) ? $loc_label : __( 'Current Base', 'pixelpost' ),
			'value'   => $loc_val,
			'link'    => '',
			'context' => ! empty( $loc_context ) ? $loc_context : '',
			'icon'    => 'location_on',
		);
	}

	if ( ! empty( $avail_val ) ) {
		$legacy_items[] = array(
			'label'   => ! empty( $avail_label ) ? $avail_label : __( 'Professional Focus', 'pixelpost' ),
			'value'   => $avail_val,
			'link'    => '',
			'context' => ! empty( $avail_context ) ? $avail_context : '',
			'icon'    => 'check_circle',
		);
	}

	if ( ! empty( $legacy_items ) ) {
		return $legacy_items;
	}

	return $defaults;
}

/**
 * Get active social profile links (repeater data with fallback to legacy flat theme mods)
 *
 * @return array
 */
function pixelpost_get_social_links() {
	$defaults = pixelpost_get_default_social_links();
	$items    = pixelpost_get_repeater_data( 'pixelpost_social_links', array() );

	if ( ! empty( $items ) ) {
		return $items;
	}

	// Legacy flat fields check
	$github   = get_theme_mod( 'pixelpost_social_github', null );
	$linkedin = get_theme_mod( 'pixelpost_social_linkedin', null );
	$twitter  = get_theme_mod( 'pixelpost_social_twitter', null );
	$email    = get_theme_mod( 'pixelpost_social_email', null );

	$legacy_links = array();
	if ( ! empty( $github ) ) {
		$legacy_links[] = array(
			'title' => 'GitHub',
			'url'   => $github,
			'icon'  => 'github',
			'label' => __( 'Code Repositories', 'pixelpost' ),
		);
	}
	if ( ! empty( $linkedin ) ) {
		$legacy_links[] = array(
			'title' => 'LinkedIn',
			'url'   => $linkedin,
			'icon'  => 'linkedin',
			'label' => __( 'Professional Network', 'pixelpost' ),
		);
	}
	if ( ! empty( $twitter ) ) {
		$legacy_links[] = array(
			'title' => 'X / Twitter',
			'url'   => $twitter,
			'icon'  => 'twitter',
			'label' => __( 'Public Broadcasts', 'pixelpost' ),
		);
	}
	if ( ! empty( $email ) ) {
		$legacy_links[] = array(
			'title' => 'Email',
			'url'   => ( strpos( $email, 'mailto:' ) === 0 ) ? $email : 'mailto:' . $email,
			'icon'  => 'mail',
			'label' => __( 'Email Inquiry', 'pixelpost' ),
		);
	}

	if ( ! empty( $legacy_links ) ) {
		return $legacy_links;
	}

	return $defaults;
}

/**
 * Return the URL for the Blog Archive page
 *
 * @return string URL to the blog archive.
 */
function pixelpost_get_blog_archive_url() {
	// 1. Customizer manual setting
	$custom_url = pixelpost_get_setting( 'pixelpost_blog_view_all_url' );
	if ( ! empty( $custom_url ) ) {
		return $custom_url;
	}

	// 2. Reading settings page_for_posts
	$posts_page_id = get_option( 'page_for_posts' );
	if ( $posts_page_id && 'publish' === get_post_status( $posts_page_id ) ) {
		return get_permalink( $posts_page_id );
	}

	// 3. Page with path 'blog'
	$blog_page = get_page_by_path( 'blog' );
	if ( $blog_page && 'publish' === get_post_status( $blog_page->ID ) ) {
		return get_permalink( $blog_page->ID );
	}

	// 4. Page with path 'blogs'
	$blogs_page = get_page_by_path( 'blogs' );
	if ( $blogs_page && 'publish' === get_post_status( $blogs_page->ID ) ) {
		return get_permalink( $blogs_page->ID );
	}

	return home_url( '/blog/' );
}

/**
 * Auto-migrate legacy theme mods to pixelpost_* prefix
 */
function pixelpost_migrate_legacy_theme_mods() {
	$mods = get_theme_mods();
	if ( empty( $mods ) || ! is_array( $mods ) ) {
		return;
	}

	$prefix = 'folio' . 'press_';
	$plen   = strlen( $prefix );

	foreach ( $mods as $k => $v ) {
		if ( strpos( $k, $prefix ) === 0 ) {
			$new_key = 'pixelpost_' . substr( $k, $plen );
			if ( ! isset( $mods[ $new_key ] ) ) {
				set_theme_mod( $new_key, $v );
			}
		}
	}
}
add_action( 'after_setup_theme', 'pixelpost_migrate_legacy_theme_mods', 5 );
add_action( 'admin_init', 'pixelpost_migrate_legacy_theme_mods', 5 );
