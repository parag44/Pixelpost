<?php
/**
 * Single Post Template Part (Editorial Layout)
 * Matches Warm Editorial Craft design system
 *
 * @package Pixelpost
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Calculate read time
$pixelpost_content   = get_post_field( 'post_content', get_the_ID() );
$pixelpost_word_cnt  = str_word_count( wp_strip_all_tags( $pixelpost_content ) );
$pixelpost_minutes   = max( 1, (int) ceil( $pixelpost_word_cnt / 200 ) );
/* translators: %d: reading time in minutes. */
$pixelpost_read_time = sprintf( esc_html__( '%d MIN READ', 'pixelpost' ), $pixelpost_minutes );

// Get Category
$pixelpost_categories    = get_the_category();
$pixelpost_category_name = ! empty( $pixelpost_categories ) ? $pixelpost_categories[0]->name : __( 'Article', 'pixelpost' );
$pixelpost_category_link = ! empty( $pixelpost_categories ) ? get_category_link( $pixelpost_categories[0]->term_id ) : '#';

// Author resolution
$pixelpost_post_author_id = get_the_author_meta( 'ID' );
if ( empty( $pixelpost_post_author_id ) ) {
	$pixelpost_post_author_id = (int) get_post_field( 'post_author', get_the_ID() );
}
$pixelpost_author_display_name = get_the_author();
if ( empty( $pixelpost_author_display_name ) ) {
	$pixelpost_author_display_name = get_bloginfo( 'name' );
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'fp-single-article' ); ?>>
	<!-- Back to Archive Breadcrumb -->
	<div class="max-w-[760px] mx-auto mb-space-md">
		<a href="<?php echo esc_url( pixelpost_get_blog_archive_url() ); ?>" class="inline-flex items-center gap-1.5 text-primary hover:text-primary-container font-label-md text-label-md font-semibold transition-colors group">
			<?php echo pixelpost_get_icon( 'arrow_back', array( 'width' => 18, 'height' => 18, 'class' => 'group-hover:-translate-x-1 transition-transform' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<span><?php esc_html_e( 'Back to Knowledge Base', 'pixelpost' ); ?></span>
		</a>
	</div>

	<!-- Article Header -->
	<header class="max-w-[760px] mx-auto mb-space-lg text-left fp-article-header">
		<div class="flex items-center gap-2 mb-space-xs">
			<a href="<?php echo esc_url( $pixelpost_category_link ); ?>" class="font-label-caps text-label-caps uppercase text-primary tracking-wider hover:underline">
				<?php echo esc_html( $pixelpost_category_name ); ?>
			</a>
			<span class="text-on-surface-variant/40">•</span>
			<span class="font-label-caps text-label-caps uppercase text-primary font-bold">
				<?php echo esc_html( $pixelpost_read_time ); ?>
			</span>
		</div>

		<h1 class="font-headline-display text-[32px] sm:text-[42px] lg:text-[48px] leading-[1.18] text-on-surface tracking-tight mb-space-md fp-single-title">
			<?php the_title(); ?>
		</h1>

		<div class="flex flex-wrap items-center gap-3 text-on-surface-variant font-body-sm text-body-sm pt-space-xs border-t border-surface-container-high/60">
			<span class="inline-flex items-center gap-1.5">
				<?php echo pixelpost_get_icon( 'calendar_today', array( 'width' => 16, 'height' => 16, 'class' => 'text-primary' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<time class="entry-date published" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
					<?php echo esc_html( get_the_date( 'F j, Y' ) ); ?>
				</time>
			</span>

			<span class="text-on-surface-variant/40">•</span>

			<span class="inline-flex items-center gap-1.5">
				<span class="w-5 h-5 rounded-full overflow-hidden inline-flex items-center justify-center flex-shrink-0 border border-outline-variant/40">
					<?php echo get_avatar( $pixelpost_post_author_id ? $pixelpost_post_author_id : get_option( 'admin_email' ), 24, '', $pixelpost_author_display_name, array( 'class' => 'w-full h-full object-cover' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</span>
				<span><?php echo esc_html( $pixelpost_author_display_name ); ?></span>
			</span>

			<?php if ( comments_open() || get_comments_number() ) : ?>
				<span class="text-on-surface-variant/40">•</span>
				<a href="#comments" class="hover:text-primary transition-colors inline-flex items-center gap-1.5">
					<?php echo pixelpost_get_icon( 'forum', array( 'width' => 16, 'height' => 16, 'class' => 'text-primary' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<span><?php comments_number( __( 'Leave a comment', 'pixelpost' ), __( '1 Comment', 'pixelpost' ), __( '% Comments', 'pixelpost' ) ); ?></span>
				</a>
			<?php endif; ?>
		</div>
	</header>

	<!-- Centered Featured Image -->
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="max-w-[960px] mx-auto rounded-2xl overflow-hidden shadow-md border border-outline-variant/40 mb-space-xl bg-surface-container fp-featured-media">
			<?php the_post_thumbnail( 'large', array( 'class' => 'w-full h-auto object-cover max-h-[520px]' ) ); ?>
			<?php if ( get_the_post_thumbnail_caption() ) : ?>
				<div class="p-3 text-center text-on-surface-variant font-body-sm text-body-sm bg-surface-container-low/80 border-t border-surface-container-high/40">
					<?php echo esc_html( get_the_post_thumbnail_caption() ); ?>
				</div>
			<?php endif; ?>
		</div>
	<?php endif; ?>

	<!-- Centered Article Content (Reading Container) -->
	<div class="max-w-[760px] mx-auto fp-article-content font-body-lg text-body-lg text-on-surface leading-relaxed">
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

	<!-- Tags -->
	<?php if ( has_tag() ) : ?>
		<div class="max-w-[760px] mx-auto mt-space-lg pt-space-md border-t border-surface-container-high/60 flex flex-wrap items-center gap-2 fp-entry-tags">
			<span class="font-label-caps text-label-caps uppercase text-on-surface-variant mr-1"><?php esc_html_e( 'Tags:', 'pixelpost' ); ?></span>
			<?php
			$pixelpost_tags = get_the_tags();
			if ( $pixelpost_tags ) {
				foreach ( $pixelpost_tags as $pixelpost_tag ) {
					echo '<a href="' . esc_url( get_tag_link( $pixelpost_tag->term_id ) ) . '" class="px-space-xs py-1 rounded-full bg-surface-container hover:bg-surface-container-high text-on-surface font-label-md text-label-md transition-colors">#' . esc_html( $pixelpost_tag->name ) . '</a> ';
				}
			}
			?>
		</div>
	<?php endif; ?>

	<!-- Author Box -->
	<div class="max-w-[760px] mx-auto mt-space-xl p-space-md lg:p-space-lg bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/40 flex flex-col sm:flex-row items-center sm:items-start gap-space-md fp-author-bio-card">
		<div class="w-16 h-16 rounded-full overflow-hidden flex-shrink-0 bg-surface-container-high border border-outline-variant/40">
			<?php echo get_avatar( $pixelpost_post_author_id ? $pixelpost_post_author_id : get_option( 'admin_email' ), 96, '', $pixelpost_author_display_name, array( 'class' => 'w-full h-full object-cover rounded-full' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
		<div class="flex flex-col text-center sm:text-left">
			<span class="font-label-caps text-label-caps uppercase text-primary mb-1"><?php esc_html_e( 'Author & Engineer', 'pixelpost' ); ?></span>
			<h4 class="font-title-md text-title-md text-on-surface font-bold"><?php echo esc_html( $pixelpost_author_display_name ); ?></h4>
			<p class="font-body-sm text-body-sm text-on-surface-variant mt-1 leading-relaxed">
				<?php echo esc_html( get_the_author_meta( 'description', $pixelpost_post_author_id ) ? get_the_author_meta( 'description', $pixelpost_post_author_id ) : __( 'WordPress Technical Support Engineer & Core Problem Solver specializing in architecture audits, high-load troubleshooting, and zero-downtime recoveries.', 'pixelpost' ) ); ?>
			</p>
		</div>
	</div>
</article>
