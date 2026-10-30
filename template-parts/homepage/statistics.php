<?php
/**
 * Statistics & Highlights Strip Template Part
 * Matches Editorial Minimalism: Clean horizontal strip with dividers
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
<section id="stats" class="w-full max-w-[1140px] mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-10 border-t border-b border-[#E9E6E0] dark:border-[#2E2D29] fp-stats-section" aria-label="<?php esc_attr_e( 'Career Highlights', 'pixelpost' ); ?>" data-pixelpost-customize="statistics" data-pixelpost-label="<?php esc_attr_e( 'Statistics Strip', 'pixelpost' ); ?>">
	<div class="grid grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-0 fp-stats-grid">
		<?php
		$total_stats = count( $pixelpost_stats );
		foreach ( $pixelpost_stats as $pixelpost_index => $pixelpost_stat ) :
			$pixelpost_stat_num = $pixelpost_index + 1;
			$pixelpost_raw_num  = ! empty( $pixelpost_stat['number'] ) ? (string) $pixelpost_stat['number'] : '';
			$pixelpost_suffix   = ! empty( $pixelpost_stat['suffix'] ) ? $pixelpost_stat['suffix'] : '';
			$pixelpost_label    = ! empty( $pixelpost_stat['label'] ) ? $pixelpost_stat['label'] : '';
			$pixelpost_desc     = ! empty( $pixelpost_stat['desc'] ) ? $pixelpost_stat['desc'] : '';

			if ( empty( $pixelpost_raw_num ) && empty( $pixelpost_label ) ) {
				continue;
			}

			// Separate trailing +, %, etc.
			if ( empty( $pixelpost_suffix ) && preg_match( '/^([0-9\.,]+)(.*)$/', $pixelpost_raw_num, $pixelpost_matches ) ) {
				$pixelpost_num_val = $pixelpost_matches[1];
				$pixelpost_suffix  = $pixelpost_matches[2];
			} else {
				$pixelpost_num_val = $pixelpost_raw_num;
			}

			// Add right border divider for all except the last item on desktop
			$border_class = ( $pixelpost_index < $total_stats - 1 ) ? 'lg:border-r border-[#E9E6E0] dark:border-[#2E2D29]' : '';
			// Horizontal padding for middle items
			$padding_class = ( $pixelpost_index === 0 ) ? 'lg:pr-8' : ( ( $pixelpost_index === $total_stats - 1 ) ? 'lg:pl-8' : 'lg:px-8' );
		?>
			<div class="flex flex-col <?php echo esc_attr( $border_class . ' ' . $padding_class ); ?> fp-stat-item">
				<div class="flex items-baseline gap-0.5 mb-1.5 fp-stat-number-wrap">
					<span class="font-serif text-4xl sm:text-5xl font-normal text-primary tracking-tight fp-stat-number"><?php echo esc_html( $pixelpost_num_val ); ?></span>
					<?php if ( ! empty( $pixelpost_suffix ) ) : ?>
						<span class="font-serif text-3xl sm:text-4xl text-primary font-normal fp-stat-suffix"><?php echo esc_html( $pixelpost_suffix ); ?></span>
					<?php endif; ?>
				</div>
				<span class="font-bold text-sm sm:text-base text-on-surface mb-1 fp-stat-label"><?php echo esc_html( $pixelpost_label ); ?></span>
				<?php if ( ! empty( $pixelpost_desc ) ) : ?>
					<p class="text-xs sm:text-sm text-on-surface-variant leading-relaxed fp-stat-desc"><?php echo esc_html( $pixelpost_desc ); ?></p>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	</div>
</section>
