<?php
/**
 * Skills Section Template Part
 * Matches Google Stitch PRD: Skill Matrices by Domain (4 Columns)
 *
 * @package Pixelpost
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$pixelpost_eyebrow       = pixelpost_get_setting( 'pixelpost_skills_eyebrow' );
$pixelpost_heading       = pixelpost_get_setting( 'pixelpost_skills_heading' );
$pixelpost_subtitle      = pixelpost_get_setting( 'pixelpost_skills_subtitle' );
$pixelpost_view_all_show = pixelpost_get_setting( 'pixelpost_skills_view_all_show' );
$pixelpost_view_all_text = pixelpost_get_setting( 'pixelpost_skills_view_all_text' );
$pixelpost_view_all_url  = pixelpost_get_setting( 'pixelpost_skills_view_all_url' );

$pixelpost_skills_items = pixelpost_get_skills_items();

if ( empty( $pixelpost_skills_items ) && empty( $pixelpost_heading ) ) {
	return;
}
?>
<section id="skills" class="w-full max-w-[1200px] mx-auto px-margin-mobile lg:px-margin pt-space-xl pb-space-lg fp-skills-section" aria-label="<?php esc_attr_e( 'Skills and Expertise', 'pixelpost' ); ?>" data-pixelpost-customize="skills" data-pixelpost-label="<?php esc_attr_e( 'Skills & Expertise', 'pixelpost' ); ?>">
	<div class="flex flex-col md:flex-row md:items-end justify-between mb-space-lg gap-space-sm">
		<div class="flex flex-col max-w-2xl">
			<?php if ( ! empty( $pixelpost_eyebrow ) ) : ?>
				<span class="font-label-caps text-label-caps uppercase text-primary tracking-wider mb-space-xs"><?php echo esc_html( $pixelpost_eyebrow ); ?></span>
			<?php endif; ?>

			<?php if ( ! empty( $pixelpost_heading ) ) : ?>
				<h2 class="font-headline-lg text-headline-lg text-on-surface"><?php echo esc_html( $pixelpost_heading ); ?></h2>
			<?php endif; ?>

			<?php if ( ! empty( $pixelpost_subtitle ) ) : ?>
				<p class="font-body-md text-body-md text-on-surface-variant mt-space-xs"><?php echo esc_html( $pixelpost_subtitle ); ?></p>
			<?php endif; ?>
		</div>

		<?php if ( ! empty( $pixelpost_view_all_show ) && ! empty( $pixelpost_view_all_text ) ) : ?>
			<?php
			$pixelpost_cta_url = ! empty( $pixelpost_view_all_url ) ? $pixelpost_view_all_url : '#experience';
			?>
			<a class="inline-flex items-center gap-1 font-label-md text-label-md text-primary hover:text-primary-container font-semibold transition-colors group fp-skills-cta" href="<?php echo esc_url( $pixelpost_cta_url ); ?>">
				<span><?php echo esc_html( $pixelpost_view_all_text ); ?></span>
				<?php echo pixelpost_get_icon( 'arrow_forward', array( 'width' => 18, 'height' => 18, 'class' => 'group-hover:translate-x-1 transition-transform' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</a>
		<?php endif; ?>
	</div>

	<!-- Skill Matrices by Domain -->
	<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-space-md fp-skills-grid" data-pixelpost-customize="skills-list" data-pixelpost-label="<?php esc_attr_e( 'Skills Matrix', 'pixelpost' ); ?>">
		<?php
		// Check if items are structured domain matrices (with title & tags)
		$pixelpost_first_item = reset( $pixelpost_skills_items );
		$pixelpost_is_matrix  = is_array( $pixelpost_first_item ) && isset( $pixelpost_first_item['tags'] );

		if ( $pixelpost_is_matrix ) :
			foreach ( $pixelpost_skills_items as $pixelpost_matrix ) :
				$pixelpost_title       = ! empty( $pixelpost_matrix['title'] ) ? $pixelpost_matrix['title'] : '';
				$pixelpost_icon        = ! empty( $pixelpost_matrix['icon'] ) ? $pixelpost_matrix['icon'] : 'code';
				$pixelpost_badge_label = ! empty( $pixelpost_matrix['badge_label'] ) ? $pixelpost_matrix['badge_label'] : __( 'Proficiency', 'pixelpost' );
				$pixelpost_badge_value = ! empty( $pixelpost_matrix['badge_value'] ) ? $pixelpost_matrix['badge_value'] : __( 'Mastery', 'pixelpost' );
				$pixelpost_raw_tags    = ! empty( $pixelpost_matrix['tags'] ) ? $pixelpost_matrix['tags'] : '';
				$pixelpost_tags_arr    = is_array( $pixelpost_raw_tags ) ? $pixelpost_raw_tags : array_map( 'trim', explode( ',', $pixelpost_raw_tags ) );
				?>
				<div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm flex flex-col justify-between fp-skill-card">
					<div>
						<div class="flex items-center gap-2 mb-space-sm text-primary">
							<?php echo pixelpost_get_icon( $pixelpost_icon, array( 'width' => 20, 'height' => 20 ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							<span class="font-label-caps text-label-caps uppercase tracking-wider text-on-surface font-bold"><?php echo esc_html( $pixelpost_title ); ?></span>
						</div>
						<div class="flex flex-wrap gap-2">
							<?php foreach ( $pixelpost_tags_arr as $pixelpost_tag ) : ?>
								<?php if ( ! empty( $pixelpost_tag ) ) : ?>
									<span class="px-space-xs py-1 rounded-full bg-surface-container-low text-on-surface font-label-md text-label-md fp-skill-pill"><?php echo esc_html( $pixelpost_tag ); ?></span>
								<?php endif; ?>
							<?php endforeach; ?>
						</div>
					</div>
					<div class="mt-space-md pt-space-xs border-t border-surface-container-high/40 flex items-center justify-between text-on-surface-variant font-body-sm text-body-sm">
						<span><?php echo esc_html( $pixelpost_badge_label ); ?></span>
						<span class="font-semibold text-primary"><?php echo esc_html( $pixelpost_badge_value ); ?></span>
					</div>
				</div>
				<?php
			endforeach;
		else :
			// Fallback: render individual skill badges in card format
			?>
			<div class="col-span-full bg-surface-container-lowest rounded-xl p-space-md lg:p-space-lg shadow-sm">
				<div class="flex flex-wrap gap-2">
					<?php foreach ( $pixelpost_skills_items as $pixelpost_item ) : ?>
						<?php
						$pixelpost_skill_name = is_array( $pixelpost_item ) ? ( ! empty( $pixelpost_item['name'] ) ? $pixelpost_item['name'] : ( ! empty( $pixelpost_item['title'] ) ? $pixelpost_item['title'] : '' ) ) : $pixelpost_item;
						if ( empty( $pixelpost_skill_name ) ) {
							continue;
						}
						?>
						<span class="px-space-xs py-1.5 rounded-full bg-surface-container-low text-on-surface font-label-md text-label-md fp-skill-pill">
							<?php echo esc_html( $pixelpost_skill_name ); ?>
						</span>
					<?php endforeach; ?>
				</div>
			</div>
			<?php
		endif;
		?>
	</div>
</section>
