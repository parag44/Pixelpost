<?php
/**
 * Page Template Part
 *
 * @package Pixelpost
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'fp-page-article' ); ?>>
	<header class="fp-page-header">
		<div class="fp-container fp-container-narrow">
			<h1 class="fp-page-title"><?php the_title(); ?></h1>
		</div>
	</header>

	<div class="fp-container">
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="fp-featured-media fp-container-narrow">
				<?php the_post_thumbnail( 'large' ); ?>
			</div>
		<?php endif; ?>

		<div class="fp-article-content">
			<?php
			the_content();

			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'pixelpost' ),
					'after'  => '</div>',
				)
			);
			?>
		</div>
	</div>
</article>
