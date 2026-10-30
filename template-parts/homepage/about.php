<?php
/**
 * About Section Template Part
 * Matches Editorial Minimalism: Two-column layout (Left Portrait + Right Narrative & 3 Attributes + Script Note)
 *
 * @package Pixelpost
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$pixelpost_eyebrow = pixelpost_get_setting( 'pixelpost_about_eyebrow' );
$pixelpost_heading = pixelpost_get_setting( 'pixelpost_about_heading' );
$pixelpost_content = pixelpost_get_setting( 'pixelpost_about_text' );
$pixelpost_image   = pixelpost_get_setting( 'pixelpost_about_image' );

if ( empty( $pixelpost_image ) || false !== strpos( $pixelpost_image, 'DSCF5599' ) || false !== strpos( $pixelpost_image, 'developer-about' ) ) {
	$pixelpost_image = get_template_directory_uri() . '/assets/images/developer-hero.jpg';
}

$pixelpost_author_name = pixelpost_get_setting( 'pixelpost_hero_accent' );
if ( empty( $pixelpost_author_name ) ) {
	$pixelpost_author_name = 'Parag Das';
}

$pixelpost_about_bullets = pixelpost_get_about_bullets();

if ( empty( $pixelpost_heading ) && empty( $pixelpost_content ) ) {
	return;
}
?>
<section id="about" class="w-full max-w-[1140px] mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20 border-b border-[#E9E6E0] dark:border-[#2E2D29] fp-about-section" aria-label="<?php esc_attr_e( 'About Me', 'pixelpost' ); ?>" data-pixelpost-customize="about" data-pixelpost-label="<?php esc_attr_e( 'About Me Section', 'pixelpost' ); ?>">
	<div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-center">
		<!-- Left: Portrait with subtle offset composition -->
		<div class="lg:col-span-5 flex justify-center lg:justify-start fp-about-image-col">
			<div class="relative w-full max-w-[340px] sm:max-w-[360px] fp-about-img-box">
				<!-- Decorative terracotta circular / offset accent -->
				<div class="absolute -top-3 -right-3 w-12 h-12 rounded-full bg-[#A94F20] dark:bg-[#D4733F] opacity-80 -z-10" aria-hidden="true"></div>
				<div class="absolute -inset-2 bg-[#F5EAE1] dark:bg-[#2C1F17] rounded -z-10 translate-x-2 translate-y-2" aria-hidden="true"></div>

				<div class="relative rounded overflow-hidden border border-[#E9E6E0] dark:border-[#2E2D29] bg-[#FAF9F6] dark:bg-[#161514] aspect-[4/3] w-full">
					<?php
					echo pixelpost_render_optimized_image(
						$pixelpost_image,
						array(
							'class'    => 'w-full h-full object-cover object-top hover:scale-[1.02] transition-transform duration-700 fp-about-img',
							'alt'      => $pixelpost_author_name,
							'loading'  => 'lazy',
							'decoding' => 'async',
							'width'    => 600,
							'height'   => 750,
						)
					); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					?>
				</div>
			</div>
		</div>

		<!-- Right: Narrative, Script Note & 3 Key Attributes -->
		<div class="lg:col-span-7 flex flex-col fp-about-content-col relative">
			<!-- Handwritten Script Note top-right -->
			<div class="hidden sm:flex flex-col items-center select-none pointer-events-none text-[#A94F20] dark:text-[#D4733F] font-script transform rotate-3 absolute -top-4 right-0" aria-hidden="true">
				<span class="text-xl sm:text-2xl leading-tight">Same</span>
				<span class="text-xl sm:text-2xl leading-tight italic">Passion</span>
				<span class="text-xl sm:text-2xl leading-tight">New Problems</span>
			</div>

			<?php if ( ! empty( $pixelpost_eyebrow ) ) : ?>
				<div class="inline-flex items-center gap-2 mb-3">
					<span class="text-xs uppercase tracking-widest font-semibold text-[#A94F20] dark:text-[#D4733F]"><?php echo esc_html( $pixelpost_eyebrow ); ?></span>
					<span class="w-8 h-px bg-[#A94F20]/40"></span>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $pixelpost_heading ) ) : ?>
				<h2 class="font-serif text-2xl sm:text-3xl lg:text-4xl text-on-surface mb-4 leading-snug fp-about-heading" data-pixelpost-customize="about-heading" data-pixelpost-label="<?php esc_attr_e( 'About Heading', 'pixelpost' ); ?>">
					<?php echo esc_html( $pixelpost_heading ); ?>
				</h2>
			<?php endif; ?>

			<?php if ( ! empty( $pixelpost_content ) ) : ?>
				<div class="font-body text-sm sm:text-base text-on-surface-variant leading-relaxed mb-8 fp-about-content" data-pixelpost-customize="about-text" data-pixelpost-label="<?php esc_attr_e( 'About Story', 'pixelpost' ); ?>">
					<?php echo wp_kses_post( wpautop( $pixelpost_content ) ); ?>
				</div>
			<?php endif; ?>

			<!-- 3 Key Attributes -->
			<div class="grid grid-cols-1 sm:grid-cols-3 gap-6 pt-6 border-t border-[#E9E6E0] dark:border-[#2E2D29] fp-about-attributes">
				<?php
				$default_attrs = array(
					array(
						'title' => __( 'Problem Solver', 'pixelpost' ),
						'desc'  => __( 'Enjoy complex challenges.', 'pixelpost' ),
						'icon'  => 'verified',
					),
					array(
						'title' => __( 'Detail Oriented', 'pixelpost' ),
						'desc'  => __( 'Quality in everything.', 'pixelpost' ),
						'icon'  => 'tune',
					),
					array(
						'title' => __( 'Team Player', 'pixelpost' ),
						'desc'  => __( 'Believe in collaboration.', 'pixelpost' ),
						'icon'  => 'chat',
					),
				);

				$attrs = ! empty( $pixelpost_about_bullets ) && isset( $pixelpost_about_bullets[0]['title'] )
					? $pixelpost_about_bullets
					: $default_attrs;

				foreach ( $attrs as $attr ) :
					$a_title = ! empty( $attr['title'] ) ? $attr['title'] : ( is_string( $attr ) ? $attr : '' );
					$a_desc  = ! empty( $attr['desc'] ) ? $attr['desc'] : '';
					$a_icon  = ! empty( $attr['icon'] ) ? $attr['icon'] : 'verified';
					if ( empty( $a_title ) ) {
						continue;
					}
				?>
					<div class="flex flex-col items-start fp-about-attr-item">
						<div class="w-8 h-8 rounded flex items-center justify-center text-primary mb-2">
							<?php echo pixelpost_get_icon( $a_icon, array( 'width' => 20, 'height' => 20 ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
						<h3 class="font-bold text-sm sm:text-base text-on-surface mb-1"><?php echo esc_html( $a_title ); ?></h3>
						<?php if ( ! empty( $a_desc ) ) : ?>
							<p class="text-xs sm:text-sm text-on-surface-variant leading-relaxed"><?php echo esc_html( $a_desc ); ?></p>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
