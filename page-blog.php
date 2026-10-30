<?php
/**
 * The template for displaying a page with slug 'blog'
 * Matches Stitch Warm Editorial Craft Knowledge Base Design
 *
 * @package Pixelpost
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$pixelpost_paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : ( ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1 );

$pixelpost_blog_query = new WP_Query(
	array(
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'paged'          => $pixelpost_paged,
		'posts_per_page' => get_option( 'posts_per_page', 9 ),
	)
);
?>

<div class="w-full max-w-[1200px] mx-auto px-margin-mobile lg:px-margin pt-space-xl pb-space-xxl fp-archive-wrapper">
	<!-- Page Header -->
	<header class="mb-space-lg">
		<span class="font-label-caps text-label-caps uppercase text-primary tracking-wider mb-space-xs block">
			<?php esc_html_e( 'Knowledge Base', 'pixelpost' ); ?>
		</span>
		<?php
		$pixelpost_page_title = get_the_title();
		if ( empty( $pixelpost_page_title ) ) {
			$pixelpost_page_title = __( 'Knowledge Base & Field Notes', 'pixelpost' );
		}
		?>
		<h1 class="font-headline-display text-[36px] sm:text-[44px] lg:text-[52px] leading-tight text-on-surface tracking-tight mb-space-xs fp-archive-title">
			<?php echo esc_html( $pixelpost_page_title ); ?>
		</h1>
		<p class="font-body-md text-body-md text-on-surface-variant max-w-2xl">
			<?php esc_html_e( 'Practical diagnostic walkthroughs, performance case studies, and engineering notes on modern WordPress systems.', 'pixelpost' ); ?>
		</p>
	</header>

	<!-- Category Filter Bar -->
	<?php
	$pixelpost_categories = get_categories( array( 'hide_empty' => true ) );
	if ( ! empty( $pixelpost_categories ) ) :
		?>
		<div class="flex flex-wrap items-center gap-2 mb-space-xl pb-space-sm border-b border-surface-container-high/60 fp-category-tabs">
			<a href="<?php echo esc_url( pixelpost_get_blog_archive_url() ); ?>" class="px-3 py-1.5 rounded-full font-label-md text-label-md transition-colors bg-primary text-on-primary font-bold shadow-sm">
				<?php esc_html_e( 'All Articles', 'pixelpost' ); ?>
			</a>
			<?php foreach ( $pixelpost_categories as $pixelpost_cat ) : ?>
				<a href="<?php echo esc_url( get_category_link( $pixelpost_cat->term_id ) ); ?>" class="px-3 py-1.5 rounded-full font-label-md text-label-md transition-colors bg-surface-container-lowest text-on-surface-variant hover:text-on-surface border border-outline-variant/40 shadow-sm">
					<?php echo esc_html( $pixelpost_cat->name ); ?>
					<span class="text-xs opacity-60 ml-0.5">(<?php echo esc_html( $pixelpost_cat->count ); ?>)</span>
				</a>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<!-- Editorial Card Grid -->
	<?php if ( $pixelpost_blog_query->have_posts() ) : ?>
		<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-space-md mb-space-xl fp-archive-grid">
			<?php
			while ( $pixelpost_blog_query->have_posts() ) :
				$pixelpost_blog_query->the_post();

				// Calculate read time
				$pixelpost_content   = get_post_field( 'post_content', get_the_ID() );
				$pixelpost_word_cnt  = str_word_count( wp_strip_all_tags( $pixelpost_content ) );
				$pixelpost_minutes   = max( 1, (int) ceil( $pixelpost_word_cnt / 200 ) );
				/* translators: %d: reading time in minutes. */
				$pixelpost_read_time = sprintf( esc_html__( '%d MIN READ', 'pixelpost' ), $pixelpost_minutes );

				// Category
				$pixelpost_cats     = get_the_category();
				$pixelpost_cat_name = ! empty( $pixelpost_cats[0] ) ? $pixelpost_cats[0]->name : __( 'Article', 'pixelpost' );
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'bg-surface-container-lowest rounded-xl p-space-md lg:p-space-lg shadow-sm hover:shadow-md transition-all flex flex-col justify-between group border border-outline-variant/30 fp-post-card' ); ?>>
					<div>
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="relative overflow-hidden rounded-lg aspect-[16/9] w-full bg-surface-container mb-space-sm fp-card-thumb">
								<a href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail( 'medium_large', array( 'class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-500' ) ); ?>
								</a>
							</div>
						<?php endif; ?>

						<div class="flex items-center justify-between text-on-surface-variant font-label-caps text-label-caps mb-space-xs">
							<span><?php echo esc_html( get_the_date( 'M j, Y' ) ); ?></span>
							<span class="text-primary font-bold"><?php echo esc_html( $pixelpost_read_time ); ?></span>
						</div>

						<span class="inline-block px-2 py-0.5 rounded bg-surface-container font-label-caps text-label-caps text-on-surface-variant uppercase mb-space-sm">
							<?php echo esc_html( $pixelpost_cat_name ); ?>
						</span>

						<h3 class="font-headline-sm text-headline-sm text-on-surface group-hover:text-primary transition-colors leading-snug mb-space-xs">
							<a href="<?php the_permalink(); ?>">
								<?php the_title(); ?>
							</a>
						</h3>

						<div class="font-body-sm text-body-sm text-on-surface-variant line-clamp-3 mb-space-md">
							<?php the_excerpt(); ?>
						</div>
					</div>

					<a class="inline-flex items-center gap-1 text-primary hover:text-primary-container font-label-md text-label-md font-semibold group/read pt-space-xs border-t border-surface-container-high/40 mt-auto" href="<?php the_permalink(); ?>">
						<span><?php esc_html_e( 'Read Analysis', 'pixelpost' ); ?></span>
						<?php echo pixelpost_get_icon( 'arrow_forward', array( 'width' => 16, 'height' => 16, 'class' => 'group-hover/read:translate-x-1 transition-transform' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</a>
				</article>
			<?php endwhile; ?>
		</div>

		<!-- Pagination Navigation -->
		<div class="flex justify-center fp-pagination-wrap">
			<?php
			echo '<nav class="navigation pagination fp-pagination" aria-label="' . esc_attr__( 'Posts navigation', 'pixelpost' ) . '">';
			echo paginate_links( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				array(
					'total'     => $pixelpost_blog_query->max_num_pages,
					'current'   => $pixelpost_paged,
					'prev_text' => '← ' . __( 'Newer Posts', 'pixelpost' ),
					'next_text' => __( 'Older Posts', 'pixelpost' ) . ' →',
					'type'      => 'plain',
				)
			);
			echo '</nav>';
			wp_reset_postdata();
			?>
		</div>
	<?php else : ?>
		<!-- Fallback Demo Editorial Cards if no published posts exist yet -->
		<?php $pixelpost_default_posts = pixelpost_get_default_blog_posts(); ?>
		<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-space-md mb-space-xl fp-archive-grid">
			<?php foreach ( $pixelpost_default_posts as $pixelpost_d_post ) : ?>
				<article class="bg-surface-container-lowest rounded-xl p-space-md lg:p-space-lg shadow-sm hover:shadow-md transition-all flex flex-col justify-between group border border-outline-variant/30 fp-post-card">
					<div>
						<div class="flex items-center justify-between text-on-surface-variant font-label-caps text-label-caps mb-space-xs">
							<span><?php echo esc_html( $pixelpost_d_post['date'] ); ?></span>
							<span class="text-primary font-bold"><?php echo esc_html( $pixelpost_d_post['read_time'] ); ?></span>
						</div>

						<span class="inline-block px-2 py-0.5 rounded bg-surface-container font-label-caps text-label-caps text-on-surface-variant uppercase mb-space-sm">
							<?php echo esc_html( $pixelpost_d_post['category'] ); ?>
						</span>

						<h3 class="font-headline-sm text-headline-sm text-on-surface group-hover:text-primary transition-colors leading-snug mb-space-xs">
							<a href="<?php echo esc_url( $pixelpost_d_post['url'] ); ?>">
								<?php echo esc_html( $pixelpost_d_post['title'] ); ?>
							</a>
						</h3>

						<div class="font-body-sm text-body-sm text-on-surface-variant line-clamp-3 mb-space-md">
							<p><?php echo esc_html( $pixelpost_d_post['excerpt'] ); ?></p>
						</div>
					</div>

					<a class="inline-flex items-center gap-1 text-primary hover:text-primary-container font-label-md text-label-md font-semibold group/read pt-space-xs border-t border-surface-container-high/40 mt-auto" href="<?php echo esc_url( $pixelpost_d_post['url'] ); ?>">
						<span><?php esc_html_e( 'Read Analysis', 'pixelpost' ); ?></span>
						<?php echo pixelpost_get_icon( 'arrow_forward', array( 'width' => 16, 'height' => 16, 'class' => 'group-hover/read:translate-x-1 transition-transform' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</a>
				</article>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>

<?php
get_footer();
