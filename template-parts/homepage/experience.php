<?php
/**
 * Experience Timeline Template Part
 * Matches Google Stitch PRD: Career Path & Work Experience
 *
 * @package Pixelpost
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$pixelpost_eyebrow  = pixelpost_get_setting( 'pixelpost_exp_eyebrow' );
$pixelpost_heading  = pixelpost_get_setting( 'pixelpost_exp_heading' );
$pixelpost_subtitle = pixelpost_get_setting( 'pixelpost_exp_subtitle' );

$pixelpost_experiences = pixelpost_get_experience_items();

// Legacy per-field fallback check if repeater empty
if ( empty( $pixelpost_experiences ) ) {
	for ( $pixelpost_i = 1; $pixelpost_i <= 3; $pixelpost_i++ ) {
		$pixelpost_title   = pixelpost_get_setting( "pixelpost_exp{$pixelpost_i}_title" );
		$pixelpost_company = pixelpost_get_setting( "pixelpost_exp{$pixelpost_i}_company" );
		$pixelpost_url     = pixelpost_get_setting( "pixelpost_exp{$pixelpost_i}_url" );
		$pixelpost_date    = pixelpost_get_setting( "pixelpost_exp{$pixelpost_i}_date" );
		$pixelpost_desc    = pixelpost_get_setting( "pixelpost_exp{$pixelpost_i}_desc" );

		if ( ! empty( $pixelpost_title ) ) {
			$pixelpost_experiences[] = array(
				'title'   => $pixelpost_title,
				'company' => $pixelpost_company,
				'url'     => $pixelpost_url,
				'date'    => $pixelpost_date,
				'desc'    => $pixelpost_desc,
			);
		}
	}
}

if ( empty( $pixelpost_experiences ) ) {
	return;
}
?>
<section id="experience" class="w-full max-w-[1200px] mx-auto px-margin-mobile lg:px-margin pt-space-xl pb-space-lg fp-experience-section" aria-label="<?php esc_attr_e( 'Work Experience', 'pixelpost' ); ?>" data-pixelpost-customize="experience" data-pixelpost-label="<?php esc_attr_e( 'Work Experience', 'pixelpost' ); ?>">
	<div class="flex flex-col mb-space-lg">
		<?php if ( ! empty( $pixelpost_eyebrow ) ) : ?>
			<span class="font-label-caps text-label-caps uppercase text-primary tracking-wider mb-space-xs"><?php echo esc_html( $pixelpost_eyebrow ); ?></span>
		<?php endif; ?>

		<?php if ( ! empty( $pixelpost_heading ) ) : ?>
			<h2 class="font-headline-lg text-headline-lg text-on-surface"><?php echo esc_html( $pixelpost_heading ); ?></h2>
		<?php endif; ?>

		<?php if ( ! empty( $pixelpost_subtitle ) ) : ?>
			<p class="font-body-md text-body-md text-on-surface-variant max-w-xl mt-space-xs"><?php echo esc_html( $pixelpost_subtitle ); ?></p>
		<?php endif; ?>
	</div>

	<!-- Timeline Container -->
	<div class="fp-timeline" data-pixelpost-customize="experience" data-pixelpost-label="<?php esc_attr_e( 'Experience Timeline', 'pixelpost' ); ?>">
		<?php foreach ( $pixelpost_experiences as $pixelpost_index => $pixelpost_exp ) : ?>
			<?php
			$pixelpost_exp_num    = $pixelpost_index + 1;
			$pixelpost_title      = ! empty( $pixelpost_exp['title'] ) ? $pixelpost_exp['title'] : '';
			$pixelpost_company    = ! empty( $pixelpost_exp['company'] ) ? $pixelpost_exp['company'] : '';
			$pixelpost_url        = ! empty( $pixelpost_exp['url'] ) ? $pixelpost_exp['url'] : '';
			$pixelpost_date       = ! empty( $pixelpost_exp['date'] ) ? $pixelpost_exp['date'] : '';
			$pixelpost_desc       = ! empty( $pixelpost_exp['desc'] ) ? $pixelpost_exp['desc'] : '';
			$pixelpost_raw_tags   = ! empty( $pixelpost_exp['tags'] ) ? $pixelpost_exp['tags'] : '';
			$pixelpost_is_current = ! empty( $pixelpost_exp['current'] ) || ( 0 === $pixelpost_index );

			if ( empty( $pixelpost_title ) && empty( $pixelpost_company ) ) {
				continue;
			}

			$pixelpost_tags_arr     = is_array( $pixelpost_raw_tags ) ? $pixelpost_raw_tags : array_map( 'trim', explode( ',', $pixelpost_raw_tags ) );
			$pixelpost_marker_class = $pixelpost_is_current ? 'fp-timeline-marker fp-timeline-marker-current' : 'fp-timeline-marker';
			?>
			<?php
			/* translators: 1: job index number, 2: job title */
			$pixelpost_item_label = sprintf( esc_html__( 'Job %1$d: %2$s', 'pixelpost' ), $pixelpost_exp_num, $pixelpost_title );
			?>
			<div class="fp-timeline-item group" data-pixelpost-customize="experience" data-pixelpost-label="<?php echo esc_attr( $pixelpost_item_label ); ?>">
				<!-- Vertical connecting spine -->
				<span class="fp-timeline-spine" aria-hidden="true"></span>

				<!-- Timeline Node Marker -->
				<div class="<?php echo esc_attr( $pixelpost_marker_class ); ?>" aria-hidden="true">
					<?php if ( $pixelpost_is_current ) : ?>
						<?php echo pixelpost_get_icon( 'work', array( 'width' => 15, 'height' => 15 ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<?php else : ?>
						<?php echo pixelpost_get_icon( 'work', array( 'width' => 14, 'height' => 14, 'class' => 'text-on-surface-variant/60 group-hover:text-primary transition-colors' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<?php endif; ?>
				</div>

				<!-- Experience Card -->
				<div class="fp-timeline-card">
					<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-space-xs">
						<div>
							<div class="flex flex-wrap items-center gap-2">
								<h3 class="font-title-md text-title-md text-on-surface font-semibold group-hover:text-primary transition-colors fp-timeline-title">
									<?php echo esc_html( $pixelpost_title ); ?>
								</h3>
								<?php if ( $pixelpost_is_current ) : ?>
									<span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-primary/10 text-primary font-label-caps text-label-caps uppercase font-bold tracking-wide fp-timeline-current-badge">
										<span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse" aria-hidden="true"></span>
										<?php esc_html_e( 'Current Role', 'pixelpost' ); ?>
									</span>
								<?php endif; ?>
							</div>

							<?php if ( ! empty( $pixelpost_company ) ) : ?>
								<div class="mt-1">
									<?php if ( ! empty( $pixelpost_url ) ) : ?>
										<a class="inline-flex items-center gap-1 font-label-caps text-label-caps text-primary hover:text-primary-container uppercase font-bold tracking-wide transition-colors fp-timeline-company" href="<?php echo esc_url( $pixelpost_url ); ?>" target="_blank" rel="noopener noreferrer">
											<span><?php echo esc_html( $pixelpost_company ); ?></span>
											<?php echo pixelpost_get_icon( 'open_in_new', array( 'width' => 12, 'height' => 12 ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
										</a>
									<?php else : ?>
										<span class="font-label-caps text-label-caps text-on-surface-variant uppercase font-bold tracking-wide fp-timeline-company">
											<?php echo esc_html( $pixelpost_company ); ?>
										</span>
									<?php endif; ?>
								</div>
							<?php endif; ?>
						</div>

						<?php if ( ! empty( $pixelpost_date ) ) : ?>
							<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded bg-surface-container font-label-caps text-label-caps text-on-surface-variant font-semibold self-start sm:self-center flex-shrink-0 fp-timeline-date">
								<?php echo pixelpost_get_icon( 'calendar_today', array( 'width' => 13, 'height' => 13, 'class' => 'text-primary' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								<span><?php echo esc_html( $pixelpost_date ); ?></span>
							</span>
						<?php endif; ?>
					</div>

					<?php if ( ! empty( $pixelpost_desc ) ) : ?>
						<p class="font-body-md text-body-md text-on-surface-variant mt-space-sm mb-space-md max-w-3xl leading-relaxed fp-timeline-desc">
							<?php echo esc_html( $pixelpost_desc ); ?>
						</p>
					<?php endif; ?>

					<?php if ( ! empty( $pixelpost_tags_arr ) && ! empty( array_filter( $pixelpost_tags_arr ) ) ) : ?>
						<div class="flex flex-wrap items-center gap-2 pt-space-xs border-t border-surface-container-high/40 fp-timeline-tags">
							<?php foreach ( $pixelpost_tags_arr as $pixelpost_t ) : ?>
								<?php if ( ! empty( $pixelpost_t ) ) : ?>
									<span class="fp-tag-chip"><?php echo esc_html( $pixelpost_t ); ?></span>
								<?php endif; ?>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</section>
