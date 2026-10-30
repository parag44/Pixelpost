<?php
/**
 * Site Branding Header Part
 * Matches Editorial Minimalism: Clean text logo without monogram
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
?>
<div class="fp-branding" data-pixelpost-customize="site-branding" data-pixelpost-label="<?php esc_attr_e( 'Site Identity', 'pixelpost' ); ?>">
	<?php if ( has_custom_logo() ) : ?>
		<?php the_custom_logo(); ?>
	<?php else : ?>
		<a class="flex items-center group fp-brand-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<span class="font-serif text-xl font-bold text-on-surface tracking-tight leading-none fp-site-title-text"><?php echo esc_html( $pixelpost_site_name ); ?></span>
		</a>
	<?php endif; ?>
</div>
