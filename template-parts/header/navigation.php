<?php
/**
 * Navigation Header Part
 * Matches Editorial Minimalism
 *
 * @package Pixelpost
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<nav id="site-navigation" class="lg:flex items-center gap-6 fp-main-navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'pixelpost' ); ?>" data-pixelpost-customize="navigation" data-pixelpost-label="<?php esc_attr_e( 'Navigation Menu', 'pixelpost' ); ?>">
	<?php
	if ( has_nav_menu( 'primary' ) ) :
		wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'menu_id'        => 'primary-menu',
				'menu_class'     => 'flex flex-col lg:flex-row items-start lg:items-center gap-5 lg:gap-7 fp-nav-menu',
				'container'      => false,
				'fallback_cb'    => false,
			)
		);
	else :
		?>
		<ul id="primary-menu" class="flex flex-col lg:flex-row items-start lg:items-center gap-5 lg:gap-7 fp-nav-menu">
			<li class="menu-item"><a class="text-sm font-medium text-on-surface-variant hover:text-primary transition-colors" href="<?php echo esc_url( home_url( '/#about' ) ); ?>"><?php esc_html_e( 'About', 'pixelpost' ); ?></a></li>
			<li class="menu-item"><a class="text-sm font-medium text-on-surface-variant hover:text-primary transition-colors" href="<?php echo esc_url( home_url( '/#skills' ) ); ?>"><?php esc_html_e( 'Skills', 'pixelpost' ); ?></a></li>
			<li class="menu-item"><a class="text-sm font-medium text-on-surface-variant hover:text-primary transition-colors" href="<?php echo esc_url( home_url( '/#experience' ) ); ?>"><?php esc_html_e( 'Experience', 'pixelpost' ); ?></a></li>
			<li class="menu-item"><a class="text-sm font-medium text-on-surface-variant hover:text-primary transition-colors" href="<?php echo esc_url( home_url( '/#projects' ) ); ?>"><?php esc_html_e( 'Projects', 'pixelpost' ); ?></a></li>
			<li class="menu-item"><a class="text-sm font-medium text-on-surface-variant hover:text-primary transition-colors" href="<?php echo esc_url( home_url( '/#blog' ) ); ?>"><?php esc_html_e( 'Articles', 'pixelpost' ); ?></a></li>
			<li class="menu-item"><a class="text-sm font-medium text-on-surface-variant hover:text-primary transition-colors" href="<?php echo esc_url( home_url( '/#contact' ) ); ?>"><?php esc_html_e( 'Contact', 'pixelpost' ); ?></a></li>
		</ul>
		<?php
	endif;
	?>
	<div class="lg:hidden mt-6 pt-6 border-t border-[#E9E6E0] dark:border-[#2E2D29] flex flex-col gap-3 w-full">
		<a href="<?php echo esc_url( home_url( '/#contact' ) ); ?>" class="fp-mobile-talk-btn inline-flex items-center justify-center gap-2 w-full py-3.5 px-5 rounded-md bg-[#A94F20] hover:bg-[#8C3E16] text-white font-semibold text-sm transition-all shadow-sm">
			<span class="text-white font-semibold"><?php esc_html_e( "Let's Talk", "pixelpost" ); ?></span>
			<?php echo pixelpost_get_icon( 'arrow_forward', array( 'width' => 16, 'height' => 16, 'class' => 'text-white' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</a>
	</div>
</nav>
