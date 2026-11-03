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
			<div class="pixelpost-export-import-wrap" style="background:#fff; border:1px solid #ccd0d4; border-radius:8px; padding:16px; margin-top:8px; box-sizing:border-box;">
				<!-- Export Card -->
				<div style="margin-bottom:20px;">
					<div style="display:flex; align-items:center; gap:8px; margin-bottom:8px;">
						<div style="width:24px; height:24px; border-radius:6px; background:#FAF0E8; border:1px solid #EFE4D8; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
							<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#994200" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="display:block;">
								<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
								<polyline points="7 10 12 15 17 10"></polyline>
								<line x1="12" y1="15" x2="12" y2="3"></line>
							</svg>
						</div>
						<h3 style="margin:0; font-size:13px; font-weight:700; color:#1e1e1e; line-height:1.2;">
							<?php esc_html_e( 'Export Settings', 'pixelpost' ); ?>
						</h3>
					</div>
					<p class="description" style="margin-bottom:12px; font-size:12px; line-height:1.5; color:#50575e;">
						<?php esc_html_e( 'Download all your theme settings, homepage content, branding, colors, and Additional CSS into a single portable backup file.', 'pixelpost' ); ?>
					</p>
					<a href="<?php echo esc_url( $export_url ); ?>" class="button button-primary fp-btn-export-download" style="width:100%; height:34px; line-height:normal; font-weight:600; font-size:12px; display:inline-flex; align-items:center; justify-content:center; gap:8px; box-sizing:border-box; text-decoration:none;">
						<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="display:block; flex-shrink:0;">
							<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
							<polyline points="7 10 12 15 17 10"></polyline>
							<line x1="12" y1="15" x2="12" y2="3"></line>
						</svg>
						<span><?php esc_html_e( 'Download Export (.json)', 'pixelpost' ); ?></span>
					</a>
				</div>

				<hr style="border:none; border-top:1px solid #e2e4e7; margin:16px 0;" />

				<!-- Import Card -->
				<div>
					<div style="display:flex; align-items:center; gap:8px; margin-bottom:8px;">
						<div style="width:24px; height:24px; border-radius:6px; background:#EEF4FB; border:1px solid #D6E4F4; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
							<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#2271b1" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="display:block;">
								<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
								<polyline points="17 8 12 3 7 8"></polyline>
								<line x1="12" y1="3" x2="12" y2="15"></line>
							</svg>
						</div>
						<h3 style="margin:0; font-size:13px; font-weight:700; color:#1e1e1e; line-height:1.2;">
							<?php esc_html_e( 'Import Settings', 'pixelpost' ); ?>
						</h3>
					</div>
					<p class="description" style="margin-bottom:12px; font-size:12px; line-height:1.5; color:#50575e;">
						<?php esc_html_e( 'Upload a previously exported .json file to restore or apply settings to this site installation.', 'pixelpost' ); ?>
					</p>

					<div style="margin-bottom:14px;">
						<div id="fp-customizer-dropzone" style="border: 1.5px dashed #D3CEC6; border-radius: 8px; background: #FAF9F7; padding: 10px 12px; cursor: pointer; transition: all 0.2s ease;">
							<input type="file" id="pixelpost-customizer-import-file" accept=".json,application/json" style="position: absolute; width: 1px; height: 1px; opacity: 0; overflow: hidden; z-index: -1;" />
							
							<!-- Empty State -->
							<div id="fp-cust-upload-empty" style="display: flex; align-items: center; justify-content: space-between; gap: 8px; width: 100%;">
								<div style="display: flex; align-items: center; gap: 8px; min-width: 0; flex: 1;">
									<div style="width: 28px; height: 28px; border-radius: 6px; background: #FAF0E8; border: 1px solid #EFE4D8; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
										<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#994200" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:block;">
											<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
											<polyline points="14 2 14 8 20 8"></polyline>
											<line x1="16" y1="13" x2="8" y2="13"></line>
											<line x1="16" y1="17" x2="8" y2="17"></line>
											<polyline points="10 9 9 9 8 9"></polyline>
										</svg>
									</div>
									<div style="min-width: 0; line-height: 1.3;">
										<span style="font-size: 12px; font-weight: 600; color: #44403C; display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><?php esc_html_e( 'No file selected', 'pixelpost' ); ?></span>
										<span style="font-size: 10px; color: #8C867E; display: block;"><?php esc_html_e( '.json backup file', 'pixelpost' ); ?></span>
									</div>
								</div>
								<button type="button" id="fp-cust-browse-btn" class="button" style="height: 26px; line-height: normal; padding: 0 10px; font-size: 11px; font-weight: 600; flex-shrink: 0; display: inline-flex; align-items: center; justify-content: center;">
									<?php esc_html_e( 'Browse Files', 'pixelpost' ); ?>
								</button>
							</div>

							<!-- Selected State -->
							<div id="fp-cust-upload-selected" style="display: none; align-items: center; justify-content: space-between; gap: 8px; width: 100%;">
								<div style="display: flex; align-items: center; gap: 8px; min-width: 0; flex: 1;">
									<div style="width: 28px; height: 28px; border-radius: 6px; background: #E8F5E9; border: 1px solid #C8E6C9; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
										<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#28a745" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display:block;">
											<polyline points="20 6 9 17 4 12"></polyline>
										</svg>
									</div>
									<div style="min-width: 0; line-height: 1.3;">
										<span id="fp-cust-filename" style="font-size: 12px; font-weight: 700; color: #1C1A17; display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"></span>
										<span id="fp-cust-filesize" style="font-size: 10px; color: #28a745; display: block;"></span>
									</div>
								</div>
								<div style="display: flex; align-items: center; gap: 4px; flex-shrink: 0;">
									<button type="button" id="fp-cust-replace-btn" class="button" style="height: 26px; line-height: normal; padding: 0 8px; font-size: 11px; font-weight: 600; display: inline-flex; align-items: center; justify-content: center;">
										<?php esc_html_e( 'Replace', 'pixelpost' ); ?>
									</button>
									<button type="button" id="fp-cust-remove-btn" class="button" style="height: 26px; width: 26px; line-height: normal; padding: 0; display: inline-flex; align-items: center; justify-content: center; font-size: 11px; color: #b32d2e;" title="<?php esc_attr_e( 'Remove file', 'pixelpost' ); ?>">
										<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display:block;">
											<line x1="18" y1="6" x2="6" y2="18"></line>
											<line x1="6" y1="6" x2="18" y2="18"></line>
										</svg>
									</button>
								</div>
							</div>
						</div>
					</div>

					<div style="margin-bottom:14px; font-size:12px; line-height:1.4;">
						<label style="display:flex; align-items:flex-start; gap:8px; margin-bottom:8px; cursor:pointer;">
							<input type="checkbox" id="pixelpost-import-opt-replace-urls" value="1" checked="checked" style="margin-top:2px; flex-shrink:0;" />
							<div>
								<strong style="display:block; color:#1e1e1e; font-size:12px;"><?php esc_html_e( 'Replace domain URLs', 'pixelpost' ); ?></strong>
								<span style="display:block; color:#646970; font-size:11px;"><?php esc_html_e( 'Converts exported asset URLs to this site URL.', 'pixelpost' ); ?></span>
							</div>
						</label>
						<label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
							<input type="checkbox" id="pixelpost-import-opt-css" value="1" checked="checked" style="margin:0; flex-shrink:0;" />
							<strong style="color:#1e1e1e; font-size:12px;"><?php esc_html_e( 'Import Additional CSS', 'pixelpost' ); ?></strong>
						</label>
					</div>

					<button type="button" id="pixelpost-btn-import-trigger" class="button button-secondary" style="width:100%; height:34px; line-height:normal; font-weight:600; font-size:12px; display:inline-flex; align-items:center; justify-content:center; gap:8px; box-sizing:border-box; cursor:pointer;">
						<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="display:block; flex-shrink:0;">
							<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
							<polyline points="17 8 12 3 7 8"></polyline>
							<line x1="12" y1="3" x2="12" y2="15"></line>
						</svg>
						<span><?php esc_html_e( 'Import & Apply Settings', 'pixelpost' ); ?></span>
					</button>

					<div id="pixelpost-import-feedback" style="margin-top:12px; display:none; padding:10px 12px; font-size:12px; border-radius:6px; line-height:1.4;"></div>
				</div>
			</div>
			<?php
		}
	}
}
