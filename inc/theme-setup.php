<?php
/**
 * Pixelpost Theme Setup and Enqueue
 *
 * @package Pixelpost
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function pixelpost_setup() {
	load_theme_textdomain( 'pixelpost', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );

	add_image_size( 'pixelpost-blog-card', 600, 380, true );
	add_image_size( 'pixelpost-project-thumb', 600, 400, true );

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'pixelpost' ),
			'footer'  => __( 'Footer Menu', 'pixelpost' ),
		)
	);

	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	add_theme_support(
		'custom-logo',
		array(
			'height'      => 80,
			'width'       => 240,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'custom-background', array(
		'default-color' => 'FBF9F5',
	) );

	// Custom Header support.
	add_theme_support(
		'custom-header',
		apply_filters(
			'pixelpost_custom_header_args',
			array(
				'default-image'      => '',
				'default-text-color' => '1c1b18',
				'width'              => 1200,
				'height'             => 280,
				'flex-width'         => true,
				'flex-height'        => true,
				'wp-head-callback'   => 'pixelpost_header_style',
			)
		)
	);

	add_theme_support( 'editor-styles' );
	add_editor_style( 'editor-style.css' );

	if ( function_exists( 'register_block_style' ) ) {
		register_block_style(
			'core/quote',
			array(
				'name'  => 'editorial',
				'label' => __( 'Editorial Terracotta', 'pixelpost' ),
			)
		);
	}

	// Gutenberg Color Palette
	add_theme_support(
		'editor-color-palette',
		array(
			array(
				'name'  => __( 'Warm Linen Canvas', 'pixelpost' ),
				'slug'  => 'fp-canvas',
				'color' => '#FBF9F5',
			),
			array(
				'name'  => __( 'Pristine White Surface', 'pixelpost' ),
				'slug'  => 'fp-white',
				'color' => '#FFFFFF',
			),
			array(
				'name'  => __( 'Surface Inset / Container', 'pixelpost' ),
				'slug'  => 'fp-surface-low',
				'color' => '#F5F3EF',
			),
			array(
				'name'  => __( 'Deep Slate Charcoal (Text)', 'pixelpost' ),
				'slug'  => 'fp-charcoal',
				'color' => '#1B1C1A',
			),
			array(
				'name'  => __( 'Muted Umber (Body)', 'pixelpost' ),
				'slug'  => 'fp-muted',
				'color' => '#574238',
			),
			array(
				'name'  => __( 'Burnt Terracotta (Primary)', 'pixelpost' ),
				'slug'  => 'fp-terracotta',
				'color' => '#994200',
			),
			array(
				'name'  => __( 'Emerald Diagnostic (Online)', 'pixelpost' ),
				'slug'  => 'fp-emerald',
				'color' => '#10B981',
			),
		)
	);

	// Gutenberg Font Sizes
	add_theme_support(
		'editor-font-sizes',
		array(
			array(
				'name' => __( 'Small', 'pixelpost' ),
				'size' => 13,
				'slug' => 'small',
			),
			array(
				'name' => __( 'Normal', 'pixelpost' ),
				'size' => 16,
				'slug' => 'normal',
			),
			array(
				'name' => __( 'Medium', 'pixelpost' ),
				'size' => 20,
				'slug' => 'medium',
			),
			array(
				'name' => __( 'Large', 'pixelpost' ),
				'size' => 28,
				'slug' => 'large',
			),
			array(
				'name' => __( 'Huge', 'pixelpost' ),
				'size' => 40,
				'slug' => 'huge',
			),
		)
	);
}
add_action( 'after_setup_theme', 'pixelpost_setup' );

/**
 * Register widget area.
 */
function pixelpost_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Widgets', 'pixelpost' ),
			'id'            => 'footer-sidebar',
			'description'   => esc_html__( 'Add widgets here to appear in your footer.', 'pixelpost' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'pixelpost_widgets_init' );

/**
 * Ensure designated posts page always loads the blog archive template
 * even if show_on_front is set to 'posts'.
 *
 * @param string $template Path to the template.
 * @return string
 */
function pixelpost_posts_page_template( $template ) {
	$page_for_posts = get_option( 'page_for_posts' );
	if ( $page_for_posts && is_page( $page_for_posts ) ) {
		$blog_template = locate_template( array( 'page-blog.php', 'home.php' ) );
		if ( ! empty( $blog_template ) ) {
			return $blog_template;
		}
	}
	return $template;
}
add_filter( 'template_include', 'pixelpost_posts_page_template' );

/**
 * Set content width
 */
function pixelpost_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'pixelpost_content_width', 1140 );
}
add_action( 'after_setup_theme', 'pixelpost_content_width', 0 );

/**
 * Enqueue scripts and styles.
 */
function pixelpost_scripts() {
	// Editorial Google Fonts (Playfair Display + EB Garamond + Inter + Caveat for handwritten notes)
	wp_enqueue_style(
		'pixelpost-fonts',
		'https://fonts.googleapis.com/css2?family=Caveat:wght@400;600;700&family=EB+Garamond:ital,wght@0,400..800;1,400..800&family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap',
		array(),
		null
	);

	// Theme Main Stylesheet (includes compiled production utilities)
	wp_enqueue_style(
		'pixelpost-style',
		get_stylesheet_uri(),
		array(),
		PIXELPOST_VERSION
	);

	// Dynamic Customizer Styles
	$custom_css = pixelpost_get_customizer_css();
	if ( ! empty( $custom_css ) ) {
		wp_add_inline_style( 'pixelpost-style', $custom_css );
	}

	// Main Navigation JavaScript (deferred for non-blocking rendering)
	wp_enqueue_script(
		'pixelpost-navigation',
		get_template_directory_uri() . '/assets/js/navigation.js',
		array(),
		PIXELPOST_VERSION,
		true
	);
	wp_script_add_data( 'pixelpost-navigation', 'strategy', 'defer' );

	// Comments reply script
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'pixelpost_scripts' );



/**
 * Add preconnect resource hints for Google Fonts
 *
 * @param array  $urls          URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed for.
 * @return array
 */
function pixelpost_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.googleapis.com',
		);
		$urls[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'pixelpost_resource_hints', 10, 2 );

/**
 * Generate inline CSS from Customizer settings
 *
 * @return string
 */
function pixelpost_get_customizer_css() {
	$bg       = get_theme_mod( 'pixelpost_color_bg', pixelpost_get_theme_default( 'pixelpost_color_bg' ) );
	$surface  = get_theme_mod( 'pixelpost_color_surface', pixelpost_get_theme_default( 'pixelpost_color_surface' ) );
	$text     = get_theme_mod( 'pixelpost_color_text', pixelpost_get_theme_default( 'pixelpost_color_text' ) );
	$accent   = get_theme_mod( 'pixelpost_color_accent', pixelpost_get_theme_default( 'pixelpost_color_accent' ) );
	$border   = get_theme_mod( 'pixelpost_color_border', pixelpost_get_theme_default( 'pixelpost_color_border' ) );
	$width    = get_theme_mod( 'pixelpost_container_max_width', pixelpost_get_theme_default( 'pixelpost_container_max_width' ) );

	$css = ":root {\n";
	if ( $bg ) {
		$css .= "  --fp-bg: " . esc_attr( $bg ) . ";\n";
	}
	if ( $surface ) {
		$css .= "  --fp-surface: " . esc_attr( $surface ) . ";\n";
	}
	if ( $text ) {
		$css .= "  --fp-text: " . esc_attr( $text ) . ";\n";
		$css .= "  --fp-on-surface: " . esc_attr( $text ) . ";\n";
	}
	if ( $accent ) {
		$css .= "  --fp-primary: " . esc_attr( $accent ) . ";\n";
		$css .= "  --fp-accent: " . esc_attr( $accent ) . ";\n";
		$css .= "  --fp-focus: " . esc_attr( $accent ) . ";\n";
	}
	if ( $border ) {
		$css .= "  --fp-border: " . esc_attr( $border ) . ";\n";
	}
	if ( $width ) {
		$css .= "  --fp-container-max: " . absint( $width ) . "px;\n";
	}
	$css .= "}\n";

	// Custom Logo Dimensions (Width / Height)
	$logo_width  = get_theme_mod( 'pixelpost_logo_width', pixelpost_get_theme_default( 'pixelpost_logo_width' ) );
	$logo_height = get_theme_mod( 'pixelpost_logo_height', pixelpost_get_theme_default( 'pixelpost_logo_height' ) );

	if ( ! empty( $logo_width ) || ! empty( $logo_height ) ) {
		$css .= "\n.custom-logo-link img.custom-logo, .fp-branding .custom-logo, .fp-branding img, .custom-logo {\n";
		if ( ! empty( $logo_width ) && ! empty( $logo_height ) ) {
			$css .= "  max-width: " . absint( $logo_width ) . "px !important;\n";
			$css .= "  max-height: " . absint( $logo_height ) . "px !important;\n";
			$css .= "  width: 100%;\n";
			$css .= "  height: auto;\n";
			$css .= "  object-fit: contain;\n";
		} elseif ( ! empty( $logo_width ) ) {
			$css .= "  max-width: " . absint( $logo_width ) . "px !important;\n";
			$css .= "  width: " . absint( $logo_width ) . "px;\n";
			$css .= "  height: auto !important;\n";
			$css .= "  object-fit: contain;\n";
		} elseif ( ! empty( $logo_height ) ) {
			$css .= "  max-height: " . absint( $logo_height ) . "px !important;\n";
			$css .= "  height: " . absint( $logo_height ) . "px;\n";
			$css .= "  width: auto !important;\n";
			$css .= "  object-fit: contain;\n";
		}
		$css .= "}\n";
	}

	return $css;
}

if ( ! function_exists( 'pixelpost_header_style' ) ) :
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see pixelpost_setup().
	 */
	function pixelpost_header_style() {
		$header_text_color = get_header_textcolor();

		/*
		 * If no custom options for text are set, let's bail.
		 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: default-text-color.
		 */
		if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
			return;
		}

		// If we get this far, we have custom styles.
		?>
		<style type="text/css">
		<?php
		// Has the text been hidden?
		if ( ! display_header_text() ) :
			?>
			.fp-site-title,
			.fp-site-description {
				position: absolute;
				clip: rect(1px, 1px, 1px, 1px);
			}
		<?php
		// If the user has set a custom color for the text use that.
		else :
			?>
			.fp-site-title a,
			.fp-site-title {
				color: #<?php echo esc_attr( $header_text_color ); ?>;
			}
		<?php endif; ?>
		</style>
		<?php
	}
endif;

/**
 * Add CSS classes to footer nav menu links so they match the theme typography.
 *
 * @param array    $atts The HTML attributes applied to the menu item's <a> tag.
 * @param WP_Post  $item The current menu item.
 * @param stdClass $args An object of wp_nav_menu() arguments.
 * @return array
 */
function pixelpost_footer_nav_menu_link_atts( $atts, $item, $args ) {
	if ( isset( $args->theme_location ) && 'footer' === $args->theme_location ) {
		$classes = 'font-body-sm text-body-sm text-on-surface-variant hover:text-primary transition-colors';
		if ( empty( $atts['class'] ) ) {
			$atts['class'] = $classes;
		} else {
			$atts['class'] .= ' ' . $classes;
		}
	}
	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'pixelpost_footer_nav_menu_link_atts', 10, 3 );

/**
 * Add CSS classes to footer nav menu <li> items to remove bullets and default margins.
 *
 * @param array    $classes The CSS classes that are applied to the menu item's <li> element.
 * @param WP_Post  $item    The current menu item.
 * @param stdClass $args    An object of wp_nav_menu() arguments.
 * @return array
 */
function pixelpost_footer_nav_menu_item_classes( $classes, $item, $args ) {
	if ( isset( $args->theme_location ) && 'footer' === $args->theme_location ) {
		$classes[] = 'list-none';
		$classes[] = 'm-0';
		$classes[] = 'p-0';
	}
	return $classes;
}
add_filter( 'nav_menu_css_class', 'pixelpost_footer_nav_menu_item_classes', 10, 3 );
