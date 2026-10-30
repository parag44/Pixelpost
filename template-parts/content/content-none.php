<?php
/**
 * Empty State Content Template Part
 *
 * @package Pixelpost
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="fp-no-results fp-container fp-container-narrow">
	<header class="fp-page-header">
		<h1 class="fp-page-title"><?php esc_html_e( 'Nothing Found', 'pixelpost' ); ?></h1>
	</header>

	<div class="fp-page-content">
		<?php if ( is_search() ) : ?>
			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'pixelpost' ); ?></p>
			<?php get_search_form(); ?>
		<?php else : ?>
			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'pixelpost' ); ?></p>
			<?php get_search_form(); ?>
		<?php endif; ?>
	</div>
</section>
