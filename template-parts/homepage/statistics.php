<?php
/**
 * Statistics & Highlights Strip Template Part
 * Matches Google Stitch PRD: Bento Architecture
 *
 * @package Pixelpost
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$pixelpost_stats = pixelpost_get_stats_items();

// Legacy per-field fallback check if repeater empty
if ( empty( $pixelpost_stats ) ) {
	for ( $pixelpost_i = 1; $pixelpost_i <= 4; $pixelpost_i++ ) {
		$pixelpost_number = pixelpost_get_setting( "pixelpost_stat{$pixelpost_i}_number" );
		$pixelpost_suffix = pixelpost_get_setting( "pixelpost_stat{$pixelpost_i}_suffix" );
		$pixelpost_label  = pixelpost_get_setting( "pixelpost_stat{$pixelpost_i}_label" );
		$pixelpost_desc   = pixelpost_get_setting( "pixelpost_stat{$pixelpost_i}_desc" );

		if ( ! empty( $pixelpost_number ) || ! empty( $pixelpost_label ) ) {
			$pixelpost_stats[] = array(
				'number' => $pixelpost_number,
				'suffix' => $pixelpost_suffix,
				'label'  => $pixelpost_label,
				'desc'   => $pixelpost_desc,
			);
		}
	}
}

if ( empty( $pixelpost_stats ) ) {
	return;
}
?>
<section id="stats" class="w-full max-w-[1200px] mx-auto px-margin-mobile lg:px-margin py-space-md fp-stats-section" aria-label="<?php esc_attr_e( 'Career Highlights', 'pixelpost' ); ?>" data-pixelpost-customize="statistics" data-pixelpost-label="<?php esc_attr_e( 'Statistics Strip', 'pixelpost' ); ?>">
	<div class="bg-surface-container-lowest rounded-xl p-space-md lg:p-space-lg shadow-sm fp-stats-card">
		<div class="grid grid-cols-2 lg:grid-cols-4 gap-space-md lg:gap-space-lg fp-stats-grid">
			<?php foreach ( $pixelpost_stats as $pixelpost_index => $pixelpost_stat ) : ?>
				<?php
				$pixelpost_stat_num = $pixelpost_index + 1;
				$pixelpost_raw_num  = ! empty( $pixelpost_stat['number'] ) ? (string) $pixelpost_stat['number'] : '';
				$pixelpost_suffix   = ! empty( $pixelpost_stat['suffix'] ) ? $pixelpost_stat['suffix'] : '';
				$pixelpost_label    = ! empty( $pixelpost_stat['label'] ) ? $pixelpost_stat['label'] : '';
				$pixelpost_desc     = ! empty( $pixelpost_stat['desc'] ) ? $pixelpost_stat['desc'] : '';

				if ( empty( $pixelpost_raw_num ) && empty( $pixelpost_label ) ) {
					continue;
				}

				// If suffix wasn't split, separate trailing +, %, etc.
				if ( empty( $pixelpost_suffix ) && preg_match( '/^([0-9\.,]+)(.*)$/', $pixelpost_raw_num, $pixelpost_matches ) ) {
					$pixelpost_num_val = $pixelpost_matches[1];
					$pixelpost_suffix  = $pixelpost_matches[2];
				} else {
					$pixelpost_num_val = $pixelpost_raw_num;
				}

				// Metric 1 and 4 have terracotta numbers in the design
				$pixelpost_is_primary_color = ( 0 === $pixelpost_index || 3 === $pixelpost_index );
				$pixelpost_num_color_class  = $pixelpost_is_primary_color ? 'text-primary' : 'text-on-surface';
				?>
				<?php
				/* translators: 1: statistic index number, 2: statistic label */
				$pixelpost_stat_item_label = sprintf( esc_html__( 'Stat %1$d: %2$s', 'pixelpost' ), $pixelpost_stat_num, $pixelpost_label );
				?>
				<div class="flex flex-col fp-stat-item" data-pixelpost-customize="statistics" data-pixelpost-label="<?php echo esc_attr( $pixelpost_stat_item_label ); ?>">
					<div class="flex items-baseline gap-1 fp-stat-number-wrap">
						<span class="font-metric-val text-metric-val <?php echo esc_attr( $pixelpost_num_color_class ); ?> tracking-tight fp-stat-number"><?php echo esc_html( $pixelpost_num_val ); ?></span>
						<?php if ( ! empty( $pixelpost_suffix ) ) : ?>
							<span class="font-headline-sm text-headline-sm text-primary fp-stat-suffix"><?php echo esc_html( $pixelpost_suffix ); ?></span>
						<?php endif; ?>
					</div>
					<span class="font-title-md text-title-md text-on-surface font-semibold mt-1 fp-stat-label"><?php echo esc_html( $pixelpost_label ); ?></span>
					<?php if ( ! empty( $pixelpost_desc ) ) : ?>
						<p class="font-body-sm text-body-sm text-on-surface-variant mt-0.5 fp-stat-desc"><?php echo esc_html( $pixelpost_desc ); ?></p>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
