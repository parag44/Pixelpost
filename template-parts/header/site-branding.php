<?php
/**
 * Site Branding Header Part
 * Matches Google Stitch PRD: Parag Das wordmark with Monogram badge
 *
 * @package Pixelpost
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$pixelpost_site_name    = get_bloginfo( 'name' );
$pixelpost_monogram     = ! empty( $pixelpost_site_name ) ? mb_substr( $pixelpost_site_name, 0, 1 ) : 'P';
$pixelpost_show_tagline = pixelpost_get_setting( 'pixelpost_header_tagline_show' );
?>
<div class="fp-branding" data-pixelpost-customize="site-branding" data-pixelpost-label="<?php esc_attr_e( 'Site Identity', 'pixelpost' ); ?>">
	<?php if ( has_custom_logo() ) : ?>
		<?php the_custom_logo(); ?>
	<?php else : ?>
		<a class="flex items-center gap-space-sm group fp-brand-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<div class="w-10 h-10 rounded-lg bg-surface-container-high flex items-center justify-center text-primary font-headline-sm text-headline-sm transition-transform group-hover:scale-95 fp-monogram-badge">
				<?php echo esc_html( $pixelpost_monogram ); ?>
			</div>
			<div class="flex flex-col">
				<span class="font-headline-sm text-headline-sm text-on-surface leading-none tracking-tight fp-site-title-text"><?php echo esc_html( $pixelpost_site_name ); ?></span>
				<?php if ( $pixelpost_show_tagline ) : ?>
					<?php
					$pixelpost_description = get_bloginfo( 'description', 'display' );
					if ( $pixelpost_description ) :
						?>
						<span class="font-label-caps text-label-caps text-on-surface-variant mt-1 fp-site-tagline"><?php echo esc_html( $pixelpost_description ); ?></span>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		</a>
	<?php endif; ?>
</div>
