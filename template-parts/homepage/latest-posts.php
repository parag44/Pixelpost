<?php
/**
 * Latest Posts Section Template Part
 * Matches Google Stitch PRD: Knowledge Base (Editorial 4-Card Grid)
 *
 * @package Pixelpost
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$pixelpost_eyebrow       = pixelpost_get_setting( 'pixelpost_blog_eyebrow' );
$pixelpost_heading       = pixelpost_get_setting( 'pixelpost_blog_heading' );
$pixelpost_subtitle      = pixelpost_get_setting( 'pixelpost_blog_subtitle' );
$pixelpost_view_all_text = pixelpost_get_setting( 'pixelpost_blog_view_all_text' );
$pixelpost_view_all_url  = pixelpost_get_setting( 'pixelpost_blog_view_all_url' );
$pixelpost_count         = absint( pixelpost_get_setting( 'pixelpost_blog_posts_count' ) );
if ( empty( $pixelpost_count ) ) {
	$pixelpost_count = 4;
}

if ( empty( $pixelpost_view_all_url ) ) {
	$pixelpost_view_all_url = pixelpost_get_blog_archive_url();
}

$pixelpost_blog_query = new WP_Query(
	array(
		'post_type'           => 'post',
		'posts_per_page'      => $pixelpost_count,
		'post_status'         => 'publish',
		'ignore_sticky_posts' => true,
	)
);

$pixelpost_has_posts = $pixelpost_blog_query->have_posts();

// Sample Stitch fallback posts
$pixelpost_default_posts = pixelpost_get_default_blog_posts();
?>
<section id="blog" class="w-full max-w-[1200px] mx-auto px-margin-mobile lg:px-margin pt-space-xl pb-space-lg fp-blog-section" aria-label="<?php esc_attr_e( 'Latest Blog Posts', 'pixelpost' ); ?>" data-pixelpost-customize="blog" data-pixelpost-label="<?php esc_attr_e( 'Latest Blog Posts', 'pixelpost' ); ?>">
	<div class="flex flex-col md:flex-row md:items-end justify-between mb-space-lg gap-space-sm">
		<div class="flex flex-col max-w-2xl">
			<?php if ( ! empty( $pixelpost_eyebrow ) ) : ?>
				<span class="font-label-caps text-label-caps uppercase text-primary tracking-wider mb-space-xs"><?php echo esc_html( $pixelpost_eyebrow ); ?></span>
			<?php endif; ?>

			<?php if ( ! empty( $pixelpost_heading ) ) : ?>
				<h2 class="font-headline-lg text-headline-lg text-on-surface"><?php echo esc_html( $pixelpost_heading ); ?></h2>
			<?php endif; ?>

			<?php if ( ! empty( $pixelpost_subtitle ) ) : ?>
				<p class="font-body-md text-body-md text-on-surface-variant mt-space-xs"><?php echo esc_html( $pixelpost_subtitle ); ?></p>
			<?php endif; ?>
		</div>

		<?php if ( ! empty( $pixelpost_view_all_text ) ) : ?>
			<a class="inline-flex items-center gap-1 font-label-md text-label-md text-primary hover:text-primary-container font-semibold transition-colors group" href="<?php echo esc_url( $pixelpost_view_all_url ); ?>">
				<span><?php echo esc_html( $pixelpost_view_all_text ); ?></span>
				<?php echo pixelpost_get_icon( 'arrow_forward', array( 'width' => 18, 'height' => 18, 'class' => 'group-hover:translate-x-1 transition-transform' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</a>
		<?php endif; ?>
	</div>

	<!-- Editorial 4-Card Grid -->
	<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md fp-posts-grid">
		<?php
		if ( $pixelpost_has_posts ) :
			while ( $pixelpost_blog_query->have_posts() ) :
				$pixelpost_blog_query->the_post();

				// Calculate read time
				$pixelpost_content   = get_post_field( 'post_content', get_the_ID() );
				$pixelpost_word_cnt  = str_word_count( wp_strip_all_tags( $pixelpost_content ) );
				$pixelpost_minutes   = max( 1, (int) ceil( $pixelpost_word_cnt / 200 ) );
				/* translators: %d: reading time in minutes. */
				$pixelpost_read_time = sprintf( esc_html__( '%d MIN READ', 'pixelpost' ), $pixelpost_minutes );

				// Get primary category
				$pixelpost_cats     = get_the_category();
				$pixelpost_cat_name = ! empty( $pixelpost_cats[0] ) ? $pixelpost_cats[0]->name : __( 'Article', 'pixelpost' );
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'bg-surface-container-lowest rounded-xl p-space-md shadow-sm hover:shadow-md transition-all flex flex-col justify-between group border border-outline-variant/30 fp-post-card' ); ?>>
					<div>
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="relative overflow-hidden rounded-lg aspect-[16/9] w-full bg-surface-container mb-space-sm fp-card-thumb">
								<a href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail( 'medium_large', array( 'class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-500' ) ); ?>
								</a>
							</div>
						<?php endif; ?>

						<div class="flex items-center justify-between text-on-surface-variant font-label-caps text-label-caps mb-space-xs">
							<span><?php echo esc_html( strtoupper( get_the_date( 'M d, Y' ) ) ); ?></span>
							<span class="text-primary font-bold"><?php echo esc_html( $pixelpost_read_time ); ?></span>
						</div>
						<span class="inline-block px-2 py-0.5 rounded bg-surface-container font-label-caps text-label-caps text-on-surface-variant uppercase mb-space-sm fp-category-pill"><?php echo esc_html( $pixelpost_cat_name ); ?></span>
						<h3 class="font-headline-sm text-headline-sm text-on-surface group-hover:text-primary transition-colors leading-snug mb-space-xs fp-post-card-title">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h3>
						<p class="font-body-sm text-body-sm text-on-surface-variant line-clamp-3 mb-space-md fp-post-card-excerpt">
							<?php echo esc_html( wp_strip_all_tags( get_the_excerpt() ) ); ?>
						</p>
					</div>
					<a class="inline-flex items-center gap-1 text-primary hover:text-primary-container font-label-md text-label-md font-semibold group/read pt-space-xs border-t border-surface-container-high/40 mt-auto" href="<?php the_permalink(); ?>">
						<span><?php esc_html_e( 'Read Analysis', 'pixelpost' ); ?></span>
						<?php echo pixelpost_get_icon( 'arrow_forward', array( 'width' => 16, 'height' => 16, 'class' => 'group-hover/read:translate-x-1 transition-transform' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</a>
				</article>
				<?php
			endwhile;
			wp_reset_postdata();
		else :
			// Fallback to default Stitch posts
			foreach ( $pixelpost_default_posts as $pixelpost_post_item ) :
				?>
				<article class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm hover:shadow-md transition-all flex flex-col justify-between group border border-outline-variant/30 fp-post-card">
					<div>
						<?php if ( ! empty( $pixelpost_post_item['image'] ) ) : ?>
							<div class="relative overflow-hidden rounded-lg aspect-[16/9] w-full bg-surface-container mb-space-sm fp-card-thumb">
								<a href="<?php echo esc_url( $pixelpost_view_all_url ); ?>">
									<img src="<?php echo esc_url( $pixelpost_post_item['image'] ); ?>" alt="<?php echo esc_attr( $pixelpost_post_item['title'] ); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy" />
								</a>
							</div>
						<?php endif; ?>

						<div class="flex items-center justify-between text-on-surface-variant font-label-caps text-label-caps mb-space-xs">
							<span><?php echo esc_html( $pixelpost_post_item['date'] ); ?></span>
							<span class="text-primary font-bold"><?php echo esc_html( $pixelpost_post_item['read_time'] ); ?></span>
						</div>
						<span class="inline-block px-2 py-0.5 rounded bg-surface-container font-label-caps text-label-caps text-on-surface-variant uppercase mb-space-sm fp-category-pill"><?php echo esc_html( $pixelpost_post_item['category'] ); ?></span>
						<h3 class="font-headline-sm text-headline-sm text-on-surface group-hover:text-primary transition-colors leading-snug mb-space-xs fp-post-card-title">
							<a href="<?php echo esc_url( $pixelpost_view_all_url ); ?>"><?php echo esc_html( $pixelpost_post_item['title'] ); ?></a>
						</h3>
						<p class="font-body-sm text-body-sm text-on-surface-variant line-clamp-3 mb-space-md fp-post-card-excerpt">
							<?php echo esc_html( $pixelpost_post_item['excerpt'] ); ?>
						</p>
					</div>
					<a class="inline-flex items-center gap-1 text-primary hover:text-primary-container font-label-md text-label-md font-semibold group/read pt-space-xs border-t border-surface-container-high/40 mt-auto" href="<?php echo esc_url( $pixelpost_view_all_url ); ?>">
						<span><?php esc_html_e( 'Read Analysis', 'pixelpost' ); ?></span>
						<?php echo pixelpost_get_icon( 'arrow_forward', array( 'width' => 16, 'height' => 16, 'class' => 'group-hover/read:translate-x-1 transition-transform' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</a>
				</article>
				<?php
			endforeach;
		endif;
		?>
	</div>
</section>
