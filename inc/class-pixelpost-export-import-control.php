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

					<div style="margin-bottom:14px;">
						<div id="fp-customizer-dropzone" style="border: 1.5px dashed #D3CEC6; border-radius: 8px; background: #FAF9F7; padding: 10px 12px; cursor: pointer; transition: all 0.2s ease;">
							<input type="file" id="pixelpost-customizer-import-file" accept=".json,application/json" style="position: absolute; width: 1px; height: 1px; opacity: 0; overflow: hidden; z-index: -1;" />
							
							<!-- Empty State -->
							<div id="fp-cust-upload-empty" style="display: flex; align-items: center; justify-content: space-between; gap: 8px;">
								<div style="display: flex; align-items: center; gap: 8px; min-width: 0; flex: 1;">
									<div style="width: 28px; height: 28px; border-radius: 6px; background: #FAF0E8; border: 1px solid #EFE4D8; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
										<span class="dashicons dashicons-media-text" style="color: #994200; font-size: 16px; width: 16px; height: 16px; line-height: 1;"></span>
									</div>
									<div style="min-width: 0; line-height: 1.3;">
										<span style="font-size: 12px; font-weight: 600; color: #44403C; display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><?php esc_html_e( 'No file selected', 'pixelpost' ); ?></span>
										<span style="font-size: 10px; color: #8C867E; display: block;"><?php esc_html_e( '.json backup file', 'pixelpost' ); ?></span>
									</div>
								</div>
								<button type="button" id="fp-cust-browse-btn" class="button" style="height: 26px; line-height: 24px; padding: 0 10px; font-size: 11px; font-weight: 600; flex-shrink: 0;">
									<?php esc_html_e( 'Browse Files', 'pixelpost' ); ?>
								</button>
							</div>

							<!-- Selected State -->
							<div id="fp-cust-upload-selected" style="display: none; align-items: center; justify-content: space-between; gap: 8px;">
								<div style="display: flex; align-items: center; gap: 8px; min-width: 0; flex: 1;">
									<div style="width: 28px; height: 28px; border-radius: 6px; background: #FAF0E8; border: 1px solid #EBD5C5; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
										<span class="dashicons dashicons-yes-alt" style="color: #28a745; font-size: 16px; width: 16px; height: 16px; line-height: 1;"></span>
									</div>
									<div style="min-width: 0; line-height: 1.3;">
										<span id="fp-cust-filename" style="font-size: 12px; font-weight: 700; color: #1C1A17; display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"></span>
										<span id="fp-cust-filesize" style="font-size: 10px; color: #28a745; display: block;"></span>
									</div>
								</div>
								<div style="display: flex; align-items: center; gap: 4px; flex-shrink: 0;">
									<button type="button" id="fp-cust-replace-btn" class="button" style="height: 26px; line-height: 24px; padding: 0 8px; font-size: 11px; font-weight: 600;">
										<?php esc_html_e( 'Replace', 'pixelpost' ); ?>
									</button>
									<button type="button" id="fp-cust-remove-btn" class="button" style="height: 26px; line-height: 24px; padding: 0 6px; font-size: 11px; color: #b32d2e;" title="<?php esc_attr_e( 'Remove file', 'pixelpost' ); ?>">✕</button>
								</div>
							</div>
						</div>
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
