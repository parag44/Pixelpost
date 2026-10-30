<?php
/**
 * The main template file
 *
 * @package Pixelpost
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="fp-container" style="padding-top: var(--fp-section-spacing); padding-bottom: var(--fp-section-spacing);">
	<?php if ( have_posts() ) : ?>
		<div class="fp-posts-grid">
			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content/content' );
			endwhile;
			?>
		</div>

		<?php pixelpost_the_posts_navigation(); ?>

	<?php else : ?>
		<?php get_template_part( 'template-parts/content/content-none' ); ?>
	<?php endif; ?>
</div>

<?php
get_footer();
