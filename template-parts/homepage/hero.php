<?php
/**
 * Hero Section Template Part
 * Matches Google Stitch PRD: Editorial presentation + Diagnostic Monitor Card
 *
 * @package Pixelpost
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$pixelpost_eyebrow   = pixelpost_get_setting( 'pixelpost_hero_eyebrow' );
$pixelpost_headline  = pixelpost_get_setting( 'pixelpost_hero_headline' );
$pixelpost_accent    = pixelpost_get_setting( 'pixelpost_hero_accent' );
$pixelpost_role      = pixelpost_get_setting( 'pixelpost_hero_role' );
$pixelpost_desc      = pixelpost_get_setting( 'pixelpost_hero_description' );
$pixelpost_btn1_text = pixelpost_get_setting( 'pixelpost_hero_btn_primary_text' );
$pixelpost_btn1_url  = pixelpost_get_setting( 'pixelpost_hero_btn_primary_url' );
$pixelpost_btn2_text = pixelpost_get_setting( 'pixelpost_hero_btn_secondary_text' );
$pixelpost_btn2_url  = pixelpost_get_setting( 'pixelpost_hero_btn_secondary_url' );
$pixelpost_hero_img  = pixelpost_get_setting( 'pixelpost_hero_image' );
if ( empty( $pixelpost_hero_img ) ) {
	$pixelpost_hero_img = get_template_directory_uri() . '/assets/images/developer-hero.jpg';
}
?>
<section id="hero" class="w-full max-w-[1200px] mx-auto px-margin-mobile lg:px-margin pt-space-sm lg:pt-space-md pb-space-lg fp-hero-section" aria-label="<?php esc_attr_e( 'Introduction', 'pixelpost' ); ?>" data-pixelpost-customize="hero" data-pixelpost-label="<?php esc_attr_e( 'Hero Section', 'pixelpost' ); ?>">
	<div class="grid grid-cols-1 lg:grid-cols-12 gap-space-lg lg:gap-gutter items-center">
		<!-- Left Column: Editorial Presentation -->
		<div class="lg:col-span-7 flex flex-col items-start fp-hero-left">
			<?php if ( ! empty( $pixelpost_eyebrow ) ) : ?>
				<span class="font-label-caps text-label-caps text-on-surface-variant uppercase tracking-widest mb-space-xs fp-hero-eyebrow" data-pixelpost-customize="hero-eyebrow" data-pixelpost-label="<?php esc_attr_e( 'Greeting Eyebrow', 'pixelpost' ); ?>">
					<?php echo esc_html( $pixelpost_eyebrow ); ?>
				</span>
			<?php endif; ?>

			<h1 class="font-headline-display text-headline-display text-on-surface tracking-tight mb-space-sm fp-hero-headline">
				<span class="fp-hero-headline-main" data-pixelpost-customize="hero-headline" data-pixelpost-label="<?php esc_attr_e( 'Headline Prefix', 'pixelpost' ); ?>"><?php echo esc_html( $pixelpost_headline ); ?></span>
				<?php if ( ! empty( $pixelpost_accent ) ) : ?>
					<span class="text-primary italic font-headline-display fp-hero-accent" data-pixelpost-customize="hero-name" data-pixelpost-label="<?php esc_attr_e( 'Headline Accent', 'pixelpost' ); ?>"><?php echo esc_html( $pixelpost_accent ); ?></span>
				<?php endif; ?>
			</h1>

			<?php if ( ! empty( $pixelpost_role ) ) : ?>
				<h2 class="font-title-md text-title-md text-on-surface-variant font-medium mb-space-md fp-hero-role" data-pixelpost-customize="hero-role" data-pixelpost-label="<?php esc_attr_e( 'Professional Role', 'pixelpost' ); ?>">
					<?php echo esc_html( $pixelpost_role ); ?>
				</h2>
			<?php endif; ?>

			<?php if ( ! empty( $pixelpost_desc ) ) : ?>
				<p class="font-body-lg text-body-lg text-on-surface-variant max-w-xl mb-space-lg leading-relaxed fp-hero-description" data-pixelpost-customize="hero-description" data-pixelpost-label="<?php esc_attr_e( 'Introduction / Bio', 'pixelpost' ); ?>">
					<?php echo esc_html( $pixelpost_desc ); ?>
				</p>
			<?php endif; ?>

			<div class="flex flex-wrap items-center gap-space-sm w-full sm:w-auto fp-hero-actions">
				<?php if ( ! empty( $pixelpost_btn1_text ) && ! empty( $pixelpost_btn1_url ) ) : ?>
					<a class="inline-flex items-center justify-center gap-2 px-space-md py-space-sm rounded-lg bg-primary hover:bg-primary-container text-on-primary font-label-md text-label-md shadow-md transition-all fp-button-primary" href="<?php echo esc_url( $pixelpost_btn1_url ); ?>" data-pixelpost-customize="hero-primary-button" data-pixelpost-label="<?php esc_attr_e( 'Primary Button', 'pixelpost' ); ?>">
						<span><?php echo esc_html( $pixelpost_btn1_text ); ?></span>
						<?php echo pixelpost_get_icon( 'arrow_forward', array( 'width' => 18, 'height' => 18 ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</a>
				<?php endif; ?>

				<?php if ( ! empty( $pixelpost_btn2_text ) && ! empty( $pixelpost_btn2_url ) ) : ?>
					<a class="inline-flex items-center justify-center px-space-md py-space-sm rounded-lg bg-surface-container-high hover:bg-surface-variant text-on-surface font-label-md text-label-md transition-all fp-button-secondary" href="<?php echo esc_url( $pixelpost_btn2_url ); ?>" data-pixelpost-customize="hero-secondary-button" data-pixelpost-label="<?php esc_attr_e( 'Secondary Button', 'pixelpost' ); ?>">
						<?php echo esc_html( $pixelpost_btn2_text ); ?>
					</a>
				<?php endif; ?>
			</div>
		</div>

		<!-- Right Column: Profile Image Card (1:1 Ratio) -->
		<div class="lg:col-span-5 w-full fp-hero-right">
			<div class="relative bg-surface-container-lowest rounded-2xl p-3 border border-outline-variant/60 shadow-xl overflow-hidden group fp-hero-card" data-pixelpost-customize="hero-image" data-pixelpost-label="<?php esc_attr_e( 'Hero Image', 'pixelpost' ); ?>">
				<div class="relative overflow-hidden rounded-xl aspect-square w-full bg-surface-container fp-hero-img-wrap">
					<?php
					echo pixelpost_render_optimized_image(
						$pixelpost_hero_img,
						array(
							'class'         => 'w-full h-full object-cover object-center transform group-hover:scale-105 transition-transform duration-500 fp-hero-headshot',
							'alt'           => ( $pixelpost_accent ? $pixelpost_accent : $pixelpost_headline ) . ' — ' . $pixelpost_role,
							'loading'       => 'eager',
							'fetchpriority' => 'high',
							'width'         => 600,
							'height'        => 600,
						)
					); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					?>
				</div>
			</div>
		</div>
	</div>
</section>
