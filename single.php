<?php
/**
 * The template for displaying all single posts
 *
 * @package Pixelpost
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="w-full max-w-[1200px] mx-auto px-margin-mobile lg:px-margin pt-space-xl pb-space-xxl fp-single-post-wrapper">
	<?php
	while ( have_posts() ) :
		the_post();

		get_template_part( 'template-parts/content/content-single' );

		// Post Navigation (Previous / Next Article Cards)
		$pixelpost_prev_post = get_previous_post();
		$pixelpost_next_post = get_next_post();
		if ( $pixelpost_prev_post || $pixelpost_next_post ) :
			?>
			<div class="max-w-[760px] mx-auto mt-space-xl grid grid-cols-1 sm:grid-cols-2 gap-space-md fp-post-navigation">
				<?php if ( $pixelpost_prev_post ) : ?>
					<a href="<?php echo esc_url( get_permalink( $pixelpost_prev_post->ID ) ); ?>" class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm border border-outline-variant/40 hover:shadow-md transition-all flex flex-col justify-between group">
						<span class="font-label-caps text-label-caps uppercase text-primary flex items-center gap-1 mb-1">
							<?php echo pixelpost_get_icon( 'arrow_back', array( 'width' => 14, 'height' => 14 ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							<?php esc_html_e( 'Previous Article', 'pixelpost' ); ?>
						</span>
						<h4 class="font-headline-sm text-headline-sm text-on-surface group-hover:text-primary transition-colors line-clamp-2"><?php echo esc_html( get_the_title( $pixelpost_prev_post->ID ) ); ?></h4>
						<span class="font-body-sm text-body-sm text-on-surface-variant mt-2"><?php echo esc_html( get_the_date( 'M j, Y', $pixelpost_prev_post->ID ) ); ?></span>
					</a>
				<?php else : ?>
					<div></div>
				<?php endif; ?>

				<?php if ( $pixelpost_next_post ) : ?>
					<a href="<?php echo esc_url( get_permalink( $pixelpost_next_post->ID ) ); ?>" class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm border border-outline-variant/40 hover:shadow-md transition-all flex flex-col justify-between text-right group">
						<span class="font-label-caps text-label-caps uppercase text-primary flex items-center justify-end gap-1 mb-1">
							<?php esc_html_e( 'Next Article', 'pixelpost' ); ?>
							<?php echo pixelpost_get_icon( 'arrow_forward', array( 'width' => 14, 'height' => 14 ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</span>
						<h4 class="font-headline-sm text-headline-sm text-on-surface group-hover:text-primary transition-colors line-clamp-2"><?php echo esc_html( get_the_title( $pixelpost_next_post->ID ) ); ?></h4>
						<span class="font-body-sm text-body-sm text-on-surface-variant mt-2"><?php echo esc_html( get_the_date( 'M j, Y', $pixelpost_next_post->ID ) ); ?></span>
					</a>
				<?php endif; ?>
			</div>
			<?php
		endif;

		// Comments
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;

	endwhile;
	?>
</div>

<?php
get_footer();
