<?php
/**
 * Contact & Consultation Hub Section Template Part
 * Matches Google Stitch PRD: Conversion Block + Channel Details Card
 *
 * @package Pixelpost
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$pixelpost_eyebrow         = pixelpost_get_setting( 'pixelpost_contact_eyebrow' );
$pixelpost_heading         = pixelpost_get_setting( 'pixelpost_contact_heading' );
$pixelpost_heading_accent  = pixelpost_get_setting( 'pixelpost_contact_heading_accent' );
$pixelpost_description     = pixelpost_get_setting( 'pixelpost_contact_description' );
$pixelpost_btn_primary     = pixelpost_get_setting( 'pixelpost_contact_btn_primary' );
$pixelpost_btn_secondary   = pixelpost_get_setting( 'pixelpost_contact_btn_secondary' );
$pixelpost_btn_sec_url     = pixelpost_get_setting( 'pixelpost_contact_btn_secondary_url' );

// Contact items from repeater (with fallback)
$pixelpost_contact_items   = pixelpost_get_contact_items();

// Derive email for the primary mailto button
$pixelpost_primary_email   = '';
foreach ( $pixelpost_contact_items as $pixelpost_ci ) {
	$pixelpost_cval  = isset( $pixelpost_ci['value'] ) ? trim( $pixelpost_ci['value'] ) : '';
	$pixelpost_clink = isset( $pixelpost_ci['link'] ) ? trim( $pixelpost_ci['link'] ) : '';
	if ( ! empty( $pixelpost_cval ) && is_email( $pixelpost_cval ) ) {
		$pixelpost_primary_email = $pixelpost_cval;
		break;
	} elseif ( ! empty( $pixelpost_clink ) && strpos( $pixelpost_clink, 'mailto:' ) === 0 ) {
		$pixelpost_primary_email = substr( $pixelpost_clink, 7 );
		break;
	}
}
if ( empty( $pixelpost_primary_email ) ) {
	$pixelpost_primary_email = pixelpost_get_setting( 'pixelpost_contact_email' );
}
?>
<section id="contact" class="w-full max-w-[1200px] mx-auto px-margin-mobile lg:px-margin pt-space-xl pb-space-xxl fp-contact-section" aria-label="<?php esc_attr_e( 'Contact and Consultation Hub', 'pixelpost' ); ?>" data-pixelpost-customize="contact" data-pixelpost-label="<?php esc_attr_e( 'Contact Section', 'pixelpost' ); ?>">
	<div class="grid grid-cols-1 lg:grid-cols-12 gap-space-lg items-stretch fp-contact-grid">
		<!-- Left: Conversion & CTA Action Block -->
		<div class="lg:col-span-7 bg-surface-container-lowest rounded-xl p-space-md lg:p-space-xl shadow-sm flex flex-col justify-between fp-contact-left">
			<div>
				<?php if ( ! empty( $pixelpost_eyebrow ) ) : ?>
					<span class="font-label-caps text-label-caps uppercase text-primary tracking-wider mb-space-xs"><?php echo esc_html( $pixelpost_eyebrow ); ?></span>
				<?php endif; ?>

				<h2 class="font-headline-display text-headline-display text-on-surface tracking-tight mb-space-xs fp-contact-heading" data-pixelpost-customize="contact-heading" data-pixelpost-label="<?php esc_attr_e( 'Contact Heading', 'pixelpost' ); ?>">
					<span class="fp-contact-heading-main"><?php echo esc_html( $pixelpost_heading ); ?></span>
					<?php if ( ! empty( $pixelpost_heading_accent ) ) : ?>
						<span class="text-primary italic font-headline-display fp-contact-heading-accent"><?php echo esc_html( $pixelpost_heading_accent ); ?></span>
					<?php endif; ?>
				</h2>

				<?php if ( ! empty( $pixelpost_description ) ) : ?>
					<p class="font-body-lg text-body-lg text-on-surface-variant max-w-lg mt-space-xs mb-space-lg leading-relaxed fp-contact-description" data-pixelpost-customize="contact-description" data-pixelpost-label="<?php esc_attr_e( 'Contact Invitation', 'pixelpost' ); ?>">
						<?php echo esc_html( $pixelpost_description ); ?>
					</p>
				<?php endif; ?>

				<!-- Action Buttons -->
				<div class="flex flex-wrap items-center gap-space-sm mb-space-md fp-contact-buttons">
					<?php if ( ! empty( $pixelpost_btn_primary ) && ! empty( $pixelpost_primary_email ) ) : ?>
						<a class="inline-flex items-center gap-2 px-space-md py-space-sm rounded-lg bg-primary hover:bg-primary-container text-on-primary font-label-md text-label-md shadow-md transition-all fp-button-primary" href="<?php echo esc_url( 'mailto:' . antispambot( $pixelpost_primary_email ) ); ?>" data-pixelpost-customize="contact-primary-btn" data-pixelpost-label="<?php esc_attr_e( 'Send Email Button', 'pixelpost' ); ?>">
							<?php echo pixelpost_get_icon( 'mail', array( 'width' => 18, 'height' => 18 ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							<span><?php echo esc_html( $pixelpost_btn_primary ); ?></span>
						</a>
					<?php endif; ?>

					<?php if ( ! empty( $pixelpost_btn_secondary ) && ! empty( $pixelpost_btn_sec_url ) ) : ?>
						<a class="inline-flex items-center gap-2 px-space-md py-space-sm rounded-lg bg-surface-container-high hover:bg-surface-variant text-on-surface font-label-md text-label-md transition-all fp-button-secondary" href="<?php echo esc_url( $pixelpost_btn_sec_url ); ?>" rel="noopener noreferrer" target="_blank" data-pixelpost-customize="contact-secondary-btn" data-pixelpost-label="<?php esc_attr_e( 'Schedule Call Button', 'pixelpost' ); ?>">
							<?php echo pixelpost_get_icon( 'calendar_today', array( 'width' => 18, 'height' => 18 ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							<span><?php echo esc_html( $pixelpost_btn_secondary ); ?></span>
						</a>
					<?php endif; ?>
				</div>
			</div>
		</div>

		<!-- Right: Channel & Direct Details Card -->
		<div class="lg:col-span-5 bg-surface-container-low rounded-xl p-space-md lg:p-space-lg shadow-sm flex flex-col justify-between gap-space-md fp-contact-right">
			<!-- Channels List -->
			<div class="flex flex-col gap-space-md fp-contact-channels" data-pixelpost-customize="contact-channels" data-pixelpost-label="<?php esc_attr_e( 'Contact Channel Cards', 'pixelpost' ); ?>">
				<?php
				if ( ! empty( $pixelpost_contact_items ) ) :
					foreach ( $pixelpost_contact_items as $pixelpost_idx => $pixelpost_item ) :
						$pixelpost_icon    = ! empty( $pixelpost_item['icon'] ) ? $pixelpost_item['icon'] : 'alternate_email';
						$pixelpost_label   = ! empty( $pixelpost_item['label'] ) ? $pixelpost_item['label'] : '';
						$pixelpost_val     = ! empty( $pixelpost_item['value'] ) ? $pixelpost_item['value'] : '';
						$pixelpost_context = ! empty( $pixelpost_item['context'] ) ? $pixelpost_item['context'] : '';
						$pixelpost_link    = ! empty( $pixelpost_item['link'] ) ? $pixelpost_item['link'] : '';

						if ( empty( $pixelpost_val ) && empty( $pixelpost_label ) ) {
							continue;
						}

						// Auto-detect mailto link if link is empty but value is email
						if ( empty( $pixelpost_link ) && ! empty( $pixelpost_val ) && is_email( $pixelpost_val ) ) {
							$pixelpost_link = 'mailto:' . antispambot( $pixelpost_val );
						}
						$pixelpost_is_email = is_email( $pixelpost_val );
						$pixelpost_is_external_link = ! empty( $pixelpost_link ) && strpos( $pixelpost_link, 'mailto:' ) !== 0 && strpos( $pixelpost_link, home_url() ) === false;
				?>
				<?php
				/* translators: %d: contact row index */
				$pixelpost_row_fallback_label = sprintf( esc_html__( 'Contact Row %d', 'pixelpost' ), $pixelpost_idx + 1 );
				?>
				<div class="flex items-start gap-space-sm bg-surface-container-lowest p-space-sm rounded-lg shadow-sm fp-contact-row" data-pixelpost-customize="contact-channels" data-pixelpost-label="<?php echo esc_attr( $pixelpost_label ? $pixelpost_label : $pixelpost_row_fallback_label ); ?>">
						<div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center text-primary flex-shrink-0 mt-0.5 fp-contact-icon-box">
							<?php echo pixelpost_get_icon( $pixelpost_icon, array( 'width' => 20, 'height' => 20 ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
						<div class="flex flex-col min-w-0 fp-contact-row-main">
							<?php if ( ! empty( $pixelpost_label ) ) : ?>
								<span class="font-label-caps text-label-caps text-on-surface-variant uppercase fp-contact-row-label"><?php echo esc_html( $pixelpost_label ); ?></span>
							<?php endif; ?>

							<?php if ( ! empty( $pixelpost_link ) ) : ?>
								<a class="font-title-md text-title-md text-on-surface font-semibold hover:text-primary transition-colors truncate fp-contact-email-link" href="<?php echo esc_url( $pixelpost_link ); ?>" <?php echo $pixelpost_is_external_link ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>>
									<?php echo esc_html( $pixelpost_is_email ? antispambot( $pixelpost_val ) : $pixelpost_val ); ?>
								</a>
							<?php else : ?>
								<span class="font-title-md text-title-md text-on-surface font-semibold fp-contact-location-val"><?php echo esc_html( $pixelpost_val ); ?></span>
							<?php endif; ?>

							<?php if ( ! empty( $pixelpost_context ) ) : ?>
								<span class="font-body-sm text-body-sm text-on-surface-variant mt-0.5 fp-contact-row-context"><?php echo esc_html( $pixelpost_context ); ?></span>
							<?php endif; ?>
						</div>
					</div>
				<?php
					endforeach;
				endif;
				?>
			</div>
		</div>
	</div>
</section>
