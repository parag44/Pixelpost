<?php
/**
 * Skills Section Template Part
 * Matches Editorial Minimalism: 2-Column Categorized Tools & Technologies Layout
 *
 * @package Pixelpost
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$pixelpost_eyebrow  = pixelpost_get_setting( 'pixelpost_skills_eyebrow' );
$pixelpost_heading  = pixelpost_get_setting( 'pixelpost_skills_heading' );
$pixelpost_subtitle = pixelpost_get_setting( 'pixelpost_skills_subtitle' );

$pixelpost_skills_items = pixelpost_get_skills_items();

if ( empty( $pixelpost_skills_items ) && empty( $pixelpost_heading ) ) {
	return;
}

// Split items into Left and Right columns
$left_col_items  = array();
$right_col_items = array();

$total_items = count( $pixelpost_skills_items );
$half_point  = (int) ceil( $total_items / 2 );

foreach ( $pixelpost_skills_items as $idx => $item ) {
	if ( isset( $item['column'] ) && 'right' === $item['column'] ) {
		$right_col_items[] = $item;
	} elseif ( isset( $item['column'] ) && 'left' === $item['column'] ) {
		$left_col_items[] = $item;
	} else {
		if ( $idx < $half_point ) {
			$left_col_items[] = $item;
		} else {
			$right_col_items[] = $item;
		}
	}
}
?>
<section id="skills" class="w-full max-w-[1140px] mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20 border-b border-[#E9E6E0] dark:border-[#2E2D29] fp-skills-section" aria-label="<?php esc_attr_e( 'Skills and Expertise', 'pixelpost' ); ?>" data-pixelpost-customize="skills" data-pixelpost-label="<?php esc_attr_e( 'Skills & Expertise', 'pixelpost' ); ?>">
	<!-- Section Header with Script Note on Right -->
	<div class="flex flex-col md:flex-row md:items-start justify-between mb-12 lg:mb-16 gap-6">
		<div class="flex flex-col max-w-2xl">
			<?php if ( ! empty( $pixelpost_eyebrow ) ) : ?>
				<div class="inline-flex items-center gap-2 mb-3">
					<span class="text-xs uppercase tracking-widest font-semibold text-[#A94F20] dark:text-[#D4733F]"><?php echo esc_html( $pixelpost_eyebrow ); ?></span>
					<span class="w-8 h-px bg-[#A94F20]/40"></span>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $pixelpost_heading ) ) : ?>
				<h2 class="font-serif text-3xl sm:text-4xl text-on-surface mb-3"><?php echo esc_html( $pixelpost_heading ); ?></h2>
			<?php endif; ?>

			<?php if ( ! empty( $pixelpost_subtitle ) ) : ?>
				<p class="text-base text-on-surface-variant leading-relaxed"><?php echo esc_html( $pixelpost_subtitle ); ?></p>
			<?php endif; ?>
		</div>

		<!-- Decorative Handwritten Note -->
		<div class="hidden md:flex flex-col items-center select-none pointer-events-none text-[#A94F20] dark:text-[#D4733F] font-script transform rotate-3 self-start mt-2 mr-4" aria-hidden="true">
			<span class="text-2xl leading-none">Keep</span>
			<span class="text-2xl leading-none italic">Learning</span>
			<span class="text-2xl leading-none">Always</span>
		</div>
	</div>

	<!-- 2-Column Categorized Layout -->
	<div class="grid grid-cols-1 md:grid-cols-2 gap-10 lg:gap-16 fp-skills-columns">
		<!-- Left Column -->
		<div class="space-y-8 sm:space-y-10 fp-skills-col-left">
			<?php foreach ( $left_col_items as $matrix ) :
				$title = ! empty( $matrix['title'] ) ? $matrix['title'] : '';
				$icon  = ! empty( $matrix['icon'] ) ? $matrix['icon'] : 'code';
				$tags  = ! empty( $matrix['tags'] ) ? $matrix['tags'] : '';
				if ( is_array( $tags ) ) {
					$tags = implode( ', ', $tags );
				}
			?>
				<div class="fp-skill-category">
					<div class="flex items-center gap-2.5 mb-2 text-primary">
						<?php echo pixelpost_get_icon( $icon, array( 'width' => 18, 'height' => 18 ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<h3 class="font-bold text-base sm:text-lg text-on-surface"><?php echo esc_html( $title ); ?></h3>
					</div>
					<p class="text-sm sm:text-base text-on-surface-variant leading-relaxed pl-7">
						<?php echo esc_html( $tags ); ?>
					</p>
				</div>
			<?php endforeach; ?>
		</div>

		<!-- Right Column -->
		<div class="space-y-8 sm:space-y-10 fp-skills-col-right">
			<?php foreach ( $right_col_items as $matrix ) :
				$title = ! empty( $matrix['title'] ) ? $matrix['title'] : '';
				$icon  = ! empty( $matrix['icon'] ) ? $matrix['icon'] : 'extension';
				$tags  = ! empty( $matrix['tags'] ) ? $matrix['tags'] : '';
				if ( is_array( $tags ) ) {
					$tags = implode( ', ', $tags );
				}
			?>
				<div class="fp-skill-category">
					<div class="flex items-center gap-2.5 mb-2 text-primary">
						<?php echo pixelpost_get_icon( $icon, array( 'width' => 18, 'height' => 18 ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<h3 class="font-bold text-base sm:text-lg text-on-surface"><?php echo esc_html( $title ); ?></h3>
					</div>
					<p class="text-sm sm:text-base text-on-surface-variant leading-relaxed pl-7">
						<?php echo esc_html( $tags ); ?>
					</p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
