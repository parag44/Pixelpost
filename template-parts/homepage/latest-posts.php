<?php
/**
 * Latest Posts Section Template Part
 * Matches Editorial Minimalism: Magazine Layout (Left Heading + Center Featured + Right Stacked Articles)
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
if ( empty( $pixelpost_count ) || $pixelpost_count < 4 ) {
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

// Sample fallback posts
$pixelpost_default_posts = pixelpost_get_default_blog_posts();

$articles = array();
$img_uri  = get_template_directory_uri() . '/assets/images';

if ( $pixelpost_has_posts ) {
	$idx = 0;
	while ( $pixelpost_blog_query->have_posts() ) {
		$pixelpost_blog_query->the_post();

		// Calculate read time
		$pixelpost_content  = get_post_field( 'post_content', get_the_ID() );
		$pixelpost_word_cnt = str_word_count( wp_strip_all_tags( $pixelpost_content ) );
		$pixelpost_minutes  = max( 1, (int) ceil( $pixelpost_word_cnt / 200 ) );
		/* translators: %d: reading time in minutes. */
		$pixelpost_read_time = sprintf( esc_html__( '%d MIN READ', 'pixelpost' ), $pixelpost_minutes );

		$thumb_url = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'large' ) : '';

		// If no featured image on post, provide thematic SVG fallback
		if ( empty( $thumb_url ) ) {
			if ( 0 === $idx ) {
				$thumb_url = $img_uri . '/blog-featured.svg';
			} elseif ( 1 === $idx ) {
				$thumb_url = $img_uri . '/blog-thumb-1.svg';
			} elseif ( 2 === $idx ) {
				$thumb_url = $img_uri . '/blog-thumb-2.svg';
			} else {
				$thumb_url = $img_uri . '/blog-thumb-3.svg';
			}
		}

		$pixelpost_cats     = get_the_category();
		$pixelpost_cat_name = ! empty( $pixelpost_cats[0] ) ? $pixelpost_cats[0]->name : __( 'Article', 'pixelpost' );

		$articles[] = array(
			'title'     => get_the_title(),
			'date'      => strtoupper( get_the_date( 'M d, Y' ) ),
			'read_time' => $pixelpost_read_time,
			'category'  => $pixelpost_cat_name,
			'excerpt'   => wp_strip_all_tags( get_the_excerpt() ),
			'url'       => get_permalink(),
			'image'     => $thumb_url,
		);
		$idx++;
	}
	wp_reset_postdata();
}

if ( empty( $articles ) ) {
	$articles = $pixelpost_default_posts;
}

$featured_article = ! empty( $articles[0] ) ? $articles[0] : null;
$recent_articles  = array_slice( $articles, 1, 3 );
?>
<section id="blog" class="w-full max-w-[1140px] mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-24 border-b border-[#E9E6E0] dark:border-[#2E2D29] fp-blog-section" aria-label="<?php esc_attr_e( 'Latest Blog Posts', 'pixelpost' ); ?>" data-pixelpost-customize="blog" data-pixelpost-label="<?php esc_attr_e( 'Latest Blog Posts', 'pixelpost' ); ?>">
	<div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-start">
		<!-- Left Column: Section Title & Narrative -->
		<div class="lg:col-span-4 flex flex-col items-start fp-blog-left">
			<?php if ( ! empty( $pixelpost_eyebrow ) ) : ?>
				<div class="inline-flex items-center gap-2 mb-3">
					<span class="text-xs uppercase tracking-widest font-semibold text-[#A94F20] dark:text-[#D4733F]"><?php echo esc_html( $pixelpost_eyebrow ); ?></span>
					<span class="w-8 h-px bg-[#A94F20]/50"></span>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $pixelpost_heading ) ) : ?>
				<h2 class="font-serif text-3xl sm:text-4xl lg:text-[40px] text-on-surface mb-3.5 leading-tight"><?php echo esc_html( $pixelpost_heading ); ?></h2>
			<?php endif; ?>

			<?php if ( ! empty( $pixelpost_subtitle ) ) : ?>
				<p class="text-sm sm:text-base text-on-surface-variant leading-relaxed mb-6 max-w-sm"><?php echo esc_html( $pixelpost_subtitle ); ?></p>
			<?php endif; ?>

			<?php if ( ! empty( $pixelpost_view_all_text ) ) : ?>
				<a class="inline-flex items-center gap-1.5 text-sm font-semibold text-[#A94F20] dark:text-[#D4733F] hover:underline group" href="<?php echo esc_url( $pixelpost_view_all_url ); ?>">
					<span><?php echo esc_html( $pixelpost_view_all_text ); ?></span>
					<span class="group-hover:translate-x-0.5 transition-transform">→</span>
				</a>
			<?php endif; ?>
		</div>

		<!-- Right Column: Editorial Magazine Layout (Featured + 3 Stacked) -->
		<div class="lg:col-span-8 grid grid-cols-1 md:grid-cols-12 gap-8 items-start fp-blog-right">
			<!-- Featured Large Article -->
			<?php if ( $featured_article ) : ?>
				<article class="md:col-span-7 flex flex-col group fp-featured-article">
					<?php if ( ! empty( $featured_article['image'] ) ) : ?>
						<div class="relative overflow-hidden rounded aspect-[16/10] w-full bg-[#F5F3EF] dark:bg-[#1E1D1B] border border-[#E9E6E0] dark:border-[#2E2D29] mb-3.5 fp-featured-img-wrap">
							<a href="<?php echo esc_url( $featured_article['url'] ); ?>" class="block w-full h-full">
								<img src="<?php echo esc_url( $featured_article['image'] ); ?>" alt="<?php echo esc_attr( $featured_article['title'] ); ?>" class="w-full h-full object-cover group-hover:scale-[1.02] transition-transform duration-500" loading="lazy" />
							</a>
						</div>
					<?php endif; ?>

					<div class="text-[11px] sm:text-xs uppercase tracking-wider text-on-surface-variant font-medium mb-1.5 fp-featured-meta">
						<span><?php echo esc_html( $featured_article['date'] ); ?></span>
						<span class="mx-1">·</span>
						<span><?php echo esc_html( $featured_article['read_time'] ); ?></span>
					</div>

					<h3 class="font-serif text-xl sm:text-2xl font-bold text-on-surface group-hover:text-primary transition-colors leading-snug fp-featured-title">
						<a href="<?php echo esc_url( $featured_article['url'] ); ?>">
							<?php echo esc_html( $featured_article['title'] ); ?>
						</a>
					</h3>
				</article>
			<?php endif; ?>

			<!-- Stacked 3 Smaller Articles -->
			<?php if ( ! empty( $recent_articles ) ) : ?>
				<div class="md:col-span-5 flex flex-col divide-y divide-[#E9E6E0] dark:divide-[#2E2D29] fp-recent-articles-list">
					<?php foreach ( $recent_articles as $r_idx => $recent ) : ?>
						<article class="flex items-center gap-3.5 py-4 first:pt-0 last:pb-0 group fp-recent-article-item">
							<?php if ( ! empty( $recent['image'] ) ) : ?>
								<div class="w-18 h-18 sm:w-20 sm:h-20 aspect-square rounded overflow-hidden flex-shrink-0 border border-[#E9E6E0] dark:border-[#2E2D29] bg-[#F5F3EF] dark:bg-[#1E1D1B] fp-recent-thumb-wrap">
									<a href="<?php echo esc_url( $recent['url'] ); ?>" class="block w-full h-full">
										<img src="<?php echo esc_url( $recent['image'] ); ?>" alt="<?php echo esc_attr( $recent['title'] ); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy" />
									</a>
								</div>
							<?php endif; ?>

							<div class="flex flex-col min-w-0 flex-1">
								<span class="text-[11px] uppercase tracking-wider text-on-surface-variant font-medium mb-0.5">
									<?php echo esc_html( $recent['date'] ); ?>
								</span>
								<h4 class="font-serif font-bold text-sm sm:text-base text-on-surface group-hover:text-primary transition-colors leading-snug line-clamp-2 my-0.5 fp-recent-title">
									<a href="<?php echo esc_url( $recent['url'] ); ?>">
										<?php echo esc_html( $recent['title'] ); ?>
									</a>
								</h4>
								<span class="text-xs text-on-surface-variant">
									<?php echo esc_html( $recent['read_time'] ); ?>
								</span>
							</div>
						</article>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
