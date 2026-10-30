<?php
/**
 * Pixelpost Template Tags and Icon Helpers
 *
 * @package Pixelpost
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return inline SVG icons
 *
 * @param string $name Icon identifier.
 * @param array  $args Optional arguments (class, width, height, title).
 * @return string
 */
function pixelpost_get_icon( $name, $args = array() ) {
	$defaults = array(
		'class'  => 'fp-icon fp-icon-' . sanitize_html_class( $name ),
		'width'  => 20,
		'height' => 20,
		'title'  => '',
	);
	$args = wp_parse_args( $args, $defaults );

	$svg = '';

	switch ( $name ) {
		case 'envelope':
		case 'email':
		case 'mail':
			$svg = '<svg class="' . esc_attr( $args['class'] ) . '" width="' . esc_attr( $args['width'] ) . '" height="' . esc_attr( $args['height'] ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>';
			break;

		case 'location':
		case 'pin':
		case 'location_on':
			$svg = '<svg class="' . esc_attr( $args['class'] ) . '" width="' . esc_attr( $args['width'] ) . '" height="' . esc_attr( $args['height'] ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>';
			break;

		case 'paper-plane':
		case 'send':
			$svg = '<svg class="' . esc_attr( $args['class'] ) . '" width="' . esc_attr( $args['width'] ) . '" height="' . esc_attr( $args['height'] ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>';
			break;

		case 'calendar':
		case 'calendar_today':
			$svg = '<svg class="' . esc_attr( $args['class'] ) . '" width="' . esc_attr( $args['width'] ) . '" height="' . esc_attr( $args['height'] ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>';
			break;

		case 'arrow-right':
		case 'arrow_forward':
		case 'arrow-forward':
			$svg = '<svg class="' . esc_attr( $args['class'] ) . '" width="' . esc_attr( $args['width'] ) . '" height="' . esc_attr( $args['height'] ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>';
			break;

		case 'arrow-left':
		case 'arrow_back':
		case 'arrow-back':
			$svg = '<svg class="' . esc_attr( $args['class'] ) . '" width="' . esc_attr( $args['width'] ) . '" height="' . esc_attr( $args['height'] ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"/><path d="m12 19-7-7 7-7"/></svg>';
			break;

		case 'arrow-up':
		case 'arrow_upward':
		case 'arrow-upward':
			$svg = '<svg class="' . esc_attr( $args['class'] ) . '" width="' . esc_attr( $args['width'] ) . '" height="' . esc_attr( $args['height'] ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 19V5"/><path d="m5 12 7-7 7 7"/></svg>';
			break;

		case 'curved-arrow':
			$svg = '<svg class="' . esc_attr( $args['class'] ) . '" width="' . esc_attr( $args['width'] ) . '" height="' . esc_attr( $args['height'] ) . '" viewBox="0 0 42 28" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3 C6 18, 22 22, 36 21"/><polyline points="28,15 37,21 30,27"/></svg>';
			break;

		case 'bug':
		case 'debug':
		case 'bug_report':
			$svg = '<svg class="' . esc_attr( $args['class'] ) . '" width="' . esc_attr( $args['width'] ) . '" height="' . esc_attr( $args['height'] ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect width="8" height="14" x="8" y="6" rx="4"/><path d="m19 7-3 2"/><path d="m5 7 3 2"/><path d="m19 19-3-2"/><path d="m5 19 3-2"/><path d="M20 13h-4"/><path d="M4 13h4"/><path d="m10 4 1 2"/><path d="m14 4-1 2"/></svg>';
			break;

		case 'shield':
		case 'security':
			$svg = '<svg class="' . esc_attr( $args['class'] ) . '" width="' . esc_attr( $args['width'] ) . '" height="' . esc_attr( $args['height'] ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/></svg>';
			break;

		case 'globe':
		case 'public':
			$svg = '<svg class="' . esc_attr( $args['class'] ) . '" width="' . esc_attr( $args['width'] ) . '" height="' . esc_attr( $args['height'] ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>';
			break;

		case 'bolt':
		case 'zap':
			$svg = '<svg class="' . esc_attr( $args['class'] ) . '" width="' . esc_attr( $args['width'] ) . '" height="' . esc_attr( $args['height'] ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>';
			break;

		case 'design_services':
		case 'palette':
			$svg = '<svg class="' . esc_attr( $args['class'] ) . '" width="' . esc_attr( $args['width'] ) . '" height="' . esc_attr( $args['height'] ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m14 7 3 3-9 9H5v-3l9-9Z"/><path d="m19 5 2 2-2 2-2-2 2-2Z"/></svg>';
			break;

		case 'theme':
		case 'layout':
			$svg = '<svg class="' . esc_attr( $args['class'] ) . '" width="' . esc_attr( $args['width'] ) . '" height="' . esc_attr( $args['height'] ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg>';
			break;

		case 'github':
			$svg = '<svg class="' . esc_attr( $args['class'] ) . '" width="' . esc_attr( $args['width'] ) . '" height="' . esc_attr( $args['height'] ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M15 22v-4a4.8 4.8 0 0 0-1-3.5c3 0 6-2 6-5.5.08-1.25-.27-2.48-1-3.5.28-1.15.28-2.35 0-3.5 0 0-1 0-3 1.5-2.64-.5-5.36-.5-8 0C6 2 5 2 5 2c-.3 1.15-.3 2.35 0 3.5A5.403 5.403 0 0 0 4 9c0 3.5 3 5.5 6 5.5-.39.49-.68 1.05-.85 1.65-.17.6-.22 1.23-.15 1.85v4"/><path d="M9 18c-4.51 2-5-2-7-2"/></svg>';
			break;

		case 'linkedin':
			$svg = '<svg class="' . esc_attr( $args['class'] ) . '" width="' . esc_attr( $args['width'] ) . '" height="' . esc_attr( $args['height'] ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect width="4" height="12" x="2" y="9"/><circle cx="4" cy="4" r="2"/></svg>';
			break;

		case 'twitter':
		case 'x':
			$svg = '<svg class="' . esc_attr( $args['class'] ) . '" width="' . esc_attr( $args['width'] ) . '" height="' . esc_attr( $args['height'] ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4l11.733 16h4.267l-11.733 -16z"/><path d="M4 20l6.768 -6.768m2.46 -2.46l6.772 -6.772"/></svg>';
			break;

		case 'menu':
			$svg = '<svg class="' . esc_attr( $args['class'] ) . '" width="' . esc_attr( $args['width'] ) . '" height="' . esc_attr( $args['height'] ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg>';
			break;

		case 'close':
			$svg = '<svg class="' . esc_attr( $args['class'] ) . '" width="' . esc_attr( $args['width'] ) . '" height="' . esc_attr( $args['height'] ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>';
			break;

		case 'code':
			$svg = '<svg class="' . esc_attr( $args['class'] ) . '" width="' . esc_attr( $args['width'] ) . '" height="' . esc_attr( $args['height'] ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>';
			break;

		case 'extension':
			$svg = '<svg class="' . esc_attr( $args['class'] ) . '" width="' . esc_attr( $args['width'] ) . '" height="' . esc_attr( $args['height'] ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 11V4a1 1 0 0 0-1-1h-7a1 1 0 0 0-1 1v2a2 2 0 1 1-4 0V4a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h2a2 2 0 1 1 0 4H2a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h7a1 1 0 0 0 1-1v-2a2 2 0 1 1 4 0v2a1 1 0 0 0 1 1h7a1 1 0 0 0 1-1v-7a1 1 0 0 0-1-1h-2a2 2 0 1 1 0-4h2a1 1 0 0 0 1-1z"/></svg>';
			break;

		case 'terminal':
			$svg = '<svg class="' . esc_attr( $args['class'] ) . '" width="' . esc_attr( $args['width'] ) . '" height="' . esc_attr( $args['height'] ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="4 17 10 11 4 5"/><line x1="12" x2="20" y1="19" y2="19"/></svg>';
			break;

		case 'tune':
			$svg = '<svg class="' . esc_attr( $args['class'] ) . '" width="' . esc_attr( $args['width'] ) . '" height="' . esc_attr( $args['height'] ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" x2="20" y1="21" y2="21"/><line x1="4" x2="20" y1="14" y2="14"/><line x1="4" x2="20" y1="7" y2="7"/><circle cx="14" cy="7" r="2"/><circle cx="8" cy="14" r="2"/><circle cx="16" cy="21" r="2"/></svg>';
			break;

		case 'layers':
			$svg = '<svg class="' . esc_attr( $args['class'] ) . '" width="' . esc_attr( $args['width'] ) . '" height="' . esc_attr( $args['height'] ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>';
			break;

		case 'speed':
			$svg = '<svg class="' . esc_attr( $args['class'] ) . '" width="' . esc_attr( $args['width'] ) . '" height="' . esc_attr( $args['height'] ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 14 4-4"/><path d="M3.34 19a10 10 0 1 1 17.32 0"/></svg>';
			break;

		case 'widgets':
			$svg = '<svg class="' . esc_attr( $args['class'] ) . '" width="' . esc_attr( $args['width'] ) . '" height="' . esc_attr( $args['height'] ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="7" x="3" y="3" rx="1"/><rect width="7" height="7" x="14" y="3" rx="1"/><rect width="7" height="7" x="14" y="14" rx="1"/><rect width="7" height="7" x="3" y="14" rx="1"/></svg>';
			break;

		case 'check_circle':
		case 'check-circle':
			$svg = '<svg class="' . esc_attr( $args['class'] ) . '" width="' . esc_attr( $args['width'] ) . '" height="' . esc_attr( $args['height'] ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>';
			break;

		case 'schedule':
		case 'clock':
			$svg = '<svg class="' . esc_attr( $args['class'] ) . '" width="' . esc_attr( $args['width'] ) . '" height="' . esc_attr( $args['height'] ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>';
			break;

		case 'alternate_email':
		case 'at-sign':
			$svg = '<svg class="' . esc_attr( $args['class'] ) . '" width="' . esc_attr( $args['width'] ) . '" height="' . esc_attr( $args['height'] ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4"/><path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-4 8"/></svg>';
			break;

		case 'verified_user':
		case 'verified':
			$svg = '<svg class="' . esc_attr( $args['class'] ) . '" width="' . esc_attr( $args['width'] ) . '" height="' . esc_attr( $args['height'] ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>';
			break;

		case 'share':
			$svg = '<svg class="' . esc_attr( $args['class'] ) . '" width="' . esc_attr( $args['width'] ) . '" height="' . esc_attr( $args['height'] ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" x2="15.42" y1="13.51" y2="17.49"/><line x1="15.41" x2="8.59" y1="6.51" y2="10.49"/></svg>';
			break;

		case 'forum':
		case 'chat':
			$svg = '<svg class="' . esc_attr( $args['class'] ) . '" width="' . esc_attr( $args['width'] ) . '" height="' . esc_attr( $args['height'] ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>';
			break;

		case 'work':
		case 'briefcase':
			$svg = '<svg class="' . esc_attr( $args['class'] ) . '" width="' . esc_attr( $args['width'] ) . '" height="' . esc_attr( $args['height'] ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="7" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>';
			break;

		case 'open_in_new':
		case 'external_link':
		case 'external-link':
			$svg = '<svg class="' . esc_attr( $args['class'] ) . '" width="' . esc_attr( $args['width'] ) . '" height="' . esc_attr( $args['height'] ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h6v6"/><path d="M10 14 21 3"/><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/></svg>';
			break;

		case 'database':
			$svg = '<svg class="' . esc_attr( $args['class'] ) . '" width="' . esc_attr( $args['width'] ) . '" height="' . esc_attr( $args['height'] ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M3 5v14c0 1.66 4.03 3 9 3s9-1.34 9-3V5"/><path d="M3 12c0 1.66 4.03 3 9 3s9-1.34 9-3"/></svg>';
			break;

		case 'server':
			$svg = '<svg class="' . esc_attr( $args['class'] ) . '" width="' . esc_attr( $args['width'] ) . '" height="' . esc_attr( $args['height'] ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="8" x="2" y="2" rx="2" ry="2"/><rect width="20" height="8" x="2" y="14" rx="2" ry="2"/><line x1="6" x2="6.01" y1="6" y2="6"/><line x1="6" x2="6.01" y1="18" y2="18"/></svg>';
			break;

		case 'cpu':
			$svg = '<svg class="' . esc_attr( $args['class'] ) . '" width="' . esc_attr( $args['width'] ) . '" height="' . esc_attr( $args['height'] ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="16" height="16" x="4" y="4" rx="2"/><rect width="6" height="6" x="9" y="9"/><path d="M9 1v3M15 1v3M9 20v3M15 20v3M20 9h3M20 14h3M1 9h3M1 14h3"/></svg>';
			break;

		case 'git':
		case 'git_branch':
			$svg = '<svg class="' . esc_attr( $args['class'] ) . '" width="' . esc_attr( $args['width'] ) . '" height="' . esc_attr( $args['height'] ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="18" cy="18" r="3"/><circle cx="6" cy="6" r="3"/><path d="M6 9v12"/><path d="M18 9a9 9 0 0 1-9 9"/></svg>';
			break;

		case 'wp':
		case 'wp_logo':
			$svg = '<svg class="' . esc_attr( $args['class'] ) . '" width="' . esc_attr( $args['width'] ) . '" height="' . esc_attr( $args['height'] ) . '" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18.2a8.2 8.2 0 0 1-4.7-1.5l3.9-11.4c.3 1 .6 1.9.6 2.6a4.2 4.2 0 0 1-.3 1.5zm-6.8-6a8.2 8.2 0 0 1 .4-2.6l3.3 9.7a8.2 8.2 0 0 1-3.7-7.1zm12.3-4.1a8.1 8.1 0 0 1 .8 3.5 8.2 8.2 0 0 1-4.7 7.4l3.1-9a3.8 3.8 0 0 0 .8-1.9zm-4.3 0-1.8 5.4-2-6.1c.3 0 .7-.1 1.1-.1.9 0 1.9.3 2.7.8z"/></svg>';
			break;

		case 'youtube':
			$svg = '<svg class="' . esc_attr( $args['class'] ) . '" width="' . esc_attr( $args['width'] ) . '" height="' . esc_attr( $args['height'] ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2.5 17a24.12 24.12 0 0 1 0-10 2 2 0 0 1 1.4-1.4 49.56 49.56 0 0 1 16.2 0A2 2 0 0 1 21.5 7a24.12 24.12 0 0 1 0 10 2 2 0 0 1-1.4 1.4 49.55 49.55 0 0 1-16.2 0A2 2 0 0 1 2.5 17"/><polygon points="10 15 15 12 10 9 10 15"/></svg>';
			break;

		case 'phone':
			$svg = '<svg class="' . esc_attr( $args['class'] ) . '" width="' . esc_attr( $args['width'] ) . '" height="' . esc_attr( $args['height'] ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>';
			break;

		case 'star':
			$svg = '<svg class="' . esc_attr( $args['class'] ) . '" width="' . esc_attr( $args['width'] ) . '" height="' . esc_attr( $args['height'] ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>';
			break;

		case 'heart':
			$svg = '<svg class="' . esc_attr( $args['class'] ) . '" width="' . esc_attr( $args['width'] ) . '" height="' . esc_attr( $args['height'] ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>';
			break;

		case 'download':
			$svg = '<svg class="' . esc_attr( $args['class'] ) . '" width="' . esc_attr( $args['width'] ) . '" height="' . esc_attr( $args['height'] ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>';
			break;

		case 'user':
		case 'person':
			$svg = '<svg class="' . esc_attr( $args['class'] ) . '" width="' . esc_attr( $args['width'] ) . '" height="' . esc_attr( $args['height'] ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>';
			break;

		case 'book':
			$svg = '<svg class="' . esc_attr( $args['class'] ) . '" width="' . esc_attr( $args['width'] ) . '" height="' . esc_attr( $args['height'] ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/><path d="M6 6h10M6 10h10"/></svg>';
			break;

		case 'search':
			$svg = '<svg class="' . esc_attr( $args['class'] ) . '" width="' . esc_attr( $args['width'] ) . '" height="' . esc_attr( $args['height'] ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" x2="16.65" y1="21" y2="16.65"/></svg>';
			break;

		case 'help':
		case 'help_outline':
			$svg = '<svg class="' . esc_attr( $args['class'] ) . '" width="' . esc_attr( $args['width'] ) . '" height="' . esc_attr( $args['height'] ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" x2="12.01" y1="17" y2="17"/></svg>';
			break;

		default:
			// Fallback: clean circular dot icon
			$svg = '<svg class="' . esc_attr( $args['class'] ) . '" width="' . esc_attr( $args['width'] ) . '" height="' . esc_attr( $args['height'] ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/></svg>';
			break;
	}

	return $svg;
}

/**
 * Return array of available lightweight icons with categories and preview SVGs.
 *
 * @return array
 */
function pixelpost_get_available_icons() {
	return array(
		// Tech / Development
		array( 'id' => 'code', 'name' => __( 'Code / Script', 'pixelpost' ), 'category' => 'tech', 'svg' => pixelpost_get_icon( 'code' ) ),
		array( 'id' => 'terminal', 'name' => __( 'Terminal / CLI', 'pixelpost' ), 'category' => 'tech', 'svg' => pixelpost_get_icon( 'terminal' ) ),
		array( 'id' => 'bug_report', 'name' => __( 'Bug / Debug', 'pixelpost' ), 'category' => 'tech', 'svg' => pixelpost_get_icon( 'bug_report' ) ),
		array( 'id' => 'database', 'name' => __( 'Database / SQL', 'pixelpost' ), 'category' => 'tech', 'svg' => pixelpost_get_icon( 'database' ) ),
		array( 'id' => 'server', 'name' => __( 'Server / Hosting', 'pixelpost' ), 'category' => 'tech', 'svg' => pixelpost_get_icon( 'server' ) ),
		array( 'id' => 'cpu', 'name' => __( 'CPU / Hardware', 'pixelpost' ), 'category' => 'tech', 'svg' => pixelpost_get_icon( 'cpu' ) ),
		array( 'id' => 'speed', 'name' => __( 'Speed / Performance', 'pixelpost' ), 'category' => 'tech', 'svg' => pixelpost_get_icon( 'speed' ) ),
		array( 'id' => 'layers', 'name' => __( 'Architecture / Layers', 'pixelpost' ), 'category' => 'tech', 'svg' => pixelpost_get_icon( 'layers' ) ),
		array( 'id' => 'extension', 'name' => __( 'Plugin / Extension', 'pixelpost' ), 'category' => 'tech', 'svg' => pixelpost_get_icon( 'extension' ) ),
		array( 'id' => 'widgets', 'name' => __( 'Widgets / Blocks', 'pixelpost' ), 'category' => 'tech', 'svg' => pixelpost_get_icon( 'widgets' ) ),
		array( 'id' => 'tune', 'name' => __( 'Settings / Config', 'pixelpost' ), 'category' => 'tech', 'svg' => pixelpost_get_icon( 'tune' ) ),
		array( 'id' => 'bolt', 'name' => __( 'Lightning / Fast', 'pixelpost' ), 'category' => 'tech', 'svg' => pixelpost_get_icon( 'bolt' ) ),
		array( 'id' => 'shield', 'name' => __( 'Security / Protection', 'pixelpost' ), 'category' => 'tech', 'svg' => pixelpost_get_icon( 'shield' ) ),
		array( 'id' => 'verified', 'name' => __( 'Verified / Quality', 'pixelpost' ), 'category' => 'tech', 'svg' => pixelpost_get_icon( 'verified' ) ),
		array( 'id' => 'git', 'name' => __( 'Git / Version Control', 'pixelpost' ), 'category' => 'tech', 'svg' => pixelpost_get_icon( 'git' ) ),
		array( 'id' => 'wp_logo', 'name' => __( 'WordPress', 'pixelpost' ), 'category' => 'tech', 'svg' => pixelpost_get_icon( 'wp_logo' ) ),

		// Social & Web
		array( 'id' => 'github', 'name' => __( 'GitHub', 'pixelpost' ), 'category' => 'social', 'svg' => pixelpost_get_icon( 'github' ) ),
		array( 'id' => 'linkedin', 'name' => __( 'LinkedIn', 'pixelpost' ), 'category' => 'social', 'svg' => pixelpost_get_icon( 'linkedin' ) ),
		array( 'id' => 'twitter', 'name' => __( 'X / Twitter', 'pixelpost' ), 'category' => 'social', 'svg' => pixelpost_get_icon( 'twitter' ) ),
		array( 'id' => 'youtube', 'name' => __( 'YouTube', 'pixelpost' ), 'category' => 'social', 'svg' => pixelpost_get_icon( 'youtube' ) ),
		array( 'id' => 'public', 'name' => __( 'Website / Globe', 'pixelpost' ), 'category' => 'social', 'svg' => pixelpost_get_icon( 'public' ) ),
		array( 'id' => 'forum', 'name' => __( 'Community / Forum', 'pixelpost' ), 'category' => 'social', 'svg' => pixelpost_get_icon( 'forum' ) ),
		array( 'id' => 'share', 'name' => __( 'Share', 'pixelpost' ), 'category' => 'social', 'svg' => pixelpost_get_icon( 'share' ) ),
		array( 'id' => 'alternate_email', 'name' => __( 'At Sign / Handle', 'pixelpost' ), 'category' => 'social', 'svg' => pixelpost_get_icon( 'alternate_email' ) ),

		// Contact & Location
		array( 'id' => 'mail', 'name' => __( 'Email / Message', 'pixelpost' ), 'category' => 'contact', 'svg' => pixelpost_get_icon( 'mail' ) ),
		array( 'id' => 'phone', 'name' => __( 'Phone / Call', 'pixelpost' ), 'category' => 'contact', 'svg' => pixelpost_get_icon( 'phone' ) ),
		array( 'id' => 'location_on', 'name' => __( 'Location / Map Pin', 'pixelpost' ), 'category' => 'contact', 'svg' => pixelpost_get_icon( 'location_on' ) ),
		array( 'id' => 'calendar_today', 'name' => __( 'Calendar / Schedule', 'pixelpost' ), 'category' => 'contact', 'svg' => pixelpost_get_icon( 'calendar_today' ) ),
		array( 'id' => 'schedule', 'name' => __( 'Clock / Hours', 'pixelpost' ), 'category' => 'contact', 'svg' => pixelpost_get_icon( 'schedule' ) ),
		array( 'id' => 'send', 'name' => __( 'Send / Direct', 'pixelpost' ), 'category' => 'contact', 'svg' => pixelpost_get_icon( 'send' ) ),
		array( 'id' => 'help', 'name' => __( 'Support / FAQ', 'pixelpost' ), 'category' => 'contact', 'svg' => pixelpost_get_icon( 'help' ) ),

		// General & UI
		array( 'id' => 'check_circle', 'name' => __( 'Checkmark / Success', 'pixelpost' ), 'category' => 'general', 'svg' => pixelpost_get_icon( 'check_circle' ) ),
		array( 'id' => 'work', 'name' => __( 'Briefcase / Work', 'pixelpost' ), 'category' => 'general', 'svg' => pixelpost_get_icon( 'work' ) ),
		array( 'id' => 'design_services', 'name' => __( 'Design / Palette', 'pixelpost' ), 'category' => 'general', 'svg' => pixelpost_get_icon( 'design_services' ) ),
		array( 'id' => 'star', 'name' => __( 'Star / Featured', 'pixelpost' ), 'category' => 'general', 'svg' => pixelpost_get_icon( 'star' ) ),
		array( 'id' => 'heart', 'name' => __( 'Heart / Favorite', 'pixelpost' ), 'category' => 'general', 'svg' => pixelpost_get_icon( 'heart' ) ),
		array( 'id' => 'user', 'name' => __( 'User / Profile', 'pixelpost' ), 'category' => 'general', 'svg' => pixelpost_get_icon( 'user' ) ),
		array( 'id' => 'book', 'name' => __( 'Book / Notes', 'pixelpost' ), 'category' => 'general', 'svg' => pixelpost_get_icon( 'book' ) ),
		array( 'id' => 'download', 'name' => __( 'Download / File', 'pixelpost' ), 'category' => 'general', 'svg' => pixelpost_get_icon( 'download' ) ),
		array( 'id' => 'open_in_new', 'name' => __( 'External Link', 'pixelpost' ), 'category' => 'general', 'svg' => pixelpost_get_icon( 'open_in_new' ) ),
		array( 'id' => 'search', 'name' => __( 'Search / Explore', 'pixelpost' ), 'category' => 'general', 'svg' => pixelpost_get_icon( 'search' ) ),
	);
}

/**
 * Render an optimized responsive image with proper srcset, sizes, and dimensions.
 *
 * Automatically resolves WordPress attachment ID to generate responsive srcset,
 * prevent CLS with explicit dimensions, and apply modern loading/fetchpriority hints.
 *
 * @param string $img_url Image URL.
 * @param array  $args    Image rendering arguments.
 * @return string Image HTML markup.
 */
function pixelpost_render_optimized_image( $img_url, $args = array() ) {
	$defaults = array(
		'size'          => 'large',
		'class'         => '',
		'alt'           => '',
		'loading'       => 'lazy',
		'fetchpriority' => null,
		'decoding'      => 'async',
		'width'         => 600,
		'height'        => 600,
	);
	$args = wp_parse_args( $args, $defaults );

	$attachment_id = 0;
	if ( ! empty( $img_url ) ) {
		$attachment_id = attachment_url_to_postid( $img_url );
	}

	if ( $attachment_id ) {
		$attr = array(
			'class'    => $args['class'],
			'alt'      => $args['alt'],
			'decoding' => $args['decoding'],
		);
		if ( ! empty( $args['loading'] ) ) {
			$attr['loading'] = $args['loading'];
		}
		if ( ! empty( $args['fetchpriority'] ) ) {
			$attr['fetchpriority'] = $args['fetchpriority'];
		}
		$html = wp_get_attachment_image( $attachment_id, $args['size'], false, $attr );
		if ( ! empty( $html ) ) {
			return $html;
		}
	}

	$extra_attrs = '';
	if ( ! empty( $args['loading'] ) ) {
		$extra_attrs .= ' loading="' . esc_attr( $args['loading'] ) . '"';
	}
	if ( ! empty( $args['fetchpriority'] ) ) {
		$extra_attrs .= ' fetchpriority="' . esc_attr( $args['fetchpriority'] ) . '"';
	}
	if ( ! empty( $args['decoding'] ) ) {
		$extra_attrs .= ' decoding="' . esc_attr( $args['decoding'] ) . '"';
	}

	return sprintf(
		'<img src="%s" alt="%s" class="%s" width="%d" height="%d"%s>',
		esc_url( $img_url ),
		esc_attr( $args['alt'] ),
		esc_attr( $args['class'] ),
		absint( $args['width'] ),
		absint( $args['height'] ),
		$extra_attrs
	);
}

/**
 * Output post publication date
 */
function pixelpost_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	}

	$time_string = sprintf(
		$time_string,
		esc_attr( get_the_date( DATE_W3C ) ),
		esc_html( get_the_date() )
	);

	echo '<span class="posted-on">' . $time_string . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Output post author
 */
function pixelpost_posted_by() {
	$author_id = get_the_author_meta( 'ID' );
	$avatar    = get_avatar( $author_id, 24, '', get_the_author(), array( 'class' => 'w-5 h-5 rounded-full object-cover inline-block mr-1 align-middle' ) );

	$byline = sprintf(
		/* translators: 1: author avatar, 2: post author name. */
		esc_html_x( '%1$s by %2$s', 'post author', 'pixelpost' ),
		$avatar,
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( $author_id ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Output post thumbnail
 */
function pixelpost_post_thumbnail( $size = 'post-thumbnail' ) {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	if ( is_singular() ) :
		?>
		<div class="fp-featured-media">
			<?php the_post_thumbnail( $size ); ?>
		</div>
	<?php else : ?>
		<a class="fp-post-thumbnail-link" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php
			the_post_thumbnail(
				$size,
				array(
					'alt' => the_title_attribute(
						array(
							'echo' => false,
						)
					),
				)
			);
			?>
		</a>
		<?php
	endif;
}

/**
 * Output pagination numbers
 */
function pixelpost_the_posts_navigation() {
	the_posts_pagination(
		array(
			'mid_size'  => 2,
			'prev_text' => sprintf(
				'%s <span class="nav-prev-text">%s</span>',
				pixelpost_get_icon( 'arrow-right', array( 'width' => 14, 'height' => 14, 'class' => 'fp-icon fp-icon-prev', 'style' => 'transform: rotate(180deg);' ) ),
				__( 'Previous', 'pixelpost' )
			),
			'next_text' => sprintf(
				'<span class="nav-next-text">%s</span> %s',
				__( 'Next', 'pixelpost' ),
				pixelpost_get_icon( 'arrow-right', array( 'width' => 14, 'height' => 14 ) )
			),
			'class'     => 'fp-pagination',
		)
	);
}

/**
 * Check if an active SEO plugin is handling meta tags.
 * Avoids duplicate meta descriptions or Open Graph tags.
 *
 * @return bool
 */
function pixelpost_is_seo_plugin_active() {
	return defined( 'WPSEO_VERSION' )              // Yoast SEO
		|| class_exists( 'RankMath' )              // Rank Math
		|| defined( 'AIOSEO_VERSION' )             // All in One SEO
		|| function_exists( 'seopress_init' )      // SEOPress
		|| class_exists( 'The_SEO_Framework' );    // The SEO Framework
}

/**
 * Render SEO meta description and Open Graph tags in <head>.
 * Controlled via Customizer: Global Settings -> SEO & Social Meta Tags.
 */
function pixelpost_render_seo_meta() {
	// Yield if third-party SEO plugin is managing tags
	if ( pixelpost_is_seo_plugin_active() ) {
		return;
	}

	// Check if basic SEO is enabled in Customizer
	$seo_enabled = pixelpost_get_setting( 'pixelpost_seo_enable' );
	if ( false === $seo_enabled || '0' === $seo_enabled || '' === $seo_enabled ) {
		return;
	}

	$description = '';
	$title       = wp_get_document_title();
	$url         = '';
	$type        = 'website';
	$image       = '';

	if ( is_front_page() || is_home() ) {
		$custom_desc = pixelpost_get_setting( 'pixelpost_seo_meta_desc' );
		if ( ! empty( $custom_desc ) ) {
			$description = $custom_desc;
		} else {
			$tagline     = get_bloginfo( 'description', 'display' );
			$description = ! empty( $tagline ) ? $tagline : pixelpost_get_theme_default( 'pixelpost_seo_meta_desc' );
		}
		$url = home_url( '/' );
	} elseif ( is_singular() ) {
		global $post;
		$type = is_single() ? 'article' : 'website';
		$url  = get_permalink();

		if ( ! empty( $post->post_excerpt ) ) {
			$description = wp_strip_all_tags( $post->post_excerpt );
		} elseif ( ! empty( $post->post_content ) ) {
			$clean_content = wp_strip_all_tags( strip_shortcodes( $post->post_content ) );
			$description   = wp_trim_words( $clean_content, 26, '...' );
		}

		if ( empty( $description ) ) {
			$custom_desc = pixelpost_get_setting( 'pixelpost_seo_meta_desc' );
			$description = ! empty( $custom_desc ) ? $custom_desc : get_bloginfo( 'description', 'display' );
		}

		if ( has_post_thumbnail( $post->ID ) ) {
			$thumb_url = get_the_post_thumbnail_url( $post->ID, 'large' );
			if ( $thumb_url ) {
				$image = $thumb_url;
			}
		}
	} elseif ( is_category() || is_tag() || is_tax() ) {
		$term_desc = term_description();
		if ( ! empty( $term_desc ) ) {
			$description = wp_strip_all_tags( $term_desc );
		} else {
			/* translators: %s: term title */
			$description = sprintf( __( 'Articles and resources filed under %s.', 'pixelpost' ), single_term_title( '', false ) );
		}
		$url = get_term_link( get_queried_object() );
	} elseif ( is_author() ) {
		$author_desc = get_the_author_meta( 'description' );
		if ( ! empty( $author_desc ) ) {
			$description = wp_strip_all_tags( $author_desc );
		} else {
			/* translators: %s: author display name */
			$description = sprintf( __( 'Articles and technical guides written by %s.', 'pixelpost' ), get_the_author() );
		}
		$url = get_author_posts_url( get_the_author_meta( 'ID' ) );
	} elseif ( is_search() ) {
		/* translators: 1: search query, 2: site name */
		$description = sprintf( __( 'Search results for "%1$s" on %2$s.', 'pixelpost' ), get_search_query(), get_bloginfo( 'name' ) );
		$url         = get_search_link();
	}

	// Final fallback description
	if ( empty( $description ) ) {
		$tagline     = get_bloginfo( 'description', 'display' );
		$description = ! empty( $tagline ) ? $tagline : pixelpost_get_theme_default( 'pixelpost_seo_meta_desc' );
	}

	// Normalize whitespace & length
	$description = preg_replace( '/\s+/', ' ', trim( $description ) );
	if ( mb_strlen( $description ) > 165 ) {
		$description = mb_substr( $description, 0, 160 ) . '...';
	}

	// Fallback image if empty
	if ( empty( $image ) ) {
		$custom_image = pixelpost_get_setting( 'pixelpost_seo_og_image' );
		if ( ! empty( $custom_image ) ) {
			$image = $custom_image;
		}
	}

	// 1. Meta Description
	if ( ! empty( $description ) ) {
		echo '<meta name="description" content="' . esc_attr( $description ) . '">' . "\n";
	}

	// 2. Open Graph & Twitter Cards if enabled
	$og_enabled = pixelpost_get_setting( 'pixelpost_seo_og_enable' );
	if ( false !== $og_enabled && '0' !== $og_enabled && '' !== $og_enabled ) {
		echo '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '">' . "\n";
		echo '<meta property="og:type" content="' . esc_attr( $type ) . '">' . "\n";
		echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
		if ( ! empty( $description ) ) {
			echo '<meta property="og:description" content="' . esc_attr( $description ) . '">' . "\n";
		}
		if ( ! empty( $url ) && ! is_wp_error( $url ) ) {
			echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
		}
		if ( ! empty( $image ) ) {
			echo '<meta property="og:image" content="' . esc_url( $image ) . '">' . "\n";
		}

		echo '<meta name="twitter:card" content="' . esc_attr( ! empty( $image ) ? 'summary_large_image' : 'summary' ) . '">' . "\n";
		echo '<meta name="twitter:title" content="' . esc_attr( $title ) . '">' . "\n";
		if ( ! empty( $description ) ) {
			echo '<meta name="twitter:description" content="' . esc_attr( $description ) . '">' . "\n";
		}
		if ( ! empty( $image ) ) {
			echo '<meta name="twitter:image" content="' . esc_url( $image ) . '">' . "\n";
		}
	}
}
add_action( 'wp_head', 'pixelpost_render_seo_meta', 1 );
