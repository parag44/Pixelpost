<?php
/**
 * Pixelpost Customizer Export & Import Manager
 *
 * Allows exporting all Customizer settings, homepage content, colors,
 * logo configurations, and Additional CSS to a portable JSON file,
 * and importing it on a new site installation for fast, one-click site setup.
 *
 * @package Pixelpost
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Pixelpost_Export_Import
 */
class Pixelpost_Export_Import {

	/**
	 * Single instance of the class
	 *
	 * @var Pixelpost_Export_Import|null
	 */
	private static $instance = null;

	/**
	 * Get class instance
	 *
	 * @return Pixelpost_Export_Import
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor
	 */
	private function __construct() {
		// Register Customizer section and control
		add_action( 'customize_register', array( $this, 'customize_register' ), 95 );

		// Register Appearance submenu page
		add_action( 'admin_menu', array( $this, 'register_admin_menu' ) );

		// Handle direct export download via admin-post.php
		add_action( 'admin_post_pixelpost_export_customizer', array( $this, 'handle_export_download' ) );

		// Handle admin form import via admin-post.php
		add_action( 'admin_post_pixelpost_import_customizer', array( $this, 'handle_admin_import' ) );

		// Handle reset to demo defaults via admin-post.php
		add_action( 'admin_post_pixelpost_reset_demo_defaults', array( $this, 'handle_reset_demo_defaults' ) );

		// Handle AJAX import from Customizer
		add_action( 'wp_ajax_pixelpost_ajax_import_customizer', array( $this, 'handle_ajax_import' ) );

		// Enqueue scripts for Customizer controls
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_customizer_scripts' ) );

		// Display admin notices
		add_action( 'admin_notices', array( $this, 'render_admin_notices' ) );
	}

	/**
	 * Register Export / Import section in the WordPress Customizer
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer manager.
	 */
	public function customize_register( $wp_customize ) {
		// Add Section to Customizer
		$wp_customize->add_section(
			'pixelpost_export_import_section',
			array(
				'title'       => __( 'Export / Import Settings', 'pixelpost' ),
				'description' => __( 'Export your customizer settings as a backup or import settings from another site.', 'pixelpost' ),
				'panel'       => 'pixelpost_theme_options',
				'priority'    => 99,
			)
		);

		// Add Dummy Setting
		$wp_customize->add_setting(
			'pixelpost_export_import_dummy',
			array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		// Add Control
		$wp_customize->add_control(
			new Pixelpost_Export_Import_Control(
				$wp_customize,
				'pixelpost_export_import_control',
				array(
					'section'  => 'pixelpost_export_import_section',
					'settings' => 'pixelpost_export_import_dummy',
					'priority' => 10,
				)
			)
		);
	}

	/**
	 * Register Appearance submenu page for setup and migration
	 */
	public function register_admin_menu() {
		add_theme_page(
			__( 'Pixelpost Setup & Migration', 'pixelpost' ),
			__( 'Pixelpost Setup', 'pixelpost' ),
			'edit_theme_options',
			'pixelpost-setup',
			array( $this, 'render_admin_page' )
		);
	}

	/**
	 * Enqueue scripts for the Customizer controls pane
	 */
	public function enqueue_customizer_scripts() {
		wp_localize_script(
			'pixelpost-customizer-controls',
			'pixelpostExportImport',
			array(
				'ajax_url'        => admin_url( 'admin-ajax.php' ),
				'nonce'           => wp_create_nonce( 'pixelpost_export_import_nonce' ),
				'export_url'      => wp_nonce_url( admin_url( 'admin-post.php?action=pixelpost_export_customizer' ), 'pixelpost_export_customizer_nonce' ),
				'confirm_import'  => __( 'Are you sure you want to import these settings? Existing theme settings will be overwritten.', 'pixelpost' ),
				'importing_label' => __( 'Importing settings, please wait...', 'pixelpost' ),
				'success_label'   => __( 'Settings imported successfully! Reloading Customizer...', 'pixelpost' ),
				'select_file'     => __( 'Please select a valid .json export file first.', 'pixelpost' ),
			)
		);
	}

	/**
	 * Export full theme customizations into a clean data array
	 *
	 * @return array
	 */
	public function get_export_data() {
		$theme_mods = get_theme_mods();
		$defaults   = function_exists( 'pixelpost_get_theme_defaults' ) ? pixelpost_get_theme_defaults() : array();

		// Merge defaults with saved mods so the export file is 100% self-contained
		$merged_mods = array_merge( $defaults, is_array( $theme_mods ) ? $theme_mods : array() );

		// Clean up system/transient keys
		$clean_mods = array();
		foreach ( $merged_mods as $key => $val ) {
			if ( in_array( $key, array( 0, '0', 'custom_css_post_id', 'nav_menu_locations', 'sidebars_widgets' ), true ) ) {
				continue;
			}
			$clean_mods[ $key ] = $val;
		}

		// Custom logo URL fallback
		$custom_logo_url = '';
		$custom_logo_id  = get_theme_mod( 'custom_logo' );
		if ( ! empty( $custom_logo_id ) ) {
			$custom_logo_url = wp_get_attachment_image_url( $custom_logo_id, 'full' );
		}

		// Additional CSS
		$custom_css = function_exists( 'wp_get_custom_css' ) ? wp_get_custom_css() : '';

		// Nav Menu Locations
		$nav_menus = array();
		$locations = get_nav_menu_locations();
		if ( ! empty( $locations ) && is_array( $locations ) ) {
			foreach ( $locations as $loc => $menu_id ) {
				$term = get_term( $menu_id, 'nav_menu' );
				if ( $term && ! is_wp_error( $term ) ) {
					$nav_menus[ $loc ] = $term->name;
				}
			}
		}

		return array(
			'generator'       => 'Pixelpost Theme Setup & Migration',
			'theme'           => 'pixelpost',
			'version'         => defined( 'PIXELPOST_VERSION' ) ? PIXELPOST_VERSION : '2.0.7',
			'exported_at'     => gmdate( 'c' ),
			'site_url'        => untrailingslashit( home_url() ),
			'site_title'      => get_bloginfo( 'name' ),
			'site_tagline'    => get_bloginfo( 'description' ),
			'custom_logo_url' => $custom_logo_url,
			'custom_css'      => $custom_css,
			'nav_menus'       => $nav_menus,
			'mods'            => $clean_mods,
		);
	}

	/**
	 * Handle direct file download via admin-post.php
	 */
	public function handle_export_download() {
		if ( ! current_user_can( 'edit_theme_options' ) ) {
			wp_die( esc_html__( 'Sorry, you are not allowed to export theme settings.', 'pixelpost' ) );
		}

		check_admin_referer( 'pixelpost_export_customizer_nonce' );

		$export_data = $this->get_export_data();
		$json        = wp_json_encode( $export_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES );

		$filename = 'pixelpost-customizer-export-' . gmdate( 'Y-m-d-His' ) . '.json';

		// Set download headers
		nocache_headers();
		header( 'Content-Type: application/json; charset=utf-8' );
		header( 'Content-Disposition: attachment; filename="' . $filename . '"' );
		header( 'Content-Length: ' . strlen( $json ) );

		echo $json; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		exit;
	}

	/**
	 * Import customizer data from a JSON string or file
	 *
	 * @param string $json_string Raw JSON data.
	 * @param array  $args        Import arguments.
	 * @return array|WP_Error
	 */
	public function import_data( $json_string, $args = array() ) {
		if ( empty( $json_string ) ) {
			return new WP_Error( 'empty_data', __( 'Import file is empty.', 'pixelpost' ) );
		}

		$data = json_decode( $json_string, true );
		if ( ! is_array( $data ) ) {
			return new WP_Error( 'invalid_json', __( 'Import file does not contain valid JSON data.', 'pixelpost' ) );
		}

		// Support direct mods array or wrapped export format
		$mods = isset( $data['mods'] ) && is_array( $data['mods'] ) ? $data['mods'] : $data;

		if ( empty( $mods ) || ! is_array( $mods ) ) {
			return new WP_Error( 'missing_mods', __( 'No valid theme settings found in the import file.', 'pixelpost' ) );
		}

		$replace_urls = ! empty( $args['replace_urls'] );
		$import_css   = ! empty( $args['import_css'] );

		// 1. Domain URL Replacement
		if ( $replace_urls && ! empty( $data['site_url'] ) ) {
			$old_url = untrailingslashit( $data['site_url'] );
			$new_url = untrailingslashit( home_url() );

			if ( $old_url !== $new_url ) {
				$mods_json = wp_json_encode( $mods );
				// Replace unescaped and escaped URL variants
				$mods_json = str_replace( $old_url, $new_url, $mods_json );
				$mods_json = str_replace( str_replace( '/', '\/', $old_url ), str_replace( '/', '\/', $new_url ), $mods_json );
				$mods      = json_decode( $mods_json, true );
			}
		}

		// 2. Ensure current theme assets URL for built-in SVGs/images
		$current_assets = get_template_directory_uri() . '/assets/';
		$mods_json      = wp_json_encode( $mods );
		$mods_json      = preg_replace(
			'#https?://[^"\']+?/wp-content/themes/[^"\']+?/assets/#i',
			$current_assets,
			$mods_json
		);
		$mods = json_decode( $mods_json, true );

		// 3. Import each theme mod
		$imported_count = 0;
		foreach ( $mods as $key => $val ) {
			if ( ! is_string( $key ) || in_array( $key, array( '0', 'custom_css_post_id', 'nav_menu_locations', 'sidebars_widgets' ), true ) ) {
				continue;
			}
			set_theme_mod( $key, $val );
			$imported_count++;
		}

		// 4. Handle Custom Logo if URL is available and current logo is empty
		if ( ! empty( $data['custom_logo_url'] ) && ! has_custom_logo() ) {
			$logo_url = esc_url_raw( $data['custom_logo_url'] );
			if ( $replace_urls && ! empty( $data['site_url'] ) ) {
				$logo_url = str_replace( untrailingslashit( $data['site_url'] ), untrailingslashit( home_url() ), $logo_url );
			}

			// Try to sideload the logo into media library
			if ( function_exists( 'media_sideload_image' ) || file_exists( ABSPATH . 'wp-admin/includes/media.php' ) ) {
				require_once ABSPATH . 'wp-admin/includes/media.php';
				require_once ABSPATH . 'wp-admin/includes/file.php';
				require_once ABSPATH . 'wp-admin/includes/image.php';

				$attachment_id = media_sideload_image( $logo_url, 0, 'Site Logo', 'id' );
				if ( ! is_wp_error( $attachment_id ) ) {
					set_theme_mod( 'custom_logo', $attachment_id );
				}
			}
		}

		// 5. Additional CSS
		if ( $import_css && ! empty( $data['custom_css'] ) && function_exists( 'wp_update_custom_css_post' ) ) {
			wp_update_custom_css_post( $data['custom_css'] );
		}

		// 6. Site Title & Tagline (if options requested)
		if ( ! empty( $args['import_site_identity'] ) ) {
			if ( ! empty( $data['site_title'] ) ) {
				update_option( 'blogname', sanitize_text_field( $data['site_title'] ) );
			}
			if ( ! empty( $data['site_tagline'] ) ) {
				update_option( 'blogdescription', sanitize_text_field( $data['site_tagline'] ) );
			}
		}

		// 7. Flush cache
		if ( function_exists( 'wp_cache_flush' ) ) {
			wp_cache_flush();
		}

		return array(
			'success' => true,
			'count'   => $imported_count,
			'message' => sprintf(
				/* translators: %d: number of settings */
				__( 'Successfully imported %d Customizer settings!', 'pixelpost' ),
				$imported_count
			),
		);
	}

	/**
	 * Handle AJAX import from the Customizer controls pane
	 */
	public function handle_ajax_import() {
		check_ajax_referer( 'pixelpost_export_import_nonce', 'nonce' );

		if ( ! current_user_can( 'edit_theme_options' ) ) {
			wp_send_json_error( array( 'message' => __( 'Permission denied.', 'pixelpost' ) ) );
		}

		$json_data = isset( $_POST['json_data'] ) ? wp_unslash( $_POST['json_data'] ) : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
		if ( empty( $json_data ) ) {
			wp_send_json_error( array( 'message' => __( 'No file content received.', 'pixelpost' ) ) );
		}

		$args = array(
			'replace_urls' => ! empty( $_POST['replace_urls'] ),
			'import_css'   => ! empty( $_POST['import_css'] ),
		);

		$result = $this->import_data( $json_data, $args );

		if ( is_wp_error( $result ) ) {
			wp_send_json_error( array( 'message' => $result->get_error_message() ) );
		}

		wp_send_json_success( $result );
	}

	/**
	 * Handle file upload from the Appearance -> Pixelpost Setup admin page
	 */
	public function handle_admin_import() {
		if ( ! current_user_can( 'edit_theme_options' ) ) {
			wp_die( esc_html__( 'Sorry, you are not allowed to import theme settings.', 'pixelpost' ) );
		}

		check_admin_referer( 'pixelpost_admin_import_nonce' );

		if ( empty( $_FILES['pixelpost_import_file']['tmp_name'] ) || ! is_uploaded_file( $_FILES['pixelpost_import_file']['tmp_name'] ) ) {
			wp_safe_redirect( add_query_arg( array( 'page' => 'pixelpost-setup', 'status' => 'no_file' ), admin_url( 'themes.php' ) ) );
			exit;
		}

		// Read uploaded file
		$file_content = file_get_contents( $_FILES['pixelpost_import_file']['tmp_name'] ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized

		$args = array(
			'replace_urls'         => ! empty( $_POST['replace_urls'] ),
			'import_css'           => ! empty( $_POST['import_css'] ),
			'import_site_identity' => ! empty( $_POST['import_site_identity'] ),
		);

		$result = $this->import_data( $file_content, $args );

		if ( is_wp_error( $result ) ) {
			wp_safe_redirect( add_query_arg( array( 'page' => 'pixelpost-setup', 'status' => 'error', 'msg' => rawurlencode( $result->get_error_message() ) ), admin_url( 'themes.php' ) ) );
			exit;
		}

		wp_safe_redirect( add_query_arg( array( 'page' => 'pixelpost-setup', 'status' => 'success', 'count' => absint( $result['count'] ) ), admin_url( 'themes.php' ) ) );
		exit;
	}

	/**
	 * Reset theme settings to clean demo defaults
	 */
	public function handle_reset_demo_defaults() {
		if ( ! current_user_can( 'edit_theme_options' ) ) {
			wp_die( esc_html__( 'Permission denied.', 'pixelpost' ) );
		}

		check_admin_referer( 'pixelpost_reset_demo_nonce' );

		if ( function_exists( 'pixelpost_get_theme_defaults' ) ) {
			$defaults = pixelpost_get_theme_defaults();
			foreach ( $defaults as $key => $val ) {
				set_theme_mod( $key, $val );
			}
		}

		if ( function_exists( 'wp_cache_flush' ) ) {
			wp_cache_flush();
		}

		wp_safe_redirect( add_query_arg( array( 'page' => 'pixelpost-setup', 'status' => 'reset_success' ), admin_url( 'themes.php' ) ) );
		exit;
	}

	/**
	 * Render admin notices on themes.php?page=pixelpost-setup
	 */
	public function render_admin_notices() {
		$screen = get_current_screen();
		if ( ! $screen || 'appearance_page_pixelpost-setup' !== $screen->id ) {
			return;
		}

		$status = isset( $_GET['status'] ) ? sanitize_key( $_GET['status'] ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( empty( $status ) ) {
			return;
		}

		if ( 'success' === $status ) {
			$count = isset( $_GET['count'] ) ? absint( $_GET['count'] ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			?>
			<div class="notice notice-success is-dismissible" style="border-left-color:#994200;">
				<p>
					<strong><?php esc_html_e( 'Success!', 'pixelpost' ); ?></strong>
					<?php
					printf(
						/* translators: %d: count */
						esc_html__( 'Imported %d theme settings successfully. Your site is now configured!', 'pixelpost' ),
						$count
					);
					?>
					<a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="button button-secondary" style="margin-left:12px;"><?php esc_html_e( 'Open Customizer', 'pixelpost' ); ?></a>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" target="_blank" class="button button-primary" style="margin-left:6px;"><?php esc_html_e( 'View Site ↗', 'pixelpost' ); ?></a>
				</p>
			</div>
			<?php
		} elseif ( 'reset_success' === $status ) {
			?>
			<div class="notice notice-success is-dismissible" style="border-left-color:#994200;">
				<p>
					<strong><?php esc_html_e( 'Success!', 'pixelpost' ); ?></strong>
					<?php esc_html_e( 'Theme settings have been restored to clean demo defaults.', 'pixelpost' ); ?>
					<a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="button button-secondary" style="margin-left:12px;"><?php esc_html_e( 'Open Customizer', 'pixelpost' ); ?></a>
				</p>
			</div>
			<?php
		} elseif ( 'error' === $status ) {
			$msg = isset( $_GET['msg'] ) ? sanitize_text_field( wp_unslash( $_GET['msg'] ) ) : __( 'An error occurred during import.', 'pixelpost' ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			?>
			<div class="notice notice-error is-dismissible">
				<p><strong><?php esc_html_e( 'Import Error:', 'pixelpost' ); ?></strong> <?php echo esc_html( $msg ); ?></p>
			</div>
			<?php
		} elseif ( 'no_file' === $status ) {
			?>
			<div class="notice notice-warning is-dismissible">
				<p><?php esc_html_e( 'Please select a valid .json export file to import.', 'pixelpost' ); ?></p>
			</div>
			<?php
		}
	}

	/**
	 * Render the full Appearance -> Pixelpost Setup admin dashboard page
	 */
	public function render_admin_page() {
		if ( ! current_user_can( 'edit_theme_options' ) ) {
			wp_die( esc_html__( 'Sorry, you are not allowed to access this page.', 'pixelpost' ) );
		}

		$export_url = wp_nonce_url(
			admin_url( 'admin-post.php?action=pixelpost_export_customizer' ),
			'pixelpost_export_customizer_nonce'
		);

		$theme_version = defined( 'PIXELPOST_VERSION' ) ? PIXELPOST_VERSION : '2.0.7';
		$site_url      = home_url();
		$theme_mods    = get_theme_mods();
		$mods_count    = is_array( $theme_mods ) ? count( $theme_mods ) : 0;
		?>
		<div class="wrap pixelpost-setup-wrap" style="max-width:1120px; margin:24px auto; font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
			<!-- Header Banner -->
			<div style="background:#FAF9F6; border:1px solid #E9E6E0; border-radius:10px; padding:28px 32px; margin-bottom:28px; box-shadow:0 1px 3px rgba(0,0,0,0.03); display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:20px;">
				<div>
					<div style="display:inline-block; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:1.5px; color:#994200; margin-bottom:8px;">
						<?php esc_html_e( 'Pixelpost Editorial Portfolio', 'pixelpost' ); ?> · v<?php echo esc_html( $theme_version ); ?>
					</div>
					<h1 style="margin:0 0 8px 0; font-size:26px; font-weight:700; color:#1C1A17; font-family:Georgia, serif;">
						<?php esc_html_e( 'Theme Setup & Migration', 'pixelpost' ); ?>
					</h1>
					<p style="margin:0; font-size:14px; color:#6B665F; max-width:640px; line-height:1.5;">
						<?php esc_html_e( 'Export your complete portfolio setup to easily backup your content, or import settings onto a brand new site installation with one click.', 'pixelpost' ); ?>
					</p>
				</div>
				<div style="display:flex; gap:10px;">
					<a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="button button-primary" style="background:#994200; border-color:#803700; height:38px; line-height:36px; padding:0 18px; font-weight:600;">
						<?php esc_html_e( 'Open Customizer', 'pixelpost' ); ?>
					</a>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" target="_blank" class="button button-secondary" style="height:38px; line-height:36px; padding:0 16px;">
						<?php esc_html_e( 'View Live Site ↗', 'pixelpost' ); ?>
					</a>
				</div>
			</div>

			<!-- Main 2-Column Grid -->
			<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(360px, 1fr)); gap:24px; margin-bottom:28px;">
				
				<!-- CARD 1: EXPORT -->
				<div style="background:#FFFFFF; border:1px solid #E9E6E0; border-radius:10px; padding:28px; box-shadow:0 1px 3px rgba(0,0,0,0.03); display:flex; flex-col; justify-content:space-between;">
					<div>
						<div style="width:42px; height:42px; border-radius:8px; background:#FAF0E8; display:flex; align-items:center; justify-content:center; margin-bottom:16px;">
							<span class="dashicons dashicons-download" style="font-size:22px; color:#994200; line-height:1;"></span>
						</div>
						<h2 style="margin:0 0 8px 0; font-size:18px; font-weight:700; color:#1C1A17;">
							<?php esc_html_e( 'Export Customizer Data', 'pixelpost' ); ?>
						</h2>
						<p style="margin:0 0 16px 0; font-size:13px; color:#6B665F; line-height:1.5;">
							<?php esc_html_e( 'Creates a downloadable JSON file containing all theme settings and custom content. You can import this into any new Pixelpost installation.', 'pixelpost' ); ?>
						</p>

						<div style="background:#FAF9F6; border:1px solid #EFECE6; border-radius:6px; padding:12px 14px; margin-bottom:20px; font-size:12px; color:#4A4640;">
							<strong style="display:block; margin-bottom:6px; color:#1C1A17;"><?php esc_html_e( 'Included in Export:', 'pixelpost' ); ?></strong>
							<ul style="margin:0; padding-left:16px; line-height:1.6;">
								<li><?php esc_html_e( 'Hero section (headline, intro, CTA buttons, indicators)', 'pixelpost' ); ?></li>
								<li><?php esc_html_e( 'Projects I’ve built (all 4 project cards, links, SVGs)', 'pixelpost' ); ?></li>
								<li><?php esc_html_e( 'Skills categorized items & Work Experience timeline', 'pixelpost' ); ?></li>
								<li><?php esc_html_e( 'Statistics metrics & About Me attributes', 'pixelpost' ); ?></li>
								<li><?php esc_html_e( 'Brand display (text vs logo, dimensions, tagline)', 'pixelpost' ); ?></li>
								<li><?php esc_html_e( 'Footer social links, copyright, and Additional CSS', 'pixelpost' ); ?></li>
							</ul>
						</div>
					</div>

					<a href="<?php echo esc_url( $export_url ); ?>" class="button button-primary" style="background:#994200; border-color:#803700; width:100%; text-align:center; height:40px; line-height:38px; font-size:13px; font-weight:600; display:flex; align-items:center; justify-content:center; gap:8px;">
						<span class="dashicons dashicons-download" style="margin-top:2px;"></span>
						<?php esc_html_e( 'Download Export File (.json)', 'pixelpost' ); ?>
					</a>
				</div>

				<!-- CARD 2: IMPORT -->
				<div style="background:#FFFFFF; border:1px solid #E9E6E0; border-radius:10px; padding:28px; box-shadow:0 1px 3px rgba(0,0,0,0.03);">
					<div style="width:42px; height:42px; border-radius:8px; background:#EBF4FA; display:flex; align-items:center; justify-content:center; margin-bottom:16px;">
						<span class="dashicons dashicons-upload" style="font-size:22px; color:#2271b1; line-height:1;"></span>
					</div>
					<h2 style="margin:0 0 8px 0; font-size:18px; font-weight:700; color:#1C1A17;">
						<?php esc_html_e( 'Import Customizer Data', 'pixelpost' ); ?>
					</h2>
					<p style="margin:0 0 16px 0; font-size:13px; color:#6B665F; line-height:1.5;">
						<?php esc_html_e( 'Upload your exported JSON file to immediately configure this site to match your previous setup.', 'pixelpost' ); ?>
					</p>

					<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" enctype="multipart/form-data">
						<input type="hidden" name="action" value="pixelpost_import_customizer" />
						<?php wp_nonce_field( 'pixelpost_admin_import_nonce' ); ?>

						<div style="margin-bottom:16px;">
							<label for="pixelpost_import_file_input" style="display:block; font-weight:600; font-size:13px; color:#1C1A17; margin-bottom:6px;">
								<?php esc_html_e( 'Choose Export File (.json):', 'pixelpost' ); ?>
							</label>
							<input type="file" id="pixelpost_import_file_input" name="pixelpost_import_file" accept=".json,application/json" required="required" style="width:100%; padding:8px; border:1px dashed #CCD0D4; border-radius:6px; background:#FAF9F6;" />
						</div>

						<div style="background:#FAF9F6; border:1px solid #EFECE6; border-radius:6px; padding:14px; margin-bottom:20px; font-size:12px;">
							<label style="display:block; margin-bottom:8px; cursor:pointer;">
								<input type="checkbox" name="replace_urls" value="1" checked="checked" />
								<strong><?php esc_html_e( 'Replace domain URLs automatically', 'pixelpost' ); ?></strong>
								<span style="display:block; color:#6B665F; margin-left:22px; font-size:11px;">
									<?php esc_html_e( 'Converts previous site URLs (e.g. image assets) to this current site URL:', 'pixelpost' ); ?>
									<code><?php echo esc_html( $site_url ); ?></code>
								</span>
							</label>

							<label style="display:block; margin-bottom:8px; cursor:pointer;">
								<input type="checkbox" name="import_css" value="1" checked="checked" />
								<strong><?php esc_html_e( 'Import Custom CSS', 'pixelpost' ); ?></strong>
							</label>

							<label style="display:block; cursor:pointer;">
								<input type="checkbox" name="import_site_identity" value="1" />
								<strong><?php esc_html_e( 'Import Site Title & Tagline', 'pixelpost' ); ?></strong>
							</label>
						</div>

						<button type="submit" class="button button-secondary" style="width:100%; text-align:center; height:40px; line-height:38px; font-size:13px; font-weight:600; display:flex; align-items:center; justify-content:center; gap:8px;" onclick="return confirm('<?php echo esc_js( __( 'Are you sure you want to import this configuration? Current customizer settings will be overwritten.', 'pixelpost' ) ); ?>');">
							<span class="dashicons dashicons-upload" style="margin-top:2px;"></span>
							<?php esc_html_e( 'Upload & Apply Settings', 'pixelpost' ); ?>
						</button>
					</form>
				</div>
			</div>

			<!-- CARD 3: RESET TO CLEAN DEMO DEFAULTS -->
			<div style="background:#FFFFFF; border:1px solid #E9E6E0; border-radius:10px; padding:24px 28px; box-shadow:0 1px 3px rgba(0,0,0,0.03); display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:20px;">
				<div>
					<h3 style="margin:0 0 6px 0; font-size:15px; font-weight:700; color:#1C1A17;">
						<?php esc_html_e( 'Reset to Clean Demo Defaults', 'pixelpost' ); ?>
					</h3>
					<p style="margin:0; font-size:13px; color:#6B665F; line-height:1.4;">
						<?php esc_html_e( 'Reset all homepage sections, sample portfolio projects, skills, and styling back to the clean theme demo defaults.', 'pixelpost' ); ?>
					</p>
				</div>
				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
					<input type="hidden" name="action" value="pixelpost_reset_demo_defaults" />
					<?php wp_nonce_field( 'pixelpost_reset_demo_nonce' ); ?>
					<button type="submit" class="button" style="color:#b32d2e; border-color:#d63638; height:36px; line-height:34px; font-weight:600;" onclick="return confirm('<?php echo esc_js( __( 'Warning: This will overwrite all your current customizations with the theme demo defaults. Proceed?', 'pixelpost' ) ); ?>');">
						<?php esc_html_e( 'Restore Demo Defaults', 'pixelpost' ); ?>
					</button>
				</form>
			</div>
		</div>
		<?php
	}
}

// Initialize Export / Import manager
Pixelpost_Export_Import::get_instance();

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
