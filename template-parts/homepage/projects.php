<?php
/**
 * Projects Section Template Part
 * Matches Editorial Minimalism: 4-Column Project Showcase with Screenshots
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
<section id="projects" class="w-full max-w-[1140px] mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20 border-b border-[#E9E6E0] dark:border-[#2E2D29] fp-projects-section" aria-label="<?php esc_attr_e( 'Plugins and Products', 'pixelpost' ); ?>" data-pixelpost-customize="projects" data-pixelpost-label="<?php esc_attr_e( 'Projects & Products', 'pixelpost' ); ?>">
	<div class="flex flex-col sm:flex-row sm:items-end justify-between mb-12 lg:mb-16 gap-4">
		<div class="flex flex-col max-w-2xl">
			<?php if ( ! empty( $pixelpost_eyebrow ) ) : ?>
				<div class="inline-flex items-center gap-2 mb-3">
					<span class="text-xs uppercase tracking-widest font-semibold text-[#A94F20] dark:text-[#D4733F]"><?php echo esc_html( $pixelpost_eyebrow ); ?></span>
					<span class="w-8 h-px bg-[#A94F20]/40"></span>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $pixelpost_heading ) ) : ?>
				<h2 class="font-serif text-3xl sm:text-4xl text-on-surface"><?php echo esc_html( $pixelpost_heading ); ?></h2>
			<?php endif; ?>
		</div>

		<?php if ( ! empty( $pixelpost_view_all_show ) && ! empty( $pixelpost_view_all_text ) ) : ?>
			<?php
			$pixelpost_cta_url = ! empty( $pixelpost_view_all_url ) ? $pixelpost_view_all_url : '#projects';
			?>
			<a class="inline-flex items-center gap-1.5 text-sm font-medium text-[#A94F20] dark:text-[#D4733F] hover:underline transition-colors group fp-projects-cta" href="<?php echo esc_url( $pixelpost_cta_url ); ?>">
				<span><?php echo esc_html( $pixelpost_view_all_text ); ?></span>
				<?php echo pixelpost_get_icon( 'arrow_forward', array( 'width' => 14, 'height' => 14, 'class' => 'group-hover:translate-x-1 transition-transform' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</a>
		<?php endif; ?>
	</div>

	<!-- 4-Column Curated Project Showcase -->
	<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 fp-projects-grid" data-pixelpost-customize="projects-grid" data-pixelpost-label="<?php esc_attr_e( 'Projects Grid', 'pixelpost' ); ?>">
		<?php
		foreach ( $pixelpost_projects as $pixelpost_item ) :
			$pixelpost_title       = ! empty( $pixelpost_item['title'] ) ? $pixelpost_item['title'] : __( 'Untitled Project', 'pixelpost' );
			$pixelpost_description = ! empty( $pixelpost_item['description'] ) ? $pixelpost_item['description'] : '';
			$pixelpost_url         = ! empty( $pixelpost_item['url'] ) ? $pixelpost_item['url'] : '#';
			$pixelpost_image       = ! empty( $pixelpost_item['image'] ) ? $pixelpost_item['image'] : '';
			$pixelpost_badge1      = ! empty( $pixelpost_item['badge1'] ) ? $pixelpost_item['badge1'] : '';
			$pixelpost_badge2      = ! empty( $pixelpost_item['badge2'] ) ? $pixelpost_item['badge2'] : '';

			// Automatic fallback images for default projects if image is empty
			if ( empty( $pixelpost_image ) ) {
				$img_uri = get_template_directory_uri() . '/assets/images';
				if ( stripos( $pixelpost_title, 'debug' ) !== false ) {
					$pixelpost_image = $img_uri . '/project-debugzen.svg';
				} elseif ( stripos( $pixelpost_title, 'command' ) !== false ) {
					$pixelpost_image = $img_uri . '/project-wp-command.svg';
				} elseif ( stripos( $pixelpost_title, 'geo' ) !== false || stripos( $pixelpost_title, 'access' ) !== false ) {
					$pixelpost_image = $img_uri . '/project-geo-access.svg';
				} else {
					$pixelpost_image = $img_uri . '/project-boilerplate.svg';
				}
			}
			?>
			<div class="flex flex-col justify-between group fp-project-card" data-pixelpost-customize="projects" data-pixelpost-label="<?php echo esc_attr( $pixelpost_title ); ?>">
				<div class="flex flex-col">
					<!-- Prominent Project Screenshot / Image -->
					<div class="relative overflow-hidden rounded aspect-[16/10] w-full bg-[#F5F3EF] dark:bg-[#1E1D1B] border border-[#E9E6E0] dark:border-[#2E2D29] mb-4 fp-project-img-wrap">
						<a href="<?php echo esc_url( $pixelpost_url ); ?>" class="block w-full h-full" <?php echo ( strpos( $pixelpost_url, 'http' ) === 0 ) ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>>
							<img src="<?php echo esc_url( $pixelpost_image ); ?>" alt="<?php echo esc_attr( $pixelpost_title ); ?>" class="w-full h-full object-cover group-hover:scale-[1.03] transition-transform duration-500 fp-project-img" loading="lazy" />
						</a>
					</div>

					<!-- Project Title -->
					<h3 class="font-bold text-base sm:text-lg text-on-surface group-hover:text-primary transition-colors mb-2 fp-project-title">
						<a href="<?php echo esc_url( $pixelpost_url ); ?>" <?php echo ( strpos( $pixelpost_url, 'http' ) === 0 ) ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>>
							<?php echo esc_html( $pixelpost_title ); ?>
						</a>
					</h3>

					<!-- Short Description -->
					<?php if ( ! empty( $pixelpost_description ) ) : ?>
						<p class="text-xs sm:text-sm text-on-surface-variant leading-relaxed mb-4 fp-project-desc">
							<?php echo esc_html( $pixelpost_description ); ?>
						</p>
					<?php endif; ?>
				</div>

				<!-- Tags & Link -->
				<div class="pt-2 mt-auto">
					<div class="flex flex-wrap items-center gap-1.5 mb-2.5 fp-project-tags">
						<?php if ( ! empty( $pixelpost_badge1 ) ) : ?>
							<span class="px-2 py-0.5 rounded text-[11px] font-medium border border-[#E9E6E0] dark:border-[#2E2D29] text-on-surface-variant bg-surface"><?php echo esc_html( $pixelpost_badge1 ); ?></span>
						<?php endif; ?>
						<?php if ( ! empty( $pixelpost_badge2 ) ) : ?>
							<span class="px-2 py-0.5 rounded text-[11px] font-medium border border-[#E9E6E0] dark:border-[#2E2D29] text-[#A94F20] dark:text-[#D4733F] bg-[#F5EAE1]/50 dark:bg-[#2C1F17]/50"><?php echo esc_html( $pixelpost_badge2 ); ?></span>
						<?php endif; ?>
					</div>

					<a class="inline-flex items-center gap-1 text-xs font-semibold text-primary hover:underline group/link" href="<?php echo esc_url( $pixelpost_url ); ?>" <?php echo ( strpos( $pixelpost_url, 'http' ) === 0 ) ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>>
						<span><?php esc_html_e( 'View Project', 'pixelpost' ); ?></span>
						<span class="group-hover/link:translate-x-0.5 transition-transform">→</span>
					</a>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</section>
