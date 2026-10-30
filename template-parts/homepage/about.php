<?php
/**
 * About Section Template Part
 * Matches Google Stitch PRD: Split Asymmetric (Portrait + Narrative + 4 Bullets)
 *
 * @package Pixelpost
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$pixelpost_eyebrow = pixelpost_get_setting( 'pixelpost_about_eyebrow' );
$pixelpost_heading = pixelpost_get_setting( 'pixelpost_about_heading' );
$pixelpost_content = pixelpost_get_setting( 'pixelpost_about_text' );
$pixelpost_image   = pixelpost_get_setting( 'pixelpost_about_image' );

if ( empty( $pixelpost_image ) ) {
	$pixelpost_image = get_template_directory_uri() . '/assets/images/developer-about.jpg';
}

$pixelpost_author_name = pixelpost_get_setting( 'pixelpost_hero_accent' );
if ( empty( $pixelpost_author_name ) ) {
	$pixelpost_author_name = get_bloginfo( 'name' );
}

$pixelpost_author_role = pixelpost_get_setting( 'pixelpost_hero_role' );
if ( empty( $pixelpost_author_role ) ) {
	$pixelpost_author_role = __( 'WordPress Technical Support Engineer', 'pixelpost' );
}

$pixelpost_about_bullets = pixelpost_get_about_bullets();

if ( empty( $pixelpost_heading ) && empty( $pixelpost_content ) ) {
	return;
}
?>
<section id="about" class="w-full max-w-[1200px] mx-auto px-margin-mobile lg:px-margin pt-space-xl pb-space-lg fp-about-section" aria-label="<?php esc_attr_e( 'About Me', 'pixelpost' ); ?>" data-pixelpost-customize="about" data-pixelpost-label="<?php esc_attr_e( 'About Me Section', 'pixelpost' ); ?>">
	<div class="bg-surface-container-lowest rounded-xl p-space-md lg:p-space-xl shadow-sm fp-about-card">
		<div class="grid grid-cols-1 lg:grid-cols-12 gap-space-lg items-center">
			<!-- Left: Image & Persona Visual -->
			<div class="lg:col-span-5 flex flex-col items-center fp-about-image-col">
				<div class="relative w-full max-w-sm rounded-xl overflow-hidden shadow-md fp-about-img-box">
					<?php
					echo pixelpost_render_optimized_image(
						$pixelpost_image,
						array(
							'class'    => 'w-full h-80 lg:h-96 object-cover fp-about-img',
							'alt'      => $pixelpost_author_name,
							'loading'  => 'lazy',
							'decoding' => 'async',
							'width'    => 600,
							'height'   => 600,
						)
					); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					?>
					<div class="absolute inset-0 bg-gradient-to-t from-inverse-surface/80 via-transparent to-transparent flex items-end p-space-md fp-about-gradient-tag">
						<div class="text-inverse-on-surface">
							<span class="font-label-caps text-label-caps uppercase text-primary-fixed block"><?php echo esc_html( $pixelpost_author_name ); ?></span>
							<span class="font-body-sm text-body-sm text-inverse-on-surface/90"><?php echo esc_html( $pixelpost_author_role ); ?></span>
						</div>
					</div>
				</div>
			</div>

			<!-- Right: Narrative & Mission -->
			<div class="lg:col-span-7 flex flex-col fp-about-content-col">
				<?php if ( ! empty( $pixelpost_eyebrow ) ) : ?>
					<span class="font-label-caps text-label-caps uppercase text-primary tracking-wider mb-space-xs"><?php echo esc_html( $pixelpost_eyebrow ); ?></span>
				<?php endif; ?>

				<?php if ( ! empty( $pixelpost_heading ) ) : ?>
					<h2 class="font-headline-lg text-headline-lg text-on-surface mb-space-md fp-about-heading" data-pixelpost-customize="about-heading" data-pixelpost-label="<?php esc_attr_e( 'About Heading', 'pixelpost' ); ?>">
						<?php echo esc_html( $pixelpost_heading ); ?>
					</h2>
				<?php endif; ?>

				<?php if ( ! empty( $pixelpost_content ) ) : ?>
					<div class="space-y-space-sm font-body-md text-body-md text-on-surface-variant leading-relaxed fp-about-content" data-pixelpost-customize="about-text" data-pixelpost-label="<?php esc_attr_e( 'About Story', 'pixelpost' ); ?>">
						<?php echo wp_kses_post( wpautop( $pixelpost_content ) ); ?>
					</div>
				<?php endif; ?>

				<!-- Feature Bullets -->
				<?php if ( ! empty( $pixelpost_about_bullets ) ) : ?>
					<div class="grid grid-cols-1 sm:grid-cols-2 gap-space-sm mt-space-md pt-space-md border-t border-surface-container-high/60 fp-about-bullets" data-pixelpost-customize="about-bullets" data-pixelpost-label="<?php esc_attr_e( 'Feature Bullets', 'pixelpost' ); ?>">
						<?php
						foreach ( $pixelpost_about_bullets as $pixelpost_bullet_item ) :
							$pixelpost_bullet_text = is_array( $pixelpost_bullet_item ) ? ( isset( $pixelpost_bullet_item['text'] ) ? $pixelpost_bullet_item['text'] : '' ) : $pixelpost_bullet_item;
							if ( empty( $pixelpost_bullet_text ) ) {
								continue;
							}
						?>
							<div class="flex items-start gap-2">
								<?php echo pixelpost_get_icon( 'check_circle', array( 'width' => 20, 'height' => 20, 'class' => 'text-primary flex-shrink-0 mt-0.5' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								<span class="font-body-sm text-body-sm text-on-surface font-medium"><?php echo esc_html( $pixelpost_bullet_text ); ?></span>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
