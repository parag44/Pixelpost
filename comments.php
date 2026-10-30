<?php
/**
 * The template for displaying comments
 * Matches Stitch Warm Editorial Craft Design
 *
 * @package Pixelpost
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="max-w-[760px] mx-auto mt-space-xl fp-comments-area">
	<?php if ( have_comments() ) : ?>
		<div class="mb-space-lg pb-space-xs border-b border-surface-container-high/60">
			<h3 class="font-headline-md text-headline-md text-on-surface">
				<?php
				$pixelpost_comment_count = get_comments_number();
				if ( '1' === $pixelpost_comment_count ) {
					printf(
						/* translators: 1: title. */
						esc_html__( '1 Thought on &ldquo;%1$s&rdquo;', 'pixelpost' ),
						'<span>' . wp_kses_post( get_the_title() ) . '</span>'
					);
				} else {
					printf(
						/* translators: 1: comment count number, 2: title. */
						esc_html( _nx( '%1$s Thought on &ldquo;%2$s&rdquo;', '%1$s Thoughts on &ldquo;%2$s&rdquo;', $pixelpost_comment_count, 'comments title', 'pixelpost' ) ),
						number_format_i18n( $pixelpost_comment_count ),
						'<span>' . wp_kses_post( get_the_title() ) . '</span>'
					);
				}
				?>
			</h3>
		</div>

		<ol class="space-y-space-md mb-space-xl fp-comment-list list-none p-0">
			<?php
			wp_list_comments(
				array(
					'style'      => 'ol',
					'short_ping' => true,
					'avatar_size'=> 48,
				)
			);
			?>
		</ol>

		<?php
		the_comments_navigation();

		if ( ! comments_open() ) :
			?>
			<p class="font-body-sm text-body-sm text-on-surface-variant no-comments"><?php esc_html_e( 'Comments are closed.', 'pixelpost' ); ?></p>
			<?php
		endif;

	endif; // have_comments()

	comment_form(
		array(
			'class_container'    => 'bg-surface-container-lowest p-space-md lg:p-space-lg rounded-xl shadow-sm border border-outline-variant/40 fp-comment-respond',
			'title_reply'        => __( 'Leave a Reply', 'pixelpost' ),
			'title_reply_before' => '<h3 id="reply-title" class="font-headline-sm text-headline-sm text-on-surface mb-space-xs">',
			'title_reply_after'  => '</h3>',
			'class_submit'       => 'inline-flex items-center justify-center px-space-md py-space-sm rounded-lg bg-primary hover:bg-primary-container text-on-primary font-label-md text-label-md shadow-md transition-all font-semibold cursor-pointer border-0 mt-space-sm',
			'comment_field'      => '<p class="comment-form-comment mb-space-sm"><label for="comment" class="block font-label-caps text-label-caps uppercase text-on-surface-variant mb-1">' . _x( 'Comment', 'noun', 'pixelpost' ) . ' <span class="required text-primary">*</span></label><textarea id="comment" name="comment" cols="45" rows="5" required="required" class="w-full bg-surface-container-low border border-outline-variant/60 rounded-lg p-3 text-on-surface font-body-md text-body-md focus:outline-none focus:ring-2 focus:ring-primary"></textarea></p>',
		)
	);
	?>
</div>
