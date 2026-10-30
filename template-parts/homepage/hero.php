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
<section id="hero" class="w-full max-w-[1140px] mx-auto px-4 sm:px-6 lg:px-8 pt-10 sm:pt-14 lg:pt-16 pb-12 lg:pb-16 fp-hero-section" aria-label="<?php esc_attr_e( 'Introduction', 'pixelpost' ); ?>" data-pixelpost-customize="hero" data-pixelpost-label="<?php esc_attr_e( 'Hero Section', 'pixelpost' ); ?>">
	<div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-center">
		<!-- Left Column: Editorial Presentation -->
		<div class="lg:col-span-7 flex flex-col items-start fp-hero-left">
			<?php if ( ! empty( $pixelpost_eyebrow ) ) : ?>
				<div class="inline-flex items-center gap-2 mb-4">
					<span class="text-xs uppercase tracking-widest font-semibold text-[#A94F20] dark:text-[#D4733F] fp-hero-eyebrow" data-pixelpost-customize="hero-eyebrow" data-pixelpost-label="<?php esc_attr_e( 'Greeting Eyebrow', 'pixelpost' ); ?>">
						<?php echo esc_html( $pixelpost_eyebrow ); ?>
					</span>
				</div>
			<?php endif; ?>

			<h1 class="font-serif text-4xl sm:text-5xl lg:text-6xl text-on-surface leading-[1.12] mb-5 fp-hero-headline">
				<span class="fp-hero-headline-main" data-pixelpost-customize="hero-headline" data-pixelpost-label="<?php esc_attr_e( 'Headline Prefix', 'pixelpost' ); ?>"><?php echo esc_html( $pixelpost_headline ); ?></span>
				<?php if ( ! empty( $pixelpost_accent ) ) : ?>
					<span class="text-primary italic font-serif font-normal ml-1 fp-hero-accent" data-pixelpost-customize="hero-name" data-pixelpost-label="<?php esc_attr_e( 'Headline Accent', 'pixelpost' ); ?>"><?php echo esc_html( $pixelpost_accent ); ?></span>
				<?php endif; ?>
			</h1>

			<?php if ( ! empty( $pixelpost_desc ) ) : ?>
				<p class="text-base sm:text-lg text-on-surface-variant max-w-xl mb-6 leading-relaxed fp-hero-description" data-pixelpost-customize="hero-description" data-pixelpost-label="<?php esc_attr_e( 'Introduction / Bio', 'pixelpost' ); ?>">
					<?php echo esc_html( $pixelpost_desc ); ?>
				</p>
			<?php endif; ?>

			<!-- Meta Badges: Location + Availability -->
			<div class="flex flex-wrap items-center gap-y-2 gap-x-6 text-sm mb-8 text-on-surface-variant fp-hero-meta">
				<?php if ( ! empty( $pixelpost_location ) ) : ?>
					<div class="inline-flex items-center gap-1.5 fp-hero-location">
						<?php echo pixelpost_get_icon( 'location_on', array( 'width' => 16, 'height' => 16, 'class' => 'text-primary' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<span><?php echo esc_html( $pixelpost_location ); ?></span>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $pixelpost_avail ) ) : ?>
					<div class="inline-flex items-center gap-2 text-on-surface font-medium fp-hero-avail">
						<span class="relative flex h-2.5 w-2.5">
							<span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
							<span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
						</span>
						<span><?php echo esc_html( $pixelpost_avail ); ?></span>
					</div>
				<?php endif; ?>
			</div>

			<!-- Action Buttons -->
			<div class="flex flex-wrap items-center gap-3 w-full sm:w-auto fp-hero-actions">
				<?php if ( ! empty( $pixelpost_btn1_text ) && ! empty( $pixelpost_btn1_url ) ) : ?>
					<a class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded bg-primary hover:bg-primary-container text-on-primary text-sm font-medium transition-all shadow-sm fp-button-primary" href="<?php echo esc_url( $pixelpost_btn1_url ); ?>" data-pixelpost-customize="hero-primary-button" data-pixelpost-label="<?php esc_attr_e( 'Primary Button', 'pixelpost' ); ?>">
						<span><?php echo esc_html( $pixelpost_btn1_text ); ?></span>
						<?php echo pixelpost_get_icon( 'arrow_forward', array( 'width' => 16, 'height' => 16 ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</a>
				<?php endif; ?>

				<?php if ( ! empty( $pixelpost_btn2_text ) && ! empty( $pixelpost_btn2_url ) ) : ?>
					<a class="inline-flex items-center justify-center px-6 py-3 rounded border border-[#E9E6E0] dark:border-[#2E2D29] bg-surface hover:bg-[#F5EAE1]/40 dark:hover:bg-[#2C1F17]/40 text-on-surface text-sm font-medium transition-all fp-button-secondary" href="<?php echo esc_url( $pixelpost_btn2_url ); ?>" data-pixelpost-customize="hero-secondary-button" data-pixelpost-label="<?php esc_attr_e( 'Secondary Button', 'pixelpost' ); ?>">
						<?php echo esc_html( $pixelpost_btn2_text ); ?>
					</a>
				<?php endif; ?>
			</div>
		</div>

		<!-- Right Column: Profile Image + Editorial Frame + Handwritten Note -->
		<div class="lg:col-span-5 w-full flex justify-center lg:justify-end fp-hero-right">
			<div class="relative w-full max-w-[380px] sm:max-w-[400px] fp-hero-image-wrap">
				<!-- Subtle offset decorative background frame -->
				<div class="absolute -inset-2 sm:-inset-3 bg-[#F5EAE1] dark:bg-[#2C1F17] rounded -z-10 translate-x-2 sm:translate-x-3 translate-y-2 sm:translate-y-3 transition-transform" aria-hidden="true"></div>

				<!-- Portrait Image Container -->
				<div class="relative rounded overflow-hidden border border-[#E9E6E0] dark:border-[#2E2D29] bg-[#FAF9F6] dark:bg-[#161514] aspect-[4/5] w-full" data-pixelpost-customize="hero-image" data-pixelpost-label="<?php esc_attr_e( 'Hero Image', 'pixelpost' ); ?>">
					<?php
					echo pixelpost_render_optimized_image(
						$pixelpost_hero_img,
						array(
							'class'         => 'w-full h-full object-cover object-top hover:scale-[1.02] transition-transform duration-700 fp-hero-headshot',
							'alt'           => ( $pixelpost_accent ? $pixelpost_accent : $pixelpost_headline ) . ( $pixelpost_role ? ' — ' . $pixelpost_role : '' ),
							'loading'       => 'eager',
							'fetchpriority' => 'high',
							'width'         => 600,
							'height'        => 750,
						)
					); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					?>
				</div>

				<!-- Subtle handwritten-style decorative note -->
				<div class="absolute -right-3 sm:-right-8 top-1/2 -translate-y-1/2 flex flex-col items-center pointer-events-none select-none text-[#A94F20] dark:text-[#D4733F] font-script transform rotate-3 fp-hero-script-note" aria-hidden="true">
					<span class="text-2xl sm:text-3xl leading-tight">Build</span>
					<span class="text-2xl sm:text-3xl leading-tight italic">Test</span>
					<span class="text-2xl sm:text-3xl leading-tight">Explore</span>
					<svg width="48" height="10" viewBox="0 0 48 10" fill="none" class="mt-0.5 opacity-80"><path d="M2 7C14 2 32 8 46 3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
				</div>
			</div>
		</div>
	</div>
</section>
