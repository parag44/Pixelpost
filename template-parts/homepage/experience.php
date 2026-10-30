<?php
/**
 * Experience Timeline Template Part
 * Matches Editorial Minimalism: 3-Part Horizontal Structure (Date | Timeline Node & Spine | Details)
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

$total_exp = count( $pixelpost_experiences );
?>
<section id="experience" class="w-full max-w-[1140px] mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-24 border-b border-[#E9E6E0] dark:border-[#2E2D29] fp-experience-section" aria-label="<?php esc_attr_e( 'Work Experience', 'pixelpost' ); ?>" data-pixelpost-customize="experience" data-pixelpost-label="<?php esc_attr_e( 'Work Experience', 'pixelpost' ); ?>">
	<div class="flex flex-col sm:flex-row sm:items-end justify-between mb-12 lg:mb-16 gap-4">
		<div class="flex flex-col max-w-2xl">
			<?php if ( ! empty( $pixelpost_eyebrow ) ) : ?>
				<div class="inline-flex items-center gap-2 mb-3">
					<span class="text-xs uppercase tracking-widest font-semibold text-[#A94F20] dark:text-[#D4733F]"><?php echo esc_html( $pixelpost_eyebrow ); ?></span>
					<span class="w-8 h-px bg-[#A94F20]/50"></span>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $pixelpost_heading ) ) : ?>
				<h2 class="font-serif text-3xl sm:text-4xl lg:text-[40px] text-on-surface leading-tight"><?php echo esc_html( $pixelpost_heading ); ?></h2>
			<?php endif; ?>
		</div>

		<div>
			<a class="inline-flex items-center gap-1.5 text-sm font-semibold text-[#A94F20] dark:text-[#D4733F] hover:underline" href="<?php echo esc_url( home_url( '/#contact' ) ); ?>">
				<span><?php esc_html_e( 'View full resume', 'pixelpost' ); ?></span>
				<?php echo pixelpost_get_icon( 'external_link', array( 'width' => 14, 'height' => 14 ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</a>
		</div>
	</div>

	<!-- 3-Part Continuous Timeline -->
	<div class="flex flex-col fp-timeline" data-pixelpost-customize="experience" data-pixelpost-label="<?php esc_attr_e( 'Experience Timeline', 'pixelpost' ); ?>">
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

			// Format tags with middle dot ' · '
			if ( is_array( $pixelpost_raw_tags ) ) {
				$tags_string = implode( ' · ', $pixelpost_raw_tags );
			} else {
				$tags_arr    = array_map( 'trim', explode( ',', str_replace( '·', ',', $pixelpost_raw_tags ) ) );
				$tags_string = implode( ' · ', array_filter( $tags_arr ) );
			}

			$is_last = ( $pixelpost_index === $total_exp - 1 );
			?>
			<div class="grid grid-cols-1 sm:grid-cols-[140px_36px_1fr] lg:grid-cols-[160px_44px_1fr] gap-x-2 sm:gap-x-0 relative group fp-timeline-row">
				<!-- LEFT: Fixed Date Column -->
				<div class="text-sm font-medium text-on-surface-variant sm:text-right sm:pr-8 pt-1 mb-2 sm:mb-0 fp-timeline-date-col">
					<?php echo esc_html( $pixelpost_date ); ?>
				</div>

				<!-- CENTER: Spine & Node Marker -->
				<div class="hidden sm:flex flex-col items-center relative fp-timeline-center-col">
					<!-- Circular Marker -->
					<?php if ( $pixelpost_is_current ) : ?>
						<div class="w-4 h-4 rounded-full bg-primary ring-4 ring-[#F5EAE1] dark:ring-[#2C1F17] mt-1.5 z-10 flex-shrink-0 fp-node-current"></div>
					<?php else : ?>
						<div class="w-3 h-3 rounded-full bg-[#B8B4AC] dark:bg-[#524E48] mt-2 z-10 flex-shrink-0 fp-node-past"></div>
					<?php endif; ?>

					<!-- Continuous connecting line -->
					<?php if ( ! $is_last ) : ?>
						<div class="w-[2px] flex-1 bg-[#D4CEBF] dark:bg-[#3D3A35] my-1 fp-timeline-spine"></div>
					<?php endif; ?>
				</div>

				<!-- RIGHT: Content Column -->
				<div class="<?php echo $is_last ? 'pb-2' : 'pb-14 sm:pb-16'; ?> sm:pl-8 fp-timeline-content-col">
					<div class="flex flex-wrap items-center gap-2.5 mb-1.5">
						<h3 class="font-serif font-bold text-xl sm:text-2xl text-on-surface leading-snug fp-timeline-job-title"><?php echo esc_html( $pixelpost_title ); ?></h3>
						<?php if ( $pixelpost_is_current ) : ?>
							<span class="inline-flex items-center px-2.5 py-0.5 text-xs font-semibold rounded bg-[#F5EAE1] dark:bg-[#2C1F17] text-[#A94F20] dark:text-[#D4733F] fp-current-badge">
								<?php esc_html_e( 'Current', 'pixelpost' ); ?>
							</span>
						<?php endif; ?>
					</div>

					<?php if ( ! empty( $pixelpost_company ) ) : ?>
						<div class="text-xs uppercase tracking-wider font-bold text-[#77736D] dark:text-[#D4733F] mt-1 mb-3 fp-timeline-company-name">
							<?php echo esc_html( $pixelpost_company ); ?>
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $pixelpost_desc ) ) : ?>
						<p class="text-sm sm:text-[15px] text-[#55524D] dark:text-[#B5B0A6] leading-[1.7] max-w-2xl mb-3.5 fp-timeline-desc">
							<?php echo esc_html( $pixelpost_desc ); ?>
						</p>
					<?php endif; ?>

					<?php if ( ! empty( $tags_string ) ) : ?>
						<div class="text-xs sm:text-sm text-on-surface-variant/90 leading-relaxed fp-timeline-skills">
							<span class="font-semibold text-on-surface"><?php esc_html_e( 'Skills:', 'pixelpost' ); ?></span> <?php echo esc_html( $tags_string ); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</section>
