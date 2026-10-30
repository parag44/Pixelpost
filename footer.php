<?php
/**
 * The template for displaying the footer
 *
 * @package Pixelpost
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
	</div><!-- .flex.flex-col.w-full -->
</main><!-- #primary-content -->

<footer id="colophon" class="w-full bg-surface-container-low shadow-[0_-1px_6px_rgba(0,0,0,0.02)] fp-site-footer">
	<?php get_template_part( 'template-parts/footer/footer-bottom' ); ?>
</footer>

<?php wp_footer(); ?>
</body>
</html>
