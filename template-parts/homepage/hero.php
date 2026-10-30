<?php
/**
 * Hero Section Template Part
 * Matches Editorial Minimalism: Two-column editorial presentation + Parag Das Portrait + Handwritten Note
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
$pixelpost_location  = pixelpost_get_setting( 'pixelpost_hero_location' );
if ( empty( $pixelpost_location ) ) {
	$pixelpost_location = 'Dhaka, Bangladesh';
}
$pixelpost_avail = pixelpost_get_setting( 'pixelpost_hero_avail_status' );
if ( empty( $pixelpost_avail ) ) {
	$pixelpost_avail = 'Available for opportunities';
}

$pixelpost_btn1_text = pixelpost_get_setting( 'pixelpost_hero_btn_primary_text' );
$pixelpost_btn1_url  = pixelpost_get_setting( 'pixelpost_hero_btn_primary_url' );
$pixelpost_btn2_text = pixelpost_get_setting( 'pixelpost_hero_btn_secondary_text' );
$pixelpost_btn2_url  = pixelpost_get_setting( 'pixelpost_hero_btn_secondary_url' );
$pixelpost_hero_img  = pixelpost_get_setting( 'pixelpost_hero_image' );
if ( empty( $pixelpost_hero_img ) ) {
	$pixelpost_hero_img = get_template_directory_uri() . '/assets/images/developer-hero.jpg';
}
?>
<section id="hero" class="w-full max-w-[1140px] mx-auto px-4 sm:px-6 lg:px-8 pt-14 sm:pt-16 lg:pt-20 pb-16 lg:pb-24 fp-hero-section" aria-label="<?php esc_attr_e( 'Introduction', 'pixelpost' ); ?>" data-pixelpost-customize="hero" data-pixelpost-label="<?php esc_attr_e( 'Hero Section', 'pixelpost' ); ?>">
	<div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-center">
		<!-- Left Column: Editorial Presentation -->
		<div class="lg:col-span-7 flex flex-col items-start fp-hero-left">
			<?php if ( ! empty( $pixelpost_eyebrow ) ) : ?>
				<div class="inline-flex items-center gap-2.5 mb-5">
					<span class="text-xs uppercase tracking-widest font-semibold text-[#A94F20] dark:text-[#D4733F] fp-hero-eyebrow" data-pixelpost-customize="hero-eyebrow" data-pixelpost-label="<?php esc_attr_e( 'Greeting Eyebrow', 'pixelpost' ); ?>">
						<?php echo esc_html( $pixelpost_eyebrow ); ?>
					</span>
					<span class="w-8 h-px bg-[#A94F20]/50"></span>
				</div>
			<?php endif; ?>

			<h1 class="font-serif text-5xl sm:text-6xl lg:text-[68px] text-on-surface leading-[1.08] mb-6 fp-hero-headline">
				<span class="fp-hero-headline-main" data-pixelpost-customize="hero-headline" data-pixelpost-label="<?php esc_attr_e( 'Headline Prefix', 'pixelpost' ); ?>"><?php echo esc_html( $pixelpost_headline ); ?></span>
				<?php if ( ! empty( $pixelpost_accent ) ) : ?>
					<span class="text-primary italic font-serif font-normal ml-1 fp-hero-accent" data-pixelpost-customize="hero-name" data-pixelpost-label="<?php esc_attr_e( 'Headline Accent', 'pixelpost' ); ?>"><?php echo esc_html( $pixelpost_accent ); ?></span>
				<?php endif; ?>
			</h1>

			<?php if ( ! empty( $pixelpost_desc ) ) : ?>
				<p class="text-base sm:text-[17px] text-on-surface-variant max-w-xl mb-8 leading-[1.7] fp-hero-description" data-pixelpost-customize="hero-description" data-pixelpost-label="<?php esc_attr_e( 'Introduction / Bio', 'pixelpost' ); ?>">
					<?php echo esc_html( $pixelpost_desc ); ?>
				</p>
			<?php endif; ?>

			<!-- Meta Badges: Location + Availability -->
			<div class="flex flex-wrap items-center gap-y-2 gap-x-6 text-sm mb-8 text-on-surface-variant fp-hero-meta">
				<?php if ( ! empty( $pixelpost_location ) ) : ?>
					<div class="inline-flex items-center gap-1.5 fp-hero-location" data-pixelpost-customize="hero-location" data-pixelpost-label="<?php esc_attr_e( 'Hero Location', 'pixelpost' ); ?>">
						<?php echo pixelpost_get_icon( 'location_on', array( 'width' => 16, 'height' => 16, 'class' => 'text-primary' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<span class="fp-hero-location-text"><?php echo esc_html( $pixelpost_location ); ?></span>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $pixelpost_avail ) ) : ?>
					<div class="inline-flex items-center gap-2 text-on-surface font-medium fp-hero-avail" data-pixelpost-customize="hero-avail" data-pixelpost-label="<?php esc_attr_e( 'Availability Status', 'pixelpost' ); ?>">
						<span class="relative flex h-2.5 w-2.5">
							<span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
							<span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
						</span>
						<span class="fp-hero-avail-text"><?php echo esc_html( $pixelpost_avail ); ?></span>
					</div>
				<?php endif; ?>
			</div>

			<!-- Action Buttons -->
			<div class="flex flex-wrap items-center gap-3.5 w-full sm:w-auto fp-hero-actions">
				<?php if ( ! empty( $pixelpost_btn1_text ) && ! empty( $pixelpost_btn1_url ) ) : ?>
					<a class="inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded bg-primary hover:bg-primary-container text-on-primary text-sm font-medium transition-all shadow-none fp-button-primary" href="<?php echo esc_url( $pixelpost_btn1_url ); ?>" data-pixelpost-customize="hero-primary-button" data-pixelpost-label="<?php esc_attr_e( 'Primary Button', 'pixelpost' ); ?>">
						<span><?php echo esc_html( $pixelpost_btn1_text ); ?></span>
						<?php echo pixelpost_get_icon( 'arrow_forward', array( 'width' => 16, 'height' => 16 ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</a>
				<?php endif; ?>

				<?php if ( ! empty( $pixelpost_btn2_text ) && ! empty( $pixelpost_btn2_url ) ) : ?>
					<a class="inline-flex items-center justify-center px-6 py-3.5 rounded border border-[#E9E6E0] dark:border-[#2E2D29] bg-[#FAF9F6] dark:bg-[#161514] hover:bg-[#F5EAE1]/50 dark:hover:bg-[#2C1F17]/50 text-on-surface text-sm font-medium transition-all fp-button-secondary" href="<?php echo esc_url( $pixelpost_btn2_url ); ?>" data-pixelpost-customize="hero-secondary-button" data-pixelpost-label="<?php esc_attr_e( 'Secondary Button', 'pixelpost' ); ?>">
						<?php echo esc_html( $pixelpost_btn2_text ); ?>
					</a>
				<?php endif; ?>
			</div>
		</div>

		<!-- Right Column: Profile Image + Editorial Frame + Handwritten Note -->
		<div class="lg:col-span-5 w-full flex justify-center lg:justify-end relative fp-hero-right">
			<div class="relative w-full max-w-[400px] sm:max-w-[420px] fp-hero-image-wrap">
				<!-- Subtle offset decorative background frame -->
				<div class="absolute -inset-3 bg-[#F5EAE1] dark:bg-[#2C1F17] rounded -z-10 translate-x-3 translate-y-3 border border-[#E9E6E0]/60 dark:border-[#2E2D29] transition-transform" aria-hidden="true"></div>

				<!-- Portrait Image Container -->
				<div class="relative rounded overflow-hidden border border-[#E9E6E0] dark:border-[#2E2D29] bg-[#FAF9F6] dark:bg-[#161514] aspect-[4/5] w-full" data-pixelpost-customize="hero-image" data-pixelpost-label="<?php esc_attr_e( 'Hero Image', 'pixelpost' ); ?>">
					<?php
					echo pixelpost_render_optimized_image(
						$pixelpost_hero_img,
						array(
							'class'         => 'w-full h-full object-cover object-[center_18%] hover:scale-[1.02] transition-transform duration-700 fp-hero-headshot',
							'alt'           => ( $pixelpost_accent ? $pixelpost_accent : $pixelpost_headline ) . ( $pixelpost_role ? ' — ' . $pixelpost_role : '' ),
							'loading'       => 'eager',
							'fetchpriority' => 'high',
							'width'         => 600,
							'height'        => 750,
						)
					); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					?>
				</div>
			</div>
		</div>
	</div>
</section>
