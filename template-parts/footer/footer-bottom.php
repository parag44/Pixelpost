<?php
/**
 * Footer Bottom Template Part
 * Matches Google Stitch PRD: Brand + 2-Col Nav + Connect & Code + Status Pill
 *
 * @package Pixelpost
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$pixelpost_site_name = get_bloginfo( 'name' );
$pixelpost_monogram  = ! empty( $pixelpost_site_name ) ? mb_substr( $pixelpost_site_name, 0, 1 ) : 'P';

$pixelpost_footer_tagline = pixelpost_get_setting( 'pixelpost_footer_tagline' );
if ( empty( $pixelpost_footer_tagline ) ) {
	$pixelpost_footer_tagline = __( 'Dedicated WordPress Technical Support Engineer solving complex architecture bottlenecks, plugin conflicts, database corruptions, and performance issues with architectural precision.', 'pixelpost' );
}

$pixelpost_copyright_raw = pixelpost_get_setting( 'pixelpost_footer_copyright' );
if ( empty( $pixelpost_copyright_raw ) ) {
	$pixelpost_copyright_raw = '© {year} {sitename}. High-Rigor WordPress Infrastructure.';
}
$pixelpost_copyright = str_replace(
	array( '{year}', '{sitename}' ),
	array( gmdate( 'Y' ), $pixelpost_site_name ),
	$pixelpost_copyright_raw
);

$pixelpost_back_to_top_text = pixelpost_get_setting( 'pixelpost_footer_back_to_top_text' );
if ( empty( $pixelpost_back_to_top_text ) ) {
	$pixelpost_back_to_top_text = __( 'Back to top', 'pixelpost' );
}
$pixelpost_show_back_to_top = pixelpost_get_setting( 'pixelpost_footer_back_to_top_show' );
if ( null === $pixelpost_show_back_to_top || '' === $pixelpost_show_back_to_top ) {
	$pixelpost_show_back_to_top = true;
}

$pixelpost_show_footer_nav = pixelpost_get_setting( 'pixelpost_footer_nav_show' );
if ( null === $pixelpost_show_footer_nav || '' === $pixelpost_show_footer_nav ) {
	$pixelpost_show_footer_nav = true;
}

$pixelpost_footer_nav_title = pixelpost_get_setting( 'pixelpost_footer_nav_title' );
if ( empty( $pixelpost_footer_nav_title ) ) {
	$pixelpost_footer_nav_title = __( 'Navigation', 'pixelpost' );
}

$pixelpost_grid_class = $pixelpost_show_footer_nav
	? 'grid grid-cols-1 md:grid-cols-12 gap-space-lg mb-space-lg pb-space-lg fp-footer-grid'
	: 'flex flex-col md:flex-row items-start justify-between gap-space-lg mb-space-lg pb-space-lg fp-footer-grid fp-footer-no-nav';

$pixelpost_col1_class = $pixelpost_show_footer_nav
	? 'md:col-span-5 flex flex-col gap-space-sm fp-footer-col-brand'
	: 'flex flex-col gap-space-sm max-w-xl fp-footer-col-brand';

$pixelpost_col3_class = $pixelpost_show_footer_nav
	? 'md:col-span-3 flex flex-col gap-space-sm fp-footer-col-connect'
	: 'flex flex-col gap-space-sm fp-footer-col-connect';

$pixelpost_social_links = pixelpost_get_social_links();
?>
<div class="max-w-[1200px] mx-auto px-margin-mobile lg:px-margin py-space-xl fp-footer-container" data-pixelpost-customize="footer" data-pixelpost-label="<?php esc_attr_e( 'Footer Settings', 'pixelpost' ); ?>">
	<?php if ( pixelpost_get_setting( 'pixelpost_footer_widgets_show' ) && is_active_sidebar( 'footer-sidebar' ) ) : ?>
		<div class="fp-footer-widgets mb-space-lg pb-space-lg border-b border-surface-container-high/60">
			<?php dynamic_sidebar( 'footer-sidebar' ); ?>
		</div>
	<?php endif; ?>

	<div class="<?php echo esc_attr( $pixelpost_grid_class ); ?>">
		<!-- Col 1: Monogram & Bio -->
		<div class="<?php echo esc_attr( $pixelpost_col1_class ); ?>">
			<div class="flex items-center gap-space-sm">
				<div class="w-8 h-8 rounded-lg bg-surface-container-high flex items-center justify-center text-primary font-headline-sm text-headline-sm fp-footer-monogram">
					<?php echo esc_html( $pixelpost_monogram ); ?>
				</div>
				<span class="font-headline-sm text-headline-sm text-on-surface fp-footer-site-title"><?php echo esc_html( $pixelpost_site_name ); ?></span>
			</div>
			<?php if ( ! empty( $pixelpost_footer_tagline ) ) : ?>
				<p class="font-body-md text-body-md text-on-surface-variant max-w-sm fp-footer-tagline">
					<?php echo esc_html( $pixelpost_footer_tagline ); ?>
				</p>
			<?php endif; ?>
		</div>

		<?php if ( $pixelpost_show_footer_nav ) : ?>
		<!-- Col 2: Navigation (2 Columns) -->
		<div class="md:col-span-4 flex flex-col gap-space-xs fp-footer-col-nav" data-pixelpost-customize="footer-nav" data-pixelpost-label="<?php esc_attr_e( 'Footer Navigation', 'pixelpost' ); ?>">
			<span class="font-label-caps text-label-caps uppercase text-on-surface-variant tracking-wider fp-footer-nav-title"><?php echo esc_html( $pixelpost_footer_nav_title ); ?></span>
			<?php
			if ( has_nav_menu( 'footer' ) ) :
				wp_nav_menu(
					array(
						'theme_location' => 'footer',
						'menu_class'     => 'grid grid-cols-2 gap-space-xs list-none m-0 p-0 fp-footer-menu-grid',
						'container'      => false,
						'depth'          => 1,
						'fallback_cb'    => false,
					)
				);
			else :
				?>
				<div class="grid grid-cols-2 gap-space-xs list-none m-0 p-0 fp-footer-menu-grid">
					<a class="font-body-sm text-body-sm text-on-surface-variant hover:text-primary transition-colors" href="<?php echo esc_url( home_url( '/#about' ) ); ?>"><?php esc_html_e( 'About', 'pixelpost' ); ?></a>
					<a class="font-body-sm text-body-sm text-on-surface-variant hover:text-primary transition-colors" href="<?php echo esc_url( home_url( '/#skills' ) ); ?>"><?php esc_html_e( 'Technical Skills', 'pixelpost' ); ?></a>
					<a class="font-body-sm text-body-sm text-on-surface-variant hover:text-primary transition-colors" href="<?php echo esc_url( home_url( '/#experience' ) ); ?>"><?php esc_html_e( 'Experience', 'pixelpost' ); ?></a>
					<a class="font-body-sm text-body-sm text-on-surface-variant hover:text-primary transition-colors" href="<?php echo esc_url( home_url( '/#projects' ) ); ?>"><?php esc_html_e( 'Selected Work', 'pixelpost' ); ?></a>
					<a class="font-body-sm text-body-sm text-on-surface-variant hover:text-primary transition-colors" href="<?php echo esc_url( home_url( '/#blog' ) ); ?>"><?php esc_html_e( 'Knowledge Base', 'pixelpost' ); ?></a>
					<a class="font-body-sm text-body-sm text-on-surface-variant hover:text-primary transition-colors" href="<?php echo esc_url( home_url( '/#contact' ) ); ?>"><?php esc_html_e( 'Direct Inquiry', 'pixelpost' ); ?></a>
				</div>
				<?php
			endif;
			?>
		</div>
		<?php endif; ?>

		<!-- Col 3: Connect & Code -->
		<div class="<?php echo esc_attr( $pixelpost_col3_class ); ?>" data-pixelpost-customize="footer-social" data-pixelpost-label="<?php esc_attr_e( 'Social Profiles', 'pixelpost' ); ?>">
			<span class="font-label-caps text-label-caps uppercase text-on-surface-variant tracking-wider"><?php esc_html_e( 'Connect & Code', 'pixelpost' ); ?></span>
			<?php if ( ! empty( $pixelpost_social_links ) ) : ?>
				<div class="flex items-center gap-space-xs fp-social-icon-row">
					<?php
					foreach ( $pixelpost_social_links as $pixelpost_item ) :
						$pixelpost_url   = ! empty( $pixelpost_item['url'] ) ? $pixelpost_item['url'] : '';
						if ( empty( $pixelpost_url ) ) {
							continue;
						}
						$pixelpost_title   = ! empty( $pixelpost_item['title'] ) ? $pixelpost_item['title'] : 'Profile';
						$pixelpost_icon    = ! empty( $pixelpost_item['icon'] ) ? $pixelpost_item['icon'] : 'share';
						$pixelpost_aria    = ! empty( $pixelpost_item['label'] ) ? $pixelpost_item['label'] : $pixelpost_title;
						$pixelpost_is_mail = ( strpos( $pixelpost_url, 'mailto:' ) === 0 );
					?>
						<a aria-label="<?php echo esc_attr( $pixelpost_aria ); ?>" class="w-9 h-9 rounded-lg bg-surface-container flex items-center justify-center text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-colors fp-social-pill" href="<?php echo esc_url( $pixelpost_url ); ?>" <?php echo ! $pixelpost_is_mail ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>>
							<?php echo pixelpost_get_icon( $pixelpost_icon, array( 'width' => 18, 'height' => 18 ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>

	<!-- Bottom Row: Copyright + Back to Top Link -->
	<div class="pt-space-md border-t border-surface-container-high/40 flex flex-col sm:flex-row items-center justify-between gap-space-sm fp-footer-bottom-bar">
		<p class="font-body-sm text-body-sm text-on-surface-variant fp-copyright">
			<?php echo esc_html( $pixelpost_copyright ); ?>
		</p>
		<?php if ( $pixelpost_show_back_to_top && ! empty( $pixelpost_back_to_top_text ) ) : ?>
			<a href="#masthead" class="inline-flex items-center gap-1.5 font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors fp-back-to-top group" aria-label="<?php esc_attr_e( 'Back to top', 'pixelpost' ); ?>" data-pixelpost-customize="footer-back-to-top" data-pixelpost-label="<?php esc_attr_e( 'Back to Top', 'pixelpost' ); ?>">
				<span><?php echo esc_html( $pixelpost_back_to_top_text ); ?></span>
				<?php echo pixelpost_get_icon( 'arrow_upward', array( 'width' => 16, 'height' => 16, 'class' => 'group-hover:-translate-y-0.5 transition-transform' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</a>
		<?php endif; ?>
	</div>
</div>
