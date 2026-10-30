<?php
/**
 * The template for displaying search results pages
 *
 * @package Pixelpost
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="fp-page-header">
	<div class="fp-container">
		<div class="fp-eyebrow"><?php esc_html_e( 'SEARCH RESULTS', 'pixelpost' ); ?></div>
		<h1 class="fp-page-title">
			<?php
			/* translators: %s: search query. */
			printf( esc_html__( 'Results for: %s', 'pixelpost' ), '<span>' . esc_html( get_search_query() ) . '</span>' );
			?>
		</h1>
	</div>
</div>

<div class="fp-container" style="padding-bottom: var(--fp-section-spacing);">
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
