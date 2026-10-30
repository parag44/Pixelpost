<?php
/**
 * Pixelpost Gutenberg Block Patterns
 *
 * @package Pixelpost
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Block Patterns & Categories
 */
function pixelpost_register_block_patterns() {
	if ( ! function_exists( 'register_block_pattern_category' ) ) {
		return;
	}

	register_block_pattern_category(
		'pixelpost',
		array( 'label' => __( 'Pixelpost Editorial', 'pixelpost' ) )
	);

	// Register Contact Section Pattern
	register_block_pattern(
		'pixelpost/contact-section',
		array(
			'title'       => __( 'Pixelpost Contact & Collaboration', 'pixelpost' ),
			'description' => __( 'Editorial two-column contact section matching Pixelpost design.', 'pixelpost' ),
			'categories'  => array( 'pixelpost' ),
			'content'     => '<!-- wp:group {"className":"fp-contact-block","layout":{"type":"constrained"}} -->
<div class="wp-block-group fp-contact-block"><!-- wp:columns {"className":"fp-contact-grid"} -->
<div class="wp-block-columns fp-contact-grid"><!-- wp:column {"className":"fp-contact-left"} -->
<div class="wp-block-column fp-contact-left"><!-- wp:paragraph {"className":"fp-contact-eyebrow"} -->
<p class="fp-contact-eyebrow">GET IN TOUCH</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2,"className":"fp-contact-heading"} -->
<h2 class="wp-block-heading fp-contact-heading">Let\'s Talk <span class="fp-contact-heading-accent">WordPress</span></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"fp-contact-description"} -->
<p class="fp-contact-description">Have a question, need support, or want to collaborate on a project? I\'m always open to discussing WordPress, technical challenges, or new ideas.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"className":"fp-contact-buttons"} -->
<div class="wp-block-buttons fp-contact-buttons"><!-- wp:button {"className":"fp-button fp-button-primary"} -->
<div class="wp-block-button fp-button fp-button-primary"><a class="wp-block-button__link wp-element-button" href="mailto:hello@example.com">Send an Email</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"fp-button fp-button-outline"} -->
<div class="wp-block-button fp-button fp-button-outline"><a class="wp-block-button__link wp-element-button" href="https://cal.com">Schedule a Call</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column {"className":"fp-contact-right"} -->
<div class="wp-block-column fp-contact-right"><!-- wp:group {"className":"fp-contact-card"} -->
<div class="wp-block-group fp-contact-card"><!-- wp:paragraph -->
<p><strong>EMAIL:</strong> hello@example.com<br><small>Best for project inquiries, support, or general questions.</small></p>
<!-- /wp:paragraph -->

<!-- wp:separator {"className":"is-style-wide"} -->
<hr class="wp-block-separator has-alpha-channel-opacity is-style-wide"/>
<!-- /wp:separator -->

<!-- wp:paragraph -->
<p><strong>LOCATION:</strong> San Francisco, CA<br><small>Open to remote work worldwide.</small></p>
<!-- /wp:paragraph -->

<!-- wp:separator {"className":"is-style-wide"} -->
<hr class="wp-block-separator has-alpha-channel-opacity is-style-wide"/>
<!-- /wp:separator -->

<!-- wp:paragraph -->
<p><strong>AVAILABILITY:</strong> Freelance &amp; Collaboration<br><small>Currently available for new projects and opportunities.</small></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->',
		)
	);
}
add_action( 'init', 'pixelpost_register_block_patterns' );
