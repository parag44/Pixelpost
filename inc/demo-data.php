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
			'title'       => __( 'Core & Development', 'pixelpost' ),
			'icon'        => 'code',
			'tags'        => 'WordPress Core, PHP 8+, MySQL / MariaDB, HTML5, CSS3, JavaScript (ES6+), REST API',
			'column'      => 'left',
		),
		array(
			'title'       => __( 'Tools & Workflow', 'pixelpost' ),
			'icon'        => 'terminal',
			'tags'        => 'VS Code, Git, GitHub, Local Development Environments, WP-CLI, cPanel, SSH, Linux Basics',
			'column'      => 'left',
		),
		array(
			'title'       => __( 'Testing & QA', 'pixelpost' ),
			'icon'        => 'verified',
			'tags'        => 'Functional Testing, Bug Reproduction, Cross-browser Testing, Performance Testing',
			'column'      => 'left',
		),
		array(
			'title'       => __( 'Plugins & Customization', 'pixelpost' ),
			'icon'        => 'extension',
			'tags'        => 'WooCommerce, Elementor Pro, ACF (Advanced Custom Fields), WPML, Polylang, Custom Post Types',
			'column'      => 'right',
		),
		array(
			'title'       => __( 'Hosting & Server', 'pixelpost' ),
			'icon'        => 'server',
			'tags'        => 'Server Tuning, Cache (LiteSpeed / Redis), Database Optimization, Security & Backups',
			'column'      => 'right',
		),
		array(
			'title'       => __( 'Product & Support', 'pixelpost' ),
			'icon'        => 'chat',
			'tags'        => 'Technical Support, Troubleshooting, Documentation, Client Communication',
			'column'      => 'right',
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
			'company' => 'OLLYO',
			'url'     => 'https://ollyo.com',
			'date'    => '2024 – Present',
			'current' => true,
			'desc'    => __( 'Lead a team to provide technical support for commercial WordPress themes and plugins. Troubleshoot compatibility issues, investigate bugs, and improve product stability.', 'pixelpost' ),
			'tags'    => 'Technical Support · Theme & Plugin Support · QA Testing · WooCommerce · Team Collaboration',
		),
		array(
			'title'   => __( 'Analyst, Tech Support', 'pixelpost' ),
			'company' => 'OLLYO',
			'url'     => 'https://ollyo.com',
			'date'    => '2021 – 2024',
			'current' => false,
			'desc'    => __( 'Provided technical support for WordPress products, resolved theme and plugin issues, and helped customers with customization and integrations.', 'pixelpost' ),
			'tags'    => 'WordPress Debugging · Plugin Compatibility · Issue Reproduction · Technical Documentation',
		),
		array(
			'title'   => __( 'Web Developer', 'pixelpost' ),
			'company' => 'Marketplace Projects',
			'url'     => '',
			'date'    => '2017 – 2021',
			'current' => false,
			'desc'    => __( 'Developed and maintained WordPress websites, customized themes, and implemented client-specific functionality. Handled website migrations, resolved technical issues, and ongoing maintenance.', 'pixelpost' ),
			'tags'    => 'WordPress Development · Theme Customization · Website Migration · Performance Optimization',
		),
	);
}

/**
 * Return default projects array matching Parag Das's tools & products
 *
 * @return array
 */
function pixelpost_get_default_projects() {
	$img_uri = get_template_directory_uri() . '/assets/images';
	return array(
		array(
			'title'       => 'DebugZen',
			'description' => __( 'Safe in-dashboard WordPress debugging without FTP. Manage wp-config.php debug constants and inspect, filter, or clear logs directly from your dashboard.', 'pixelpost' ),
			'icon'        => 'bug_report',
			'badge1'      => __( 'Debugging', 'pixelpost' ),
			'badge2'      => __( 'Active', 'pixelpost' ),
			'type_label'  => __( 'Developer Tool', 'pixelpost' ),
			'type_icon'   => 'terminal',
			'url'         => 'https://wordpress.org/plugins/debugzen/',
			'image'       => $img_uri . '/project-debugzen.svg',
			'order'       => 1,
		),
		array(
			'title'       => 'SiteIntelix',
			'description' => __( 'Developer & admin toolkit for diagnostics, debugging, and site administration. Features a DirectAdmin-inspired file manager, system health monitoring, and error reporting.', 'pixelpost' ),
			'icon'        => 'tune',
			'badge1'      => __( 'Diagnostics', 'pixelpost' ),
			'badge2'      => __( 'Active', 'pixelpost' ),
			'type_label'  => __( 'Admin Toolkit', 'pixelpost' ),
			'type_icon'   => 'widgets',
			'url'         => 'https://wordpress.org/plugins/siteintelix/',
			'image'       => $img_uri . '/project-siteintelix.svg',
			'order'       => 2,
		),
		array(
			'title'       => 'MailTally',
			'description' => __( 'Lightweight email logger and inspector for WordPress. Log, inspect, and troubleshoot outgoing emails sent through wp_mail() with full HTML and header preview.', 'pixelpost' ),
			'icon'        => 'mail',
			'badge1'      => __( 'Email Logger', 'pixelpost' ),
			'badge2'      => __( 'Active', 'pixelpost' ),
			'type_label'  => __( 'Email Testing', 'pixelpost' ),
			'type_icon'   => 'mail',
			'url'         => 'https://wordpress.org/plugins/parag-mail-inspector/',
			'image'       => $img_uri . '/project-mailtally.svg',
			'order'       => 3,
		),
		array(
			'title'       => 'WP Detector',
			'description' => __( 'Fast, lightweight Chrome extension for developers and site auditors. Instantly detects WordPress core version, active theme, child themes, installed plugins, and server technology with one click.', 'pixelpost' ),
			'icon'        => 'extension',
			'badge1'      => __( 'Chrome Extension', 'pixelpost' ),
			'badge2'      => __( 'Active', 'pixelpost' ),
			'type_label'  => __( 'Browser Extension', 'pixelpost' ),
			'type_icon'   => 'widgets',
			'url'         => 'https://chromewebstore.google.com/detail/wp-detector/pnfcaepdbhbioeplilbgliegcnclpake',
			'image'       => $img_uri . '/project-wp-detector.svg',
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
		array(
			'title' => __( 'Problem Solver', 'pixelpost' ),
			'desc'  => __( 'Enjoy complex challenges.', 'pixelpost' ),
			'icon'  => 'verified',
		),
		array(
			'title' => __( 'Detail Oriented', 'pixelpost' ),
			'desc'  => __( 'Quality in everything.', 'pixelpost' ),
			'icon'  => 'tune',
		),
		array(
			'title' => __( 'Team Player', 'pixelpost' ),
			'desc'  => __( 'Believe in collaboration.', 'pixelpost' ),
			'icon'  => 'chat',
		),
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
	$img_uri = get_template_directory_uri() . '/assets/images';
	return array(
		array(
			'title'     => __( 'What Fifteen Years in Tech Taught Me About Patience and Perspective', 'pixelpost' ),
			'date'      => 'OCT 28, 2024',
			'read_time' => '7 MIN READ',
			'category'  => 'Engineering',
			'excerpt'   => __( 'Reflections on endurance, technical humility, and why debugging complex production environments is more about temperament than raw syntax.', 'pixelpost' ),
			'image'     => $img_uri . '/blog-featured.svg',
			'url'       => '#',
		),
		array(
			'title'     => __( 'The Weight of Digital Clutter', 'pixelpost' ),
			'date'      => 'OCT 25, 2024',
			'read_time' => '5 MIN READ',
			'category'  => 'Mindset',
			'excerpt'   => __( 'Cultivating intentional tooling habits to reduce cognitive load and keep your daily development workspace focused and quiet.', 'pixelpost' ),
			'image'     => $img_uri . '/blog-thumb-1.svg',
			'url'       => '#',
		),
		array(
			'title'     => __( 'Seeing the Familiar Differently', 'pixelpost' ),
			'date'      => 'OCT 18, 2024',
			'read_time' => '5 MIN READ',
			'category'  => 'Photography',
			'excerpt'   => __( 'How documentary street photography trains an engineer’s attention to notice subtle edge cases and unspoken assumptions.', 'pixelpost' ),
			'image'     => $img_uri . '/blog-thumb-2.svg',
			'url'       => '#',
		),
		array(
			'title'     => __( 'Walking the City Alone', 'pixelpost' ),
			'date'      => 'OCT 11, 2024',
			'read_time' => '3 MIN READ',
			'category'  => 'Observations',
			'excerpt'   => __( 'The unexpected creative and architectural clarity found during unstructured solo wanderings through unfamiliar streets.', 'pixelpost' ),
			'image'     => $img_uri . '/blog-thumb-3.svg',
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
		'pixelpost_color_bg'                    => '#FAF9F6',
		'pixelpost_color_surface'               => '#FFFFFF',
		'pixelpost_color_text'                  => '#242321',
		'pixelpost_color_accent'                => '#A94F20',
		'pixelpost_color_border'                => '#E9E6E0',
		'pixelpost_container_max_width'         => '1140',

		// Header & Logo
		'pixelpost_header_sticky'               => true,
		'pixelpost_header_tagline_show'         => false,
		'pixelpost_logo_width'                  => '',
		'pixelpost_logo_height'                 => '44',

		// SEO & Meta Tags
		'pixelpost_seo_enable'                  => true,
		'pixelpost_seo_meta_desc'               => 'WordPress Specialist, QA Tester, and Developer helping businesses build, test, and maintain reliable WordPress websites and products.',
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
		'pixelpost_hero_eyebrow'                => 'WORDPRESS SPECIALIST · QA TESTER · DEVELOPER —',
		'pixelpost_hero_headline'               => 'Hi, I’m',
		'pixelpost_hero_accent'                 => 'Parag Das',
		'pixelpost_hero_role'                   => 'WordPress Specialist · QA Tester · Developer',
		'pixelpost_hero_description'            => 'I help businesses build, test, and maintain reliable WordPress websites and products. I work at the intersection of WordPress support, troubleshooting, QA, and product development.',
		'pixelpost_hero_location'               => 'Dhaka, Bangladesh',
		'pixelpost_hero_avail_status'           => 'Available for opportunities',
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
		'pixelpost_stat1_desc'                  => 'Built, maintained and supported for clients and products.',

		'pixelpost_stat2_number'                => '15',
		'pixelpost_stat2_suffix'                => '+',
		'pixelpost_stat2_label'                 => 'Years in web development',
		'pixelpost_stat2_desc'                  => 'Hands-on experience building and solving real-world challenges.',

		'pixelpost_stat3_number'                => '10',
		'pixelpost_stat3_suffix'                => '+',
		'pixelpost_stat3_label'                 => 'Themes and plugins',
		'pixelpost_stat3_desc'                  => 'Experience troubleshooting, customizing and improving WordPress themes and plugins.',

		'pixelpost_stat4_number'                => '8',
		'pixelpost_stat4_suffix'                => '+',
		'pixelpost_stat4_label'                 => 'WordCamps attended',
		'pixelpost_stat4_desc'                  => 'Connected with the WordPress community and contributed as an enthusiast.',

		// Skills (Repeater + Legacy textarea fallback)
		'pixelpost_skills_eyebrow'              => '01 — SKILLS & TECHNOLOGIES',
		'pixelpost_skills_heading'              => 'Tools I work with',
		'pixelpost_skills_subtitle'             => 'A focused set of tools and technologies I use daily to solve production issues, build custom features, and ensure seamless WordPress experiences.',
		'pixelpost_skills_view_all_show'        => false,
		'pixelpost_skills_view_all_text'        => 'View full breakdown',
		'pixelpost_skills_view_all_url'         => '#experience',
		'pixelpost_skills_items'                => wp_json_encode( pixelpost_get_default_skills() ),
		'pixelpost_skills_list'                 => "WordPress Core\nPHP 8+\nMySQL / MariaDB\nHTML5\nCSS3\nJavaScript (ES6+)\nREST API\nWooCommerce\nElementor Pro\nACF (Advanced Custom Fields)\nWPML\nPolylang\nCustom Post Types\nVS Code\nGit\nGitHub\nLocal Development Environments\nWP-CLI\ncPanel\nSSH\nLinux Basics\nServer Tuning\nCache (LiteSpeed / Redis)\nDatabase Optimization\nSecurity & Backups\nFunctional Testing\nBug Reproduction\nCross-browser Testing\nPerformance Testing\nTechnical Support\nTroubleshooting\nDocumentation\nClient Communication",

		// Experience (Repeater + Flat fallbacks)
		'pixelpost_exp_eyebrow'                 => '02 — WORK EXPERIENCE',
		'pixelpost_exp_heading'                 => 'My professional journey',
		'pixelpost_exp_subtitle'                => 'Over a decade supporting commercial WordPress themes, plugins, and web products.',
		'pixelpost_experience_items'            => wp_json_encode( pixelpost_get_default_experience() ),

		'pixelpost_exp1_title'                  => 'Associate Lead — Tech Support',
		'pixelpost_exp1_company'                => 'OLLYO',
		'pixelpost_exp1_url'                    => 'https://ollyo.com',
		'pixelpost_exp1_date'                   => '2024 – Present',
		'pixelpost_exp1_desc'                   => 'Lead a team to provide technical support for commercial WordPress themes and plugins. Troubleshoot compatibility issues, investigate bugs, and improve product stability.',

		'pixelpost_exp2_title'                  => 'Analyst, Tech Support',
		'pixelpost_exp2_company'                => 'OLLYO',
		'pixelpost_exp2_url'                    => 'https://ollyo.com',
		'pixelpost_exp2_date'                   => '2021 – 2024',
		'pixelpost_exp2_desc'                   => 'Provided technical support for WordPress products, resolved theme and plugin issues, and helped customers with customization and integrations.',

		'pixelpost_exp3_title'                  => 'Web Developer',
		'pixelpost_exp3_company'                => 'Marketplace Projects',
		'pixelpost_exp3_url'                    => '',
		'pixelpost_exp3_date'                   => '2017 – 2021',
		'pixelpost_exp3_desc'                   => 'Developed and maintained WordPress websites, customized themes, and implemented client-specific functionality. Handled website migrations, resolved technical issues, and ongoing maintenance.',

		// Projects (Repeater)
		'pixelpost_projects_eyebrow'            => '03 — PLUGINS & PRODUCTS',
		'pixelpost_projects_heading'            => 'Projects I’ve built',
		'pixelpost_projects_subtitle'           => 'Some of the developer utilities, administrative enhancements, and standalone products I have engineered and maintained.',
		'pixelpost_projects_view_all_show'      => true,
		'pixelpost_projects_view_all_text'      => 'View all projects',
		'pixelpost_projects_view_all_url'       => '#projects',
		'pixelpost_projects_count'              => 4,
		'pixelpost_projects_items'              => wp_json_encode( pixelpost_get_default_projects() ),

		// Blog
		'pixelpost_blog_eyebrow'                => '04 — WRITING & SHARING',
		'pixelpost_blog_heading'                => 'Latest from the blog',
		'pixelpost_blog_subtitle'               => 'Practical guides, real-world solutions, and lessons learned from working with WordPress, plugins, and web development.',
		'pixelpost_blog_view_all_text'          => 'View all articles',
		'pixelpost_blog_view_all_url'           => '',
		'pixelpost_blog_posts_count'            => 4,

		// About (Repeater + Flat fallbacks)
		'pixelpost_about_eyebrow'               => '05 — ABOUT ME',
		'pixelpost_about_heading'               => 'Turning complex WordPress problems into practical solutions.',
		'pixelpost_about_text'                  => "<p>I am a WordPress Technical Support Engineer with a strong background in troubleshooting, theme and plugin development, and quality assurance. I enjoy solving technical issues, building reliable websites, and sharing what I learn with the community.</p>",
		'pixelpost_about_image'                 => '',
		'pixelpost_about_bullets'               => wp_json_encode( pixelpost_get_default_about_bullets() ),
		'pixelpost_about_bullet1'               => 'Problem Solver',
		'pixelpost_about_bullet2'               => 'Detail Oriented',
		'pixelpost_about_bullet3'               => 'Team Player',
		'pixelpost_about_bullet4'               => '',

		// Contact (Repeater + Flat fallbacks)
		'pixelpost_contact_eyebrow'             => '06 — CONTACT',
		'pixelpost_contact_heading'             => 'Let’s work together',
		'pixelpost_contact_heading_accent'      => '',
		'pixelpost_contact_description'         => 'Have a WordPress issue, a technical question, or an idea to discuss? I’m always happy to connect with fellow developers, creators, and businesses.',
		'pixelpost_contact_btn_primary'         => 'Send an Email',
		'pixelpost_contact_btn_secondary'       => 'Schedule a Call',
		'pixelpost_contact_btn_secondary_url'   => 'https://calendly.com',
		'pixelpost_contact_items'               => wp_json_encode( pixelpost_get_default_contact_items() ),

		'pixelpost_contact_email_label'         => 'Direct Inquiry',
		'pixelpost_contact_email'               => 'parag.feni@yahoo.com',
		'pixelpost_contact_email_context'       => 'Best for technical discussions, professional inquiries, and collaboration.',

		'pixelpost_contact_location_label'      => 'Current Base',
		'pixelpost_contact_location'            => 'Dhaka, Bangladesh',
		'pixelpost_contact_location_context'    => 'Available for local and remote opportunities.',

		'pixelpost_contact_avail_label'         => 'Status',
		'pixelpost_contact_availability_status' => 'Available for opportunities',
		'pixelpost_contact_avail_context'       => 'WordPress Support, QA & Product Development',

		// Footer (Repeater + Flat fallbacks)
		'pixelpost_footer_tagline'              => 'WordPress specialist focused on troubleshooting, quality, and better web experiences.',
		'pixelpost_footer_nav_show'             => true,
		'pixelpost_footer_nav_title'            => 'Navigation',
		'pixelpost_footer_widgets_show'         => false,
		'pixelpost_footer_copyright'            => '© {year} {sitename}. All rights reserved.',
		'pixelpost_footer_back_to_top_show'     => true,
		'pixelpost_footer_back_to_top_text'     => 'Back to top',
		'pixelpost_social_links'                => wp_json_encode( pixelpost_get_default_social_links() ),
		'pixelpost_social_github'               => 'https://github.com/parag44',
		'pixelpost_social_linkedin'             => 'https://linkedin.com',
		'pixelpost_social_twitter'              => 'https://x.com',
		'pixelpost_social_email'                => 'parag.feni@yahoo.com',
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
