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

<header id="masthead" class="fixed top-0 left-0 w-full z-50 bg-[#FAF9F6]/95 dark:bg-[#161514]/95 backdrop-blur-md border-b border-[#E9E6E0] dark:border-[#2E2D29] fp-site-header<?php echo esc_attr( $pixelpost_sticky_class ); ?>" data-pixelpost-customize="header" data-pixelpost-label="<?php esc_attr_e( 'Header Settings', 'pixelpost' ); ?>">
	<div class="h-20 max-w-[1140px] mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between gap-4 fp-container fp-header-inner">
		<?php get_template_part( 'template-parts/header/site-branding' ); ?>
		<div class="flex items-center gap-6 lg:gap-8">
			<?php get_template_part( 'template-parts/header/navigation' ); ?>
			<div class="flex items-center gap-3 fp-header-actions">
				<button id="theme-toggle" class="w-9 h-9 rounded-full flex items-center justify-center text-[#77736D] hover:text-[#242321] dark:text-[#A39E96] dark:hover:text-[#EDEAE5] transition-colors fp-theme-toggle" aria-label="<?php esc_attr_e( 'Toggle dark / light theme', 'pixelpost' ); ?>" type="button">
					<span class="dark-icon-moon"><?php echo pixelpost_get_icon( 'moon', array( 'width' => 18, 'height' => 18 ) ); ?></span>
					<span class="dark-icon-sun hidden"><?php echo pixelpost_get_icon( 'sun', array( 'width' => 18, 'height' => 18 ) ); ?></span>
				</button>
				<a href="<?php echo esc_url( home_url( '/#contact' ) ); ?>" class="hidden sm:inline-flex items-center gap-1.5 px-4 py-2 rounded bg-primary hover:bg-primary-container text-on-primary font-medium text-sm transition-all fp-header-talk-btn">
					<span><?php esc_html_e( "Let's Talk", "pixelpost" ); ?></span>
					<?php echo pixelpost_get_icon( 'arrow_forward', array( 'width' => 14, 'height' => 14 ) ); ?>
				</a>
				<button class="pixelpost-menu-toggle fp-menu-toggle lg:hidden p-1.5 text-on-surface-variant hover:text-on-surface" aria-controls="site-navigation" aria-expanded="false" aria-label="<?php esc_attr_e( 'Open navigation menu', 'pixelpost' ); ?>">
					<?php echo pixelpost_get_icon( 'menu', array( 'width' => 22, 'height' => 22 ) ); ?>
				</button>
			</div>
		</div>
	</div>
</header>

<main id="primary-content" class="w-full pt-20 bg-surface fp-site-main" tabindex="-1">
	<?php if ( has_header_image() ) : ?>
		<div class="fp-custom-header w-full overflow-hidden">
			<?php the_header_image_tag(); ?>
		</div>
	<?php endif; ?>
	<div class="flex flex-col w-full">
