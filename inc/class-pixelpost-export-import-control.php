<?php
/**
 * Pixelpost Customizer Export / Import Control
 *
 * Renders the Export & Import UI card directly inside the WordPress Customizer pane.
 *
 * @package Pixelpost
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Pixelpost_Export_Import_Control' ) ) {
	/**
	 * Custom control for Export / Import in Customizer
	 */
	class Pixelpost_Export_Import_Control extends WP_Customize_Control {
		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'pixelpost-export-import';

		/**
		 * Render control content
		 */
		public function render_content() {
			$export_url = wp_nonce_url(
				admin_url( 'admin-post.php?action=pixelpost_export_customizer' ),
				'pixelpost_export_customizer_nonce'
			);
			?>
			<div class="pixelpost-export-import-wrap" style="background:#fff; border:1px solid #ccd0d4; border-radius:6px; padding:16px; margin-top:8px;">
				<!-- Export Card -->
				<div style="margin-bottom:20px;">
					<h3 style="margin-top:0; margin-bottom:8px; font-size:14px; font-weight:600; color:#1e1e1e;">
						<span class="dashicons dashicons-download" style="font-size:18px; line-height:1; vertical-align:middle; margin-right:4px; color:#994200;"></span>
						<?php esc_html_e( 'Export Settings', 'pixelpost' ); ?>
					</h3>
					<p class="description" style="margin-bottom:12px; font-size:12px; line-height:1.5;">
						<?php esc_html_e( 'Download all your theme settings, homepage content, branding, colors, and Additional CSS into a single portable backup file.', 'pixelpost' ); ?>
					</p>
					<a href="<?php echo esc_url( $export_url ); ?>" class="button button-primary fp-btn-export-download" style="width:100%; text-align:center; height:34px; line-height:32px; font-weight:600; display:flex; align-items:center; justify-content:center; gap:6px;">
						<span class="dashicons dashicons-download" style="margin-top:2px;"></span>
						<?php esc_html_e( 'Download Export (.json)', 'pixelpost' ); ?>
					</a>
				</div>

				<hr style="border:none; border-top:1px solid #e2e4e7; margin:16px 0;" />

				<!-- Import Card -->
				<div>
					<h3 style="margin-top:0; margin-bottom:8px; font-size:14px; font-weight:600; color:#1e1e1e;">
						<span class="dashicons dashicons-upload" style="font-size:18px; line-height:1; vertical-align:middle; margin-right:4px; color:#2271b1;"></span>
						<?php esc_html_e( 'Import Settings', 'pixelpost' ); ?>
					</h3>
					<p class="description" style="margin-bottom:12px; font-size:12px; line-height:1.5;">
						<?php esc_html_e( 'Upload a previously exported .json file to restore or apply settings to this site installation.', 'pixelpost' ); ?>
					</p>

					<div style="margin-bottom:12px;">
						<input type="file" id="pixelpost-customizer-import-file" accept=".json,application/json" style="width:100%; font-size:12px;" />
					</div>

					<div style="margin-bottom:14px; font-size:12px; line-height:1.4;">
						<label style="display:block; margin-bottom:6px; cursor:pointer;">
							<input type="checkbox" id="pixelpost-import-opt-replace-urls" value="1" checked="checked" />
							<strong><?php esc_html_e( 'Replace domain URLs', 'pixelpost' ); ?></strong>
							<span style="display:block; color:#646970; font-size:11px; margin-left:20px;"><?php esc_html_e( 'Converts exported asset URLs to this site URL.', 'pixelpost' ); ?></span>
						</label>
						<label style="display:block; cursor:pointer;">
							<input type="checkbox" id="pixelpost-import-opt-css" value="1" checked="checked" />
							<strong><?php esc_html_e( 'Import Additional CSS', 'pixelpost' ); ?></strong>
						</label>
					</div>

					<button type="button" id="pixelpost-btn-import-trigger" class="button button-secondary" style="width:100%; text-align:center; height:34px; line-height:32px; font-weight:600; display:flex; align-items:center; justify-content:center; gap:6px;">
						<span class="dashicons dashicons-upload" style="margin-top:2px;"></span>
						<?php esc_html_e( 'Import & Apply Settings', 'pixelpost' ); ?>
					</button>

					<div id="pixelpost-import-feedback" style="margin-top:12px; display:none; padding:8px 12px; font-size:12px; border-radius:4px; line-height:1.4;"></div>
				</div>
			</div>
			<?php
		}
	}
}
