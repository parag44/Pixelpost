<?php
/**
 * Footer Bottom Template Part
 * Matches Editorial Minimalism: Minimal 3-Part Footer (Brand & Bio | Center Nav | Social Links) + Copyright & Back to Top
 *
 * @package Pixelpost
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$pixelpost_site_name = get_bloginfo( 'name' );
if ( empty( $pixelpost_site_name ) ) {
	$pixelpost_site_name = 'Parag Das';
}
$pixelpost_monogram  = mb_substr( $pixelpost_site_name, 0, 1 );

$pixelpost_footer_tagline = pixelpost_get_setting( 'pixelpost_footer_tagline' );
if ( empty( $pixelpost_footer_tagline ) ) {
	$pixelpost_footer_tagline = __( 'WordPress specialist focused on troubleshooting, quality, and better web experiences.', 'pixelpost' );
}

$pixelpost_copyright_raw = pixelpost_get_setting( 'pixelpost_footer_copyright' );
if ( empty( $pixelpost_copyright_raw ) ) {
	$pixelpost_copyright_raw = '© {year} {sitename}. All rights reserved.';
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

$pixelpost_social_links = pixelpost_get_social_links();
?>
<div class="max-w-[1140px] mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-12 fp-footer-container" data-pixelpost-customize="footer" data-pixelpost-label="<?php esc_attr_e( 'Footer Settings', 'pixelpost' ); ?>">
	<?php if ( pixelpost_get_setting( 'pixelpost_footer_widgets_show' ) && is_active_sidebar( 'footer-sidebar' ) ) : ?>
		<div class="fp-footer-widgets mb-10 pb-8 border-b border-[#E9E6E0] dark:border-[#2E2D29]">
			<?php dynamic_sidebar( 'footer-sidebar' ); ?>
		</div>
	<?php endif; ?>

	<!-- Top Row: Brand & Tagline | Horizontal Nav | Social Links -->
	<div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8 pb-12 fp-footer-top-row">
		<!-- Left: Monogram, Name & Tagline -->
		<div class="flex flex-col max-w-sm fp-footer-col-brand">
			<a class="flex items-center gap-2 mb-2 group" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<span class="font-serif font-bold text-2xl text-primary leading-none group-hover:scale-105 transition-transform fp-brand-initial"><?php echo esc_html( $pixelpost_monogram ); ?></span>
				<span class="font-serif text-lg font-bold text-on-surface tracking-tight leading-none fp-site-title-text"><?php echo esc_html( $pixelpost_site_name ); ?></span>
			</a>
			<?php if ( ! empty( $pixelpost_footer_tagline ) ) : ?>
				<p class="text-xs sm:text-[13px] text-on-surface-variant leading-relaxed fp-footer-tagline">
					<?php echo esc_html( $pixelpost_footer_tagline ); ?>
				</p>
			<?php endif; ?>
		</div>

		<!-- Center: Navigation Links -->
		<nav class="flex flex-wrap items-center gap-x-7 gap-y-2.5 fp-footer-col-nav" aria-label="<?php esc_attr_e( 'Footer Navigation', 'pixelpost' ); ?>" data-pixelpost-customize="footer-nav" data-pixelpost-label="<?php esc_attr_e( 'Footer Navigation', 'pixelpost' ); ?>">
			<?php
			if ( has_nav_menu( 'footer' ) ) :
				wp_nav_menu(
					array(
						'theme_location' => 'footer',
						'menu_class'     => 'flex flex-wrap items-center gap-x-7 gap-y-2.5 list-none m-0 p-0',
						'container'      => false,
						'depth'          => 1,
						'fallback_cb'    => false,
					)
				);
			else :
				?>
				<a class="text-xs sm:text-[13px] font-medium text-on-surface-variant hover:text-primary transition-colors" href="<?php echo esc_url( home_url( '/#about' ) ); ?>"><?php esc_html_e( 'About', 'pixelpost' ); ?></a>
				<a class="text-xs sm:text-[13px] font-medium text-on-surface-variant hover:text-primary transition-colors" href="<?php echo esc_url( home_url( '/#skills' ) ); ?>"><?php esc_html_e( 'Skills', 'pixelpost' ); ?></a>
				<a class="text-xs sm:text-[13px] font-medium text-on-surface-variant hover:text-primary transition-colors" href="<?php echo esc_url( home_url( '/#experience' ) ); ?>"><?php esc_html_e( 'Experience', 'pixelpost' ); ?></a>
				<a class="text-xs sm:text-[13px] font-medium text-on-surface-variant hover:text-primary transition-colors" href="<?php echo esc_url( home_url( '/#projects' ) ); ?>"><?php esc_html_e( 'Projects', 'pixelpost' ); ?></a>
				<a class="text-xs sm:text-[13px] font-medium text-on-surface-variant hover:text-primary transition-colors" href="<?php echo esc_url( home_url( '/#blog' ) ); ?>"><?php esc_html_e( 'Articles', 'pixelpost' ); ?></a>
				<a class="text-xs sm:text-[13px] font-medium text-on-surface-variant hover:text-primary transition-colors" href="<?php echo esc_url( home_url( '/#contact' ) ); ?>"><?php esc_html_e( 'Contact', 'pixelpost' ); ?></a>
				<?php
			endif;
			?>
		</nav>

		<!-- Right: Social Links -->
		<div class="flex items-center gap-4 fp-footer-col-connect" data-pixelpost-customize="footer-social" data-pixelpost-label="<?php esc_attr_e( 'Social Profiles', 'pixelpost' ); ?>">
			<?php if ( ! empty( $pixelpost_social_links ) ) : ?>
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
					<a aria-label="<?php echo esc_attr( $pixelpost_aria ); ?>" class="text-on-surface-variant hover:text-primary transition-colors p-1" href="<?php echo esc_url( $pixelpost_url ); ?>" <?php echo ! $pixelpost_is_mail ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>>
						<?php echo pixelpost_get_icon( $pixelpost_icon, array( 'width' => 18, 'height' => 18 ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</a>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>

	<!-- Bottom Row: Copyright + Back to Top Link -->
	<div class="pt-8 border-t border-[#E9E6E0] dark:border-[#2E2D29] flex flex-col sm:flex-row items-center justify-between gap-4 fp-footer-bottom-bar">
		<p class="text-xs text-on-surface-variant fp-copyright">
			<?php echo esc_html( $pixelpost_copyright ); ?>
		</p>
		<a href="#masthead" class="inline-flex items-center gap-1 text-xs text-on-surface-variant hover:text-primary transition-colors fp-back-to-top group" aria-label="<?php esc_attr_e( 'Back to top', 'pixelpost' ); ?>">
			<span><?php echo esc_html( $pixelpost_back_to_top_text ); ?></span>
			<span class="group-hover:-translate-y-0.5 transition-transform">↑</span>
		</a>
	</div>
</div>
