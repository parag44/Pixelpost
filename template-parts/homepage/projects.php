<?php
/**
 * Projects Section Template Part
 * Powered directly by Customizer Repeater (pixelpost_projects_items)
 * Matches Google Stitch Warm Editorial Craft Design
 *
 * @package Pixelpost
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$pixelpost_eyebrow       = pixelpost_get_setting( 'pixelpost_projects_eyebrow' );
$pixelpost_heading       = pixelpost_get_setting( 'pixelpost_projects_heading' );
$pixelpost_subtitle      = pixelpost_get_setting( 'pixelpost_projects_subtitle' );
$pixelpost_view_all_show = pixelpost_get_setting( 'pixelpost_projects_view_all_show' );
$pixelpost_view_all_text = pixelpost_get_setting( 'pixelpost_projects_view_all_text' );
$pixelpost_view_all_url  = pixelpost_get_setting( 'pixelpost_projects_view_all_url' );

// Retrieve projects from Customizer repeater (with fallback)
$pixelpost_projects = pixelpost_get_projects_items();
?>
<section id="projects" class="w-full max-w-[1200px] mx-auto px-margin-mobile lg:px-margin pt-space-xl pb-space-lg fp-projects-section" aria-label="<?php esc_attr_e( 'Plugins and Products', 'pixelpost' ); ?>" data-pixelpost-customize="projects" data-pixelpost-label="<?php esc_attr_e( 'Projects & Products', 'pixelpost' ); ?>">
	<div class="flex flex-col md:flex-row md:items-end justify-between mb-space-lg gap-space-sm">
		<div class="flex flex-col max-w-2xl">
			<?php if ( ! empty( $pixelpost_eyebrow ) ) : ?>
				<span class="font-label-caps text-label-caps uppercase text-primary tracking-wider mb-space-xs fp-eyebrow"><?php echo esc_html( $pixelpost_eyebrow ); ?></span>
			<?php endif; ?>

			<?php if ( ! empty( $pixelpost_heading ) ) : ?>
				<h2 class="font-headline-lg text-headline-lg text-on-surface fp-section-title"><?php echo esc_html( $pixelpost_heading ); ?></h2>
			<?php endif; ?>

			<?php if ( ! empty( $pixelpost_subtitle ) ) : ?>
				<p class="font-body-md text-body-md text-on-surface-variant mt-space-xs fp-section-subtitle"><?php echo esc_html( $pixelpost_subtitle ); ?></p>
			<?php endif; ?>
		</div>

		<?php if ( ! empty( $pixelpost_view_all_show ) && ! empty( $pixelpost_view_all_text ) ) : ?>
			<?php
			$pixelpost_cta_url = ! empty( $pixelpost_view_all_url ) ? $pixelpost_view_all_url : '#contact';
			?>
			<a class="inline-flex items-center gap-1 font-label-md text-label-md text-primary hover:text-primary-container font-semibold transition-colors group fp-projects-cta" href="<?php echo esc_url( $pixelpost_cta_url ); ?>">
				<span><?php echo esc_html( $pixelpost_view_all_text ); ?></span>
				<?php echo pixelpost_get_icon( 'arrow_forward', array( 'width' => 18, 'height' => 18, 'class' => 'group-hover:translate-x-1 transition-transform' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</a>
		<?php endif; ?>
	</div>

	<!-- Product Grid -->
	<div class="grid grid-cols-1 md:grid-cols-2 gap-space-md fp-projects-grid" data-pixelpost-customize="projects-grid" data-pixelpost-label="<?php esc_attr_e( 'Projects Grid', 'pixelpost' ); ?>">
		<?php
		foreach ( $pixelpost_projects as $pixelpost_item ) :
			$pixelpost_title       = ! empty( $pixelpost_item['title'] ) ? $pixelpost_item['title'] : __( 'Untitled Project', 'pixelpost' );
			$pixelpost_description = ! empty( $pixelpost_item['description'] ) ? $pixelpost_item['description'] : '';
			$pixelpost_url         = ! empty( $pixelpost_item['url'] ) ? $pixelpost_item['url'] : '#';
			$pixelpost_icon        = ! empty( $pixelpost_item['icon'] ) ? $pixelpost_item['icon'] : 'bug_report';
			$pixelpost_badge1      = ! empty( $pixelpost_item['badge1'] ) ? $pixelpost_item['badge1'] : '';
			$pixelpost_badge2      = ! empty( $pixelpost_item['badge2'] ) ? $pixelpost_item['badge2'] : '';
			$pixelpost_type_label  = ! empty( $pixelpost_item['type_label'] ) ? $pixelpost_item['type_label'] : __( 'Developer Utility', 'pixelpost' );
			$pixelpost_type_icon   = ! empty( $pixelpost_item['type_icon'] ) ? $pixelpost_item['type_icon'] : 'terminal';
			?>
			<div class="bg-surface-container-lowest rounded-xl p-space-md lg:p-space-lg shadow-sm hover:shadow-md transition-all flex flex-col justify-between group fp-project-card" data-pixelpost-customize="projects" data-pixelpost-label="<?php echo esc_attr( $pixelpost_title ); ?>">
				<div>
					<div class="flex items-center justify-between mb-space-md">
						<div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center text-primary group-hover:scale-105 transition-transform fp-project-icon-box">
							<?php echo pixelpost_get_icon( $pixelpost_icon, array( 'width' => 24, 'height' => 24 ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
						<div class="flex items-center gap-1.5">
							<?php if ( ! empty( $pixelpost_badge1 ) ) : ?>
								<span class="px-2 py-0.5 rounded-full bg-surface-container font-label-caps text-label-caps text-on-surface-variant"><?php echo esc_html( $pixelpost_badge1 ); ?></span>
							<?php endif; ?>
							<?php if ( ! empty( $pixelpost_badge2 ) ) : ?>
								<span class="px-2 py-0.5 rounded-full bg-primary-fixed text-on-primary-fixed font-label-caps text-label-caps font-bold"><?php echo esc_html( $pixelpost_badge2 ); ?></span>
							<?php endif; ?>
						</div>
					</div>
					<h3 class="font-headline-sm text-headline-sm text-on-surface group-hover:text-primary transition-colors mb-space-xs">
						<a href="<?php echo esc_url( $pixelpost_url ); ?>" <?php echo ( strpos( $pixelpost_url, 'http' ) === 0 ) ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>>
							<?php echo esc_html( $pixelpost_title ); ?>
						</a>
					</h3>
					<?php if ( ! empty( $pixelpost_description ) ) : ?>
						<p class="font-body-md text-body-md text-on-surface-variant mb-space-md leading-relaxed fp-project-desc">
							<?php echo esc_html( $pixelpost_description ); ?>
						</p>
					<?php endif; ?>
				</div>
				<div class="flex items-center justify-between pt-space-xs border-t border-surface-container-high/60 mt-auto">
					<div class="flex items-center gap-1.5 text-on-surface-variant font-body-sm text-body-sm">
						<?php echo pixelpost_get_icon( $pixelpost_type_icon, array( 'width' => 16, 'height' => 16 ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<span><?php echo esc_html( $pixelpost_type_label ); ?></span>
					</div>
					<?php
					/* translators: %s: project title */
					$pixelpost_proj_aria = sprintf( esc_html__( 'View project: %s', 'pixelpost' ), $pixelpost_title );
					?>
					<a class="inline-flex items-center gap-1 text-primary hover:text-primary-container font-label-md text-label-md font-semibold group/link" href="<?php echo esc_url( $pixelpost_url ); ?>" aria-label="<?php echo esc_attr( $pixelpost_proj_aria ); ?>" <?php echo ( strpos( $pixelpost_url, 'http' ) === 0 ) ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>>
						<span><?php esc_html_e( 'View Project', 'pixelpost' ); ?></span>
						<?php echo pixelpost_get_icon( 'arrow_forward', array( 'width' => 16, 'height' => 16, 'class' => 'group-hover/link:translate-x-1 transition-transform' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</a>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</section>
