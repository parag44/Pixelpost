<?php
/**
 * Blog Archive Post Item Template Part (Editorial Layout)
 *
 * Matches the Pixelpost minimal editorial list layout:
 * - Upper date eyebrow (e.g. JUNE 8, 2026)
 * - Dark serif title
 * - Clean excerpt
 * - Square right thumbnail (if post has thumbnail)
 * - Thin divider separator
 *
 * @package Pixelpost
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'fp-archive-article' ); ?>>
	<div class="fp-archive-article-inner">
		<div class="fp-archive-article-content">
			<div class="fp-archive-article-date">
				<?php echo esc_html( get_the_date( 'F j, Y' ) ); ?>
			</div>

			<h2 class="fp-archive-article-title">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h2>

			<?php
			$pixelpost_excerpt = get_the_excerpt();
			if ( ! empty( $pixelpost_excerpt ) ) :
				?>
				<div class="fp-archive-article-excerpt">
					<p><?php echo esc_html( wp_strip_all_tags( $pixelpost_excerpt ) ); ?></p>
				</div>
			<?php endif; ?>
		</div>

		<?php if ( has_post_thumbnail() ) : ?>
			<div class="fp-archive-article-thumb">
				<a href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
					<?php the_post_thumbnail( 'thumbnail', array( 'class' => 'fp-archive-thumb-img' ) ); ?>
				</a>
			</div>
		<?php endif; ?>
	</div>
</article>
