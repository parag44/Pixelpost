<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Pixelpost
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="fp-container fp-container-narrow" style="padding-top: var(--fp-section-spacing); padding-bottom: var(--fp-section-spacing); text-align: center;">
	<div class="fp-eyebrow"><?php esc_html_e( 'ERROR 404', 'pixelpost' ); ?></div>
	<h1 class="fp-page-title"><?php esc_html_e( 'Page Not Found', 'pixelpost' ); ?></h1>
	<p class="fp-section-subtitle" style="margin-left: auto; margin-right: auto; margin-bottom: 2rem;">
		<?php esc_html_e( 'The page you were looking for could not be found. It might have been moved, renamed, or is temporarily unavailable.', 'pixelpost' ); ?>
	</p>

	<div style="max-width: 440px; margin: 0 auto 2rem auto;">
		<?php get_search_form(); ?>
	</div>

	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="fp-button fp-button-primary">
		<span><?php esc_html_e( 'Return to Homepage', 'pixelpost' ); ?></span>
	</a>
</div>

<?php
get_footer();
