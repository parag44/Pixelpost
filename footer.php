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

<footer id="colophon" class="w-full border-t border-[#E9E6E0] dark:border-[#2E2D29] fp-site-footer">
	<?php get_template_part( 'template-parts/footer/footer-bottom' ); ?>
</footer>

<?php wp_footer(); ?>
</body>
</html>
