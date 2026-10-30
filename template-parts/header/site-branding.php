<?php
/**
 * Site Branding Header Part
 * Matches Editorial Minimalism: Burnt orange serif initial + Parag Das
 *
 * @package Pixelpost
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$pixelpost_site_name = get_bloginfo( 'name' );
if ( empty( $pixelpost_site_name ) ) {
	$pixelpost_site_name = 'Parag Das';
}
$pixelpost_monogram = mb_substr( $pixelpost_site_name, 0, 1 );
?>
<div class="fp-branding" data-pixelpost-customize="site-branding" data-pixelpost-label="<?php esc_attr_e( 'Site Identity', 'pixelpost' ); ?>">
	<?php if ( has_custom_logo() ) : ?>
		<?php the_custom_logo(); ?>
	<?php else : ?>
		<a class="flex items-center gap-2 group fp-brand-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<span class="font-serif font-bold text-2xl text-primary leading-none group-hover:scale-105 transition-transform fp-brand-initial"><?php echo esc_html( $pixelpost_monogram ); ?></span>
			<span class="font-serif text-xl font-bold text-on-surface tracking-tight leading-none fp-site-title-text"><?php echo esc_html( $pixelpost_site_name ); ?></span>
		</a>
	<?php endif; ?>
</div>
