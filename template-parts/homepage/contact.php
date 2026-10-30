<?php
/**
 * Contact & Consultation Hub Section Template Part
 * Matches Editorial Minimalism: Clean horizontal/split presentation (Heading & Bio + Action Buttons)
 *
 * @package Pixelpost
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$pixelpost_eyebrow       = pixelpost_get_setting( 'pixelpost_contact_eyebrow' );
$pixelpost_heading       = pixelpost_get_setting( 'pixelpost_contact_heading' );
$pixelpost_description   = pixelpost_get_setting( 'pixelpost_contact_description' );
$pixelpost_btn_primary   = pixelpost_get_setting( 'pixelpost_contact_btn_primary' );
$pixelpost_btn_secondary = pixelpost_get_setting( 'pixelpost_contact_btn_secondary' );
$pixelpost_btn_sec_url   = pixelpost_get_setting( 'pixelpost_contact_btn_secondary_url' );

// Derive email for primary button
$pixelpost_primary_email = pixelpost_get_setting( 'pixelpost_contact_email' );
if ( empty( $pixelpost_primary_email ) ) {
	$pixelpost_primary_email = 'parag.feni@yahoo.com';
}
if ( empty( $pixelpost_btn_sec_url ) ) {
	$pixelpost_btn_sec_url = 'https://calendly.com';
}
?>
<section id="contact" class="w-full max-w-[1140px] mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24 border-b border-[#E9E6E0] dark:border-[#2E2D29] fp-contact-section" aria-label="<?php esc_attr_e( 'Contact and Collaboration', 'pixelpost' ); ?>" data-pixelpost-customize="contact" data-pixelpost-label="<?php esc_attr_e( 'Contact Section', 'pixelpost' ); ?>">
	<div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8 lg:gap-12 fp-contact-inner">
		<!-- Left: Heading & Narrative -->
		<div class="flex flex-col items-start max-w-2xl fp-contact-left">
			<?php if ( ! empty( $pixelpost_eyebrow ) ) : ?>
				<div class="inline-flex items-center gap-2 mb-3">
					<span class="text-xs uppercase tracking-widest font-semibold text-[#A94F20] dark:text-[#D4733F]"><?php echo esc_html( $pixelpost_eyebrow ); ?></span>
					<span class="w-8 h-px bg-[#A94F20]/40"></span>
				</div>
			<?php endif; ?>

			<h2 class="font-serif text-3xl sm:text-4xl lg:text-5xl text-on-surface mb-4 leading-tight fp-contact-heading" data-pixelpost-customize="contact-heading" data-pixelpost-label="<?php esc_attr_e( 'Contact Heading', 'pixelpost' ); ?>">
				<?php echo esc_html( $pixelpost_heading ); ?>
			</h2>

			<?php if ( ! empty( $pixelpost_description ) ) : ?>
				<p class="font-body text-base sm:text-lg text-on-surface-variant leading-relaxed max-w-xl fp-contact-description" data-pixelpost-customize="contact-description" data-pixelpost-label="<?php esc_attr_e( 'Contact Invitation', 'pixelpost' ); ?>">
					<?php echo esc_html( $pixelpost_description ); ?>
				</p>
			<?php endif; ?>
		</div>

		<!-- Right: Action Buttons Side-by-Side -->
		<div class="flex flex-wrap items-center gap-3.5 sm:gap-4 flex-shrink-0 fp-contact-buttons">
			<?php if ( ! empty( $pixelpost_btn_primary ) ) : ?>
				<a class="inline-flex items-center gap-2 px-6 py-3 rounded bg-primary hover:bg-primary-container text-on-primary text-sm font-medium transition-all shadow-sm fp-button-primary" href="<?php echo esc_url( 'mailto:' . antispambot( $pixelpost_primary_email ) ); ?>" data-pixelpost-customize="contact-primary-btn" data-pixelpost-label="<?php esc_attr_e( 'Send Email Button', 'pixelpost' ); ?>">
					<?php echo pixelpost_get_icon( 'mail', array( 'width' => 18, 'height' => 18 ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<span><?php echo esc_html( $pixelpost_btn_primary ); ?></span>
				</a>
			<?php endif; ?>

			<?php if ( ! empty( $pixelpost_btn_secondary ) ) : ?>
				<a class="inline-flex items-center gap-2 px-6 py-3 rounded border border-[#E9E6E0] dark:border-[#2E2D29] bg-surface hover:bg-[#F5EAE1]/30 dark:hover:bg-[#2C1F17]/30 text-on-surface text-sm font-medium transition-all fp-button-secondary" href="<?php echo esc_url( $pixelpost_btn_sec_url ); ?>" rel="noopener noreferrer" target="_blank" data-pixelpost-customize="contact-secondary-btn" data-pixelpost-label="<?php esc_attr_e( 'Schedule Call Button', 'pixelpost' ); ?>">
					<?php echo pixelpost_get_icon( 'calendar_today', array( 'width' => 18, 'height' => 18 ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<span><?php echo esc_html( $pixelpost_btn_secondary ); ?></span>
				</a>
			<?php endif; ?>
		</div>
	</div>
</section>
