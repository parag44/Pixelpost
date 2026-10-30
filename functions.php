<?php
/**
 * Pixelpost Theme Functions and Definitions
 *
 * @package Pixelpost
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PIXELPOST_VERSION', '2.0.3' );
define( 'PIXELPOST_DIR', get_template_directory() );
define( 'PIXELPOST_URI', get_template_directory_uri() );

/**
 * Require modular include files
 */
require_once PIXELPOST_DIR . '/inc/demo-data.php';
require_once PIXELPOST_DIR . '/inc/template-tags.php';
require_once PIXELPOST_DIR . '/inc/theme-setup.php';
require_once PIXELPOST_DIR . '/inc/customizer.php';
require_once PIXELPOST_DIR . '/inc/block-patterns.php';
