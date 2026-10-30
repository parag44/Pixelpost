<?php
/**
 * The header for our theme
 *
 * @package Pixelpost
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$pixelpost_sticky_class = pixelpost_get_setting( 'pixelpost_header_sticky' ) ? ' fp-sticky' : '';
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class( 'bg-surface font-body-md text-on-surface antialiased' ); ?>>
<?php wp_body_open(); ?>

<a class="screen-reader-text" href="#primary-content"><?php esc_html_e( 'Skip to content', 'pixelpost' ); ?></a>

<header id="masthead" class="fixed top-0 left-0 w-full z-50 bg-surface/85 backdrop-blur-xl shadow-[0_1px_8px_rgba(0,0,0,0.04)] fp-site-header<?php echo esc_attr( $pixelpost_sticky_class ); ?>" data-pixelpost-customize="header" data-pixelpost-label="<?php esc_attr_e( 'Header Settings', 'pixelpost' ); ?>">
	<div class="h-20 max-w-[1200px] mx-auto px-margin-mobile lg:px-margin flex items-center justify-between gap-gutter fp-container fp-header-inner">
		<?php get_template_part( 'template-parts/header/site-branding' ); ?>
		<?php get_template_part( 'template-parts/header/navigation' ); ?>
	</div>
</header>

<main id="primary-content" class="w-full pt-20 bg-surface fp-site-main" tabindex="-1">
	<?php if ( has_header_image() ) : ?>
		<div class="fp-custom-header w-full overflow-hidden">
			<?php the_header_image_tag(); ?>
		</div>
	<?php endif; ?>
	<div class="flex flex-col w-full">
