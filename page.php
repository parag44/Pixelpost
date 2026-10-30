<?php
/**
 * The template for displaying all pages
 *
 * @package Pixelpost
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	get_template_part( 'template-parts/content/content-page' );

	if ( comments_open() || get_comments_number() ) :
		?>
		<div class="fp-container fp-container-narrow">
			<?php comments_template(); ?>
		</div>
		<?php
	endif;

endwhile;

get_footer();
