<?php
/**
 * Navigation Header Part
 * Matches Google Stitch PRD
 *
 * @package Pixelpost
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<button class="pixelpost-menu-toggle fp-menu-toggle lg:hidden" aria-controls="site-navigation" aria-expanded="false" aria-label="<?php esc_attr_e( 'Open navigation menu', 'pixelpost' ); ?>">
	<?php echo pixelpost_get_icon( 'menu', array( 'width' => 24, 'height' => 24 ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
</button>

<nav id="site-navigation" class="lg:flex items-center gap-space-lg fp-main-navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'pixelpost' ); ?>" data-pixelpost-customize="navigation" data-pixelpost-label="<?php esc_attr_e( 'Navigation Menu', 'pixelpost' ); ?>">
	<div class="pixelpost-mobile-nav-header lg:hidden">
		<span class="pixelpost-mobile-nav-title"><?php esc_html_e( 'Navigation', 'pixelpost' ); ?></span>
		<button class="pixelpost-menu-close" aria-label="<?php esc_attr_e( 'Close navigation menu', 'pixelpost' ); ?>">
			<?php echo pixelpost_get_icon( 'close', array( 'width' => 20, 'height' => 20 ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<span class="screen-reader-text"><?php esc_html_e( 'Close navigation menu', 'pixelpost' ); ?></span>
		</button>
	</div>
	<?php
	if ( has_nav_menu( 'primary' ) ) :
		wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'menu_id'        => 'primary-menu',
				'menu_class'     => 'flex items-center gap-space-lg fp-nav-menu',
				'container'      => false,
				'fallback_cb'    => false,
			)
		);
	else :
		?>
		<ul id="primary-menu" class="flex items-center gap-space-lg fp-nav-menu">
			<li class="menu-item"><a class="font-label-md text-label-md text-on-surface-variant hover:text-on-surface transition-colors" href="<?php echo esc_url( home_url( '/#about' ) ); ?>"><?php esc_html_e( 'About', 'pixelpost' ); ?></a></li>
			<li class="menu-item"><a class="font-label-md text-label-md text-on-surface-variant hover:text-on-surface transition-colors" href="<?php echo esc_url( home_url( '/#skills' ) ); ?>"><?php esc_html_e( 'Skills', 'pixelpost' ); ?></a></li>
			<li class="menu-item"><a class="font-label-md text-label-md text-on-surface-variant hover:text-on-surface transition-colors" href="<?php echo esc_url( home_url( '/#experience' ) ); ?>"><?php esc_html_e( 'Experience', 'pixelpost' ); ?></a></li>
			<li class="menu-item"><a class="font-label-md text-label-md text-on-surface-variant hover:text-on-surface transition-colors" href="<?php echo esc_url( home_url( '/#projects' ) ); ?>"><?php esc_html_e( 'Projects', 'pixelpost' ); ?></a></li>
			<li class="menu-item"><a class="font-label-md text-label-md text-on-surface-variant hover:text-on-surface transition-colors" href="<?php echo esc_url( home_url( '/#blog' ) ); ?>"><?php esc_html_e( 'Articles', 'pixelpost' ); ?></a></li>
			<li class="menu-item"><a class="font-label-md text-label-md text-on-surface-variant hover:text-on-surface transition-colors" href="<?php echo esc_url( home_url( '/#contact' ) ); ?>"><?php esc_html_e( 'Contact', 'pixelpost' ); ?></a></li>
		</ul>
		<?php
	endif;
	?>
</nav>
