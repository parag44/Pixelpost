<?php
/**
 * Pixelpost Customizer Export & Import Manager
 *
 * Allows exporting all Customizer settings, homepage content, colors,
 * logo configurations, repeaters, and Additional CSS to a portable JSON file,
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

		// Enqueue scripts for Customizer controls (priority 30 to run after control scripts)
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_customizer_scripts' ), 30 );

		// Display admin notices
		add_action( 'admin_notices', array( $this, 'render_admin_notices' ) );
	}

	/**
	 * Register Export / Import section in the WordPress Customizer
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer manager.
	 */
	public function customize_register( $wp_customize ) {
		// Ensure control class is loaded safely when WP_Customize_Control exists
		if ( ! class_exists( 'Pixelpost_Export_Import_Control' ) ) {
			require_once PIXELPOST_DIR . '/inc/class-pixelpost-export-import-control.php';
		}

		// Add Section to Customizer (visible at root level for quick access)
		$wp_customize->add_section(
			'pixelpost_export_import_section',
			array(
				'title'       => __( 'Export / Import Settings', 'pixelpost' ),
				'description' => __( 'Export all customizer settings, content, and branding as a portable backup or import onto this site.', 'pixelpost' ),
				'priority'    => 200,
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
	 * Export full theme customizations into a complete, self-contained data array
	 *
	 * Guarantees all theme settings, repeaters, branding, and custom CSS are exported.
	 *
	 * @return array
	 */
	public function get_export_data() {
		$theme_mods = get_theme_mods();
		if ( ! is_array( $theme_mods ) ) {
			$theme_mods = array();
		}

		$defaults = function_exists( 'pixelpost_get_theme_defaults' ) ? pixelpost_get_theme_defaults() : array();

		$clean_mods = array();

		// 1. Resolve every single registered Pixelpost setting to its active, effective value
		// pixelpost_get_setting() checks pixelpost_* in DB, then legacy foliopress_* in DB, then default!
		foreach ( $defaults as $key => $default_val ) {
			if ( function_exists( 'pixelpost_get_setting' ) ) {
				$val = pixelpost_get_setting( $key );
			} elseif ( isset( $theme_mods[ $key ] ) ) {
				$val = $theme_mods[ $key ];
			} else {
				$val = $default_val;
			}
			$clean_mods[ $key ] = $val;
		}

		// 2. Also incorporate any additional theme mods saved in the database
		foreach ( $theme_mods as $key => $val ) {
			if ( in_array( $key, array( 0, '0', 'custom_css_post_id', 'nav_menu_locations', 'sidebars_widgets' ), true ) ) {
				continue;
			}

			// If it's a legacy foliopress_ key, normalize to pixelpost_ if not already set or empty
			if ( strpos( $key, 'foliopress_' ) === 0 ) {
				$norm_key = 'pixelpost_' . substr( $key, 11 );
				if ( ! isset( $clean_mods[ $norm_key ] ) || empty( $clean_mods[ $norm_key ] ) ) {
					$clean_mods[ $norm_key ] = $val;
				}
				// Also include legacy key so both are retained
				$clean_mods[ $key ] = $val;
			} else {
				$clean_mods[ $key ] = $val;
			}
		}

		// 3. Custom logo URL and attachment details
		$custom_logo_url = '';
		$custom_logo_id  = get_theme_mod( 'custom_logo' );
		if ( ! empty( $custom_logo_id ) ) {
			$custom_logo_url = wp_get_attachment_image_url( $custom_logo_id, 'full' );
		}

		// 4. Site icon (favicon)
		$site_icon_url = '';
		$site_icon_id  = get_option( 'site_icon' );
		if ( ! empty( $site_icon_id ) ) {
			$site_icon_url = wp_get_attachment_image_url( $site_icon_id, 'full' );
		}

		// 5. Additional CSS
		$custom_css = function_exists( 'wp_get_custom_css' ) ? wp_get_custom_css() : '';

		// 6. Homepage & Reading options
		$homepage_settings = array(
			'show_on_front'  => get_option( 'show_on_front' ),
			'page_on_front'  => get_option( 'page_on_front' ),
			'page_for_posts' => get_option( 'page_for_posts' ),
		);

		// 7. Nav Menu Locations
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
			'generator'         => 'Pixelpost Theme Setup & Migration',
			'theme'             => 'pixelpost',
			'version'           => defined( 'PIXELPOST_VERSION' ) ? PIXELPOST_VERSION : '1.0.2',
			'exported_at'       => gmdate( 'c' ),
			'source_site_url'   => untrailingslashit( home_url() ),
			'site_title'        => get_bloginfo( 'name' ),
			'site_tagline'      => get_bloginfo( 'description' ),
			'custom_logo_id'    => $custom_logo_id,
			'custom_logo_url'   => $custom_logo_url,
			'site_icon_id'      => $site_icon_id,
			'site_icon_url'     => $site_icon_url,
			'custom_css'        => $custom_css,
			'homepage_settings' => $homepage_settings,
			'nav_menus'         => $nav_menus,
			'mods'              => $clean_mods,
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
		$source_url = ! empty( $data['source_site_url'] ) ? $data['source_site_url'] : ( ! empty( $data['site_url'] ) ? $data['site_url'] : '' );
		if ( $replace_urls && ! empty( $source_url ) ) {
			$old_url = untrailingslashit( $source_url );
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
		$imported_count   = 0;
		$allowed_prefixes = array( 'pixelpost_', 'foliopress_', 'header_', 'background_', 'custom_logo' );

		foreach ( $mods as $key => $val ) {
			if ( ! is_string( $key ) || in_array( $key, array( 0, '0', 'custom_css_post_id', 'nav_menu_locations', 'sidebars_widgets' ), true ) ) {
				continue;
			}

			// Validate allowed theme mod key prefix to prevent option pollution
			$is_allowed = false;
			foreach ( $allowed_prefixes as $prefix ) {
				if ( strpos( $key, $prefix ) === 0 ) {
					$is_allowed = true;
					break;
				}
			}
			if ( ! $is_allowed ) {
				continue;
			}

			// Format value appropriately
			$save_val = is_array( $val ) ? wp_json_encode( $val ) : $val;

			// Save mod under active key
			set_theme_mod( $key, $save_val );
			$imported_count++;

			// Maintain mirror keys for cross-compatibility
			if ( strpos( $key, 'pixelpost_' ) === 0 ) {
				$legacy_key = 'foliopress_' . substr( $key, 10 );
				set_theme_mod( $legacy_key, $save_val );
			} elseif ( strpos( $key, 'foliopress_' ) === 0 ) {
				$modern_key = 'pixelpost_' . substr( $key, 11 );
				set_theme_mod( $modern_key, $save_val );
			}
		}

		// 4. Handle Custom Logo if URL is available and current logo is empty
		if ( ! empty( $data['custom_logo_url'] ) && ! has_custom_logo() ) {
			$logo_url = esc_url_raw( $data['custom_logo_url'] );
			if ( $replace_urls && ! empty( $source_url ) ) {
				$logo_url = str_replace( untrailingslashit( $source_url ), untrailingslashit( home_url() ), $logo_url );
			}

			// SSRF Mitigation: Validate URL and reject internal/localhost/cloud metadata IPs
			$validated_url = wp_http_validate_url( $logo_url );
			$is_safe_host  = false;
			if ( $validated_url ) {
				$parsed = wp_parse_url( $validated_url );
				$host   = isset( $parsed['host'] ) ? strtolower( $parsed['host'] ) : '';
				if ( ! empty( $host ) && 'localhost' !== $host && ! preg_match( '/^(127\.|10\.|172\.(1[6-9]|2[0-9]|3[0-1])\.|192\.168\.|169\.254\.)/', $host ) ) {
					$is_safe_host = true;
				}
			}

			if ( $is_safe_host ) {
				// Try to sideload the logo into media library
				if ( function_exists( 'media_sideload_image' ) || file_exists( ABSPATH . 'wp-admin/includes/media.php' ) ) {
					require_once ABSPATH . 'wp-admin/includes/media.php';
					require_once ABSPATH . 'wp-admin/includes/file.php';
					require_once ABSPATH . 'wp-admin/includes/image.php';

					$attachment_id = media_sideload_image( $validated_url, 0, 'Site Logo', 'id' );
					if ( ! is_wp_error( $attachment_id ) ) {
						set_theme_mod( 'custom_logo', $attachment_id );
					}
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

		wp_send_json_success( array(
			'message' => $result['message'],
			'count'   => $result['count'],
		) );
	}

	/**
	 * Handle admin form import via admin-post.php
	 */
	public function handle_admin_import() {
		if ( ! current_user_can( 'edit_theme_options' ) ) {
			wp_die( esc_html__( 'Sorry, you are not allowed to import theme settings.', 'pixelpost' ) );
		}

		check_admin_referer( 'pixelpost_import_customizer_nonce' );

		if ( empty( $_FILES['pixelpost_import_file']['tmp_name'] ) ) {
			wp_safe_redirect( add_query_arg( array( 'page' => 'pixelpost-setup', 'import' => 'no_file' ), admin_url( 'themes.php' ) ) );
			exit;
		}

		// Security: Validate file extension (.json only)
		$uploaded_name = ! empty( $_FILES['pixelpost_import_file']['name'] ) ? sanitize_file_name( $_FILES['pixelpost_import_file']['name'] ) : '';
		$uploaded_ext  = strtolower( pathinfo( $uploaded_name, PATHINFO_EXTENSION ) );
		if ( 'json' !== $uploaded_ext ) {
			wp_safe_redirect( add_query_arg( array( 'page' => 'pixelpost-setup', 'import' => 'error', 'msg' => urlencode( __( 'Invalid file format. Only .json files are allowed.', 'pixelpost' ) ) ), admin_url( 'themes.php' ) ) );
			exit;
		}

		// Security & DoS Protection: Restrict file size to 5MB maximum
		$file_size = isset( $_FILES['pixelpost_import_file']['size'] ) ? absint( $_FILES['pixelpost_import_file']['size'] ) : 0;
		if ( $file_size > 5 * MB_IN_BYTES ) {
			wp_safe_redirect( add_query_arg( array( 'page' => 'pixelpost-setup', 'import' => 'error', 'msg' => urlencode( __( 'The uploaded file exceeds the 5MB size limit.', 'pixelpost' ) ) ), admin_url( 'themes.php' ) ) );
			exit;
		}

		// Read uploaded file securely using WP_Filesystem
		global $wp_filesystem;
		if ( empty( $wp_filesystem ) ) {
			require_once ABSPATH . '/wp-admin/includes/file.php';
			WP_Filesystem();
		}
		$file_content = $wp_filesystem ? $wp_filesystem->get_contents( $_FILES['pixelpost_import_file']['tmp_name'] ) : false;
		if ( false === $file_content && file_exists( $_FILES['pixelpost_import_file']['tmp_name'] ) ) {
			$file_content = file_get_contents( $_FILES['pixelpost_import_file']['tmp_name'] ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
		}
		if ( false === $file_content ) {
			wp_safe_redirect( add_query_arg( array( 'page' => 'pixelpost-setup', 'import' => 'read_error' ), admin_url( 'themes.php' ) ) );
			exit;
		}

		$args = array(
			'replace_urls'         => ! empty( $_POST['replace_urls'] ),
			'import_css'           => ! empty( $_POST['import_css'] ),
			'import_site_identity' => ! empty( $_POST['import_site_identity'] ),
		);

		$result = $this->import_data( $file_content, $args );

		if ( is_wp_error( $result ) ) {
			wp_safe_redirect( add_query_arg( array( 'page' => 'pixelpost-setup', 'import' => 'error', 'msg' => urlencode( $result->get_error_message() ) ), admin_url( 'themes.php' ) ) );
			exit;
		}

		wp_safe_redirect( add_query_arg( array( 'page' => 'pixelpost-setup', 'import' => 'success', 'count' => $result['count'] ), admin_url( 'themes.php' ) ) );
		exit;
	}

	/**
	 * Reset current theme settings to initial demo defaults
	 */
	public function handle_reset_demo_defaults() {
		if ( ! current_user_can( 'edit_theme_options' ) ) {
			wp_die( esc_html__( 'Sorry, you are not allowed to modify theme settings.', 'pixelpost' ) );
		}

		check_admin_referer( 'pixelpost_reset_demo_nonce' );

		if ( function_exists( 'pixelpost_get_theme_defaults' ) ) {
			$defaults = pixelpost_get_theme_defaults();
			foreach ( $defaults as $key => $val ) {
				set_theme_mod( $key, $val );
				if ( strpos( $key, 'pixelpost_' ) === 0 ) {
					$legacy_key = 'foliopress_' . substr( $key, 10 );
					set_theme_mod( $legacy_key, $val );
				}
			}
		}

		if ( function_exists( 'wp_cache_flush' ) ) {
			wp_cache_flush();
		}

		wp_safe_redirect( add_query_arg( array( 'page' => 'pixelpost-setup', 'reset' => 'success' ), admin_url( 'themes.php' ) ) );
		exit;
	}

	/**
	 * Render admin notification banners
	 */
	public function render_admin_notices() {
		// Handled directly inside render_admin_page() header banner for unified UI
	}

	/**
	 * Render the full Setup & Migration page in Appearance menu
	 */
	public function render_admin_page() {
		$export_url = wp_nonce_url(
			admin_url( 'admin-post.php?action=pixelpost_export_customizer' ),
			'pixelpost_export_customizer_nonce'
		);
		$reset_url  = wp_nonce_url(
			admin_url( 'admin-post.php?action=pixelpost_reset_demo_defaults' ),
			'pixelpost_reset_demo_nonce'
		);

		// Notice state handling
		$notice_type = '';
		$notice_text = '';

		if ( isset( $_GET['import'] ) && 'success' === $_GET['import'] ) {
			$count       = isset( $_GET['count'] ) ? absint( $_GET['count'] ) : 176;
			$notice_type = 'success';
			$notice_text = sprintf(
				/* translators: %d: number of settings */
				esc_html__( '%d Customizer settings have been successfully imported and applied.', 'pixelpost' ),
				$count
			);
		} elseif ( isset( $_GET['reset'] ) && 'success' === $_GET['reset'] ) {
			$notice_type = 'success';
			$notice_text = esc_html__( 'Theme settings have been reset to default demo configurations.', 'pixelpost' );
		} elseif ( isset( $_GET['import'] ) && 'error' === $_GET['import'] ) {
			$notice_type = 'error';
			$notice_text = isset( $_GET['msg'] ) ? sanitize_text_field( wp_unslash( $_GET['msg'] ) ) : esc_html__( 'An error occurred during import.', 'pixelpost' );
		}
		?>
		<style>
			.pixelpost-setup-wrap {
				max-width: 1160px;
				margin: 24px auto 48px;
				font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
				color: #1C1A17;
			}
			.pixelpost-setup-wrap h1,
			.pixelpost-setup-wrap h2,
			.pixelpost-setup-wrap h3 {
				font-family: inherit;
				color: #1C1A17;
			}
			.fp-card {
				background: #FFFFFF;
				border: 1px solid #ECE8E1;
				border-radius: 16px;
				box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
				transition: border-color 0.2s ease, box-shadow 0.2s ease;
			}
			.fp-card:hover {
				border-color: #DFDAD1;
			}
			.fp-btn-primary {
				background: #994200 !important;
				border: none !important;
				border-radius: 8px !important;
				color: #FFFFFF !important;
				font-weight: 600 !important;
				font-size: 14px !important;
				height: 44px !important;
				line-height: 44px !important;
				padding: 0 20px !important;
				display: inline-flex !important;
				align-items: center !important;
				justify-content: center !important;
				gap: 8px !important;
				text-decoration: none !important;
				cursor: pointer !important;
				box-shadow: 0 1px 2px rgba(153, 66, 0, 0.2) !important;
				transition: all 0.2s ease !important;
			}
			.fp-btn-primary:hover {
				background: #803700 !important;
				transform: translateY(-1px);
				box-shadow: 0 4px 10px rgba(153, 66, 0, 0.28) !important;
			}
			.fp-btn-secondary {
				background: #FFFFFF !important;
				border: 1.5px solid #2271b1 !important;
				border-radius: 8px !important;
				color: #2271b1 !important;
				font-weight: 600 !important;
				font-size: 14px !important;
				height: 44px !important;
				line-height: 41px !important;
				padding: 0 20px !important;
				display: inline-flex !important;
				align-items: center !important;
				justify-content: center !important;
				gap: 8px !important;
				text-decoration: none !important;
				cursor: pointer !important;
				transition: all 0.2s ease !important;
			}
			.fp-btn-secondary:hover {
				background: #EEF4FB !important;
				border-color: #1a5c91 !important;
				color: #1a5c91 !important;
				transform: translateY(-1px);
			}
			.fp-upload-zone {
				border: 1.5px dashed #D3CEC6;
				border-radius: 10px;
				background: #FAF9F7;
				padding: 12px 16px;
				cursor: pointer;
				transition: all 0.2s ease;
				position: relative;
				outline: none;
			}
			.fp-upload-zone:hover,
			.fp-upload-zone:focus {
				border-color: #2271b1;
				background: #FDFCFB;
			}
			.fp-upload-zone.is-dragover {
				border-color: #2271b1 !important;
				background: #EEF4FB !important;
				box-shadow: 0 0 0 3px rgba(34, 113, 177, 0.15) !important;
			}
			.fp-hidden-file-input {
				position: absolute;
				width: 1px;
				height: 1px;
				padding: 0;
				margin: -1px;
				overflow: hidden;
				clip: rect(0, 0, 0, 0);
				white-space: nowrap;
				border: 0;
			}
			.fp-upload-state-row {
				align-items: center;
				justify-content: space-between;
				gap: 12px;
				width: 100%;
			}
			.fp-browse-btn,
			.fp-replace-btn {
				background: #FFFFFF !important;
				border: 1px solid #D1CDC7 !important;
				border-radius: 6px !important;
				padding: 6px 14px !important;
				font-size: 12px !important;
				font-weight: 600 !important;
				color: #1C1A17 !important;
				cursor: pointer !important;
				display: inline-flex !important;
				align-items: center !important;
				gap: 6px !important;
				white-space: nowrap !important;
				box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04) !important;
				transition: all 0.2s ease !important;
			}
			.fp-browse-btn:hover,
			.fp-replace-btn:hover {
				background: #F5F3EF !important;
				border-color: #B8B2A7 !important;
				color: #1C1A17 !important;
				transform: translateY(-1px);
			}
			.fp-remove-btn {
				background: transparent !important;
				border: 1px solid transparent !important;
				border-radius: 6px !important;
				width: 28px !important;
				height: 28px !important;
				display: inline-flex !important;
				align-items: center !important;
				justify-content: center !important;
				color: #8C867E !important;
				cursor: pointer !important;
				padding: 0 !important;
				transition: all 0.2s ease !important;
			}
			.fp-remove-btn:hover {
				color: #b32d2e !important;
				background: #FDF2F2 !important;
				border-color: #F5C6CB !important;
			}
			.fp-checkbox-label {
				display: flex;
				align-items: flex-start;
				gap: 10px;
				cursor: pointer;
				user-select: none;
			}
			.fp-checkbox-label input[type="checkbox"] {
				accent-color: #2271b1;
				width: 16px;
				height: 16px;
				margin-top: 2px;
				cursor: pointer;
				border-radius: 4px;
			}
			@media (max-width: 860px) {
				.fp-grid-2col {
					grid-template-columns: 1fr !important;
				}
				.fp-banner-content {
					flex-direction: column !important;
				}
				.fp-banner-art {
					display: none !important;
				}
			}
		</style>

		<div class="wrap pixelpost-setup-wrap">
			<!-- HEADER BANNER -->
			<div class="fp-card" style="padding: 28px 32px; margin-bottom: 24px;">
				<div class="fp-banner-content" style="display: flex; justify-content: space-between; align-items: center; gap: 24px;">
					<!-- Left Text Content -->
					<div>
						<div style="display: inline-block; font-size: 11px; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: #994200; background: #FAF0E8; padding: 4px 10px; border-radius: 4px; margin-bottom: 12px;">
							<?php esc_html_e( 'PIXELPOST EDITORIAL PORTFOLIO - V1.0.2', 'pixelpost' ); ?>
						</div>
						<h1 style="margin: 0 0 8px 0; font-size: 30px; font-weight: 700; color: #1C1A17; line-height: 1.2; letter-spacing: -0.02em;">
							<?php esc_html_e( 'Theme Setup & Migration', 'pixelpost' ); ?>
						</h1>
						<p style="margin: 0; font-size: 14px; color: #6B665F; max-width: 540px; line-height: 1.5;">
							<?php esc_html_e( 'Export your complete portfolio setup to easily backup your content, or import settings onto a brand new site installation with one click.', 'pixelpost' ); ?>
						</p>
					</div>

					<!-- Right Illustration -->
					<div class="fp-banner-art" style="flex-shrink: 0;">
						<svg width="220" height="126" viewBox="0 0 220 126" fill="none" xmlns="http://www.w3.org/2000/svg" style="display: block;">
							<defs>
								<filter id="cardShadow" x="-10%" y="-10%" width="130%" height="130%" filterUnits="userSpaceOnUse">
									<feDropShadow dx="0" dy="4" stdDeviation="5" flood-color="#1c1917" flood-opacity="0.07" />
								</filter>
								<filter id="sliderShadow" x="-20%" y="-20%" width="140%" height="140%" filterUnits="userSpaceOnUse">
									<feDropShadow dx="0" dy="4" stdDeviation="7" flood-color="#1c1917" flood-opacity="0.10" />
								</filter>
								<radialGradient id="bannerGlow" cx="60%" cy="50%" r="50%">
									<stop offset="0%" stop-color="#F8EFE6" stop-opacity="0.95" />
									<stop offset="100%" stop-color="#F8EFE6" stop-opacity="0" />
								</radialGradient>
							</defs>

							<!-- Warm ambient glow -->
							<circle cx="150" cy="63" r="62" fill="url(#bannerGlow)" />

							<!-- Swoosh arrow pointing to browser -->
							<path d="M 22 84 C 52 64, 82 48, 106 46" stroke="#D8A581" stroke-width="3" stroke-linecap="round" fill="none" />
							<polygon points="108,42 117,48 107,52" fill="#D8A581" />

							<!-- Browser Window Mockup -->
							<g filter="url(#cardShadow)">
								<rect x="75" y="14" width="130" height="92" rx="10" fill="#FFFFFF" stroke="#ECE6DE" stroke-width="1.2" />
								
								<!-- Browser Header Bar -->
								<path d="M 75 24 A 10 10 0 0 1 85 14 L 195 14 A 10 10 0 0 1 205 24 L 205 32 L 75 32 Z" fill="#9F5123" />
								<!-- 3 Dots -->
								<circle cx="87" cy="23" r="2.5" fill="#FFFFFF" opacity="0.9" />
								<circle cx="95" cy="23" r="2.5" fill="#FFFFFF" opacity="0.6" />
								<circle cx="103" cy="23" r="2.5" fill="#FFFFFF" opacity="0.6" />

								<!-- Browser Body: Landscape Image Graphic Placeholder -->
								<rect x="87" y="42" width="58" height="46" rx="6" fill="#FBF5F0" stroke="#F0E8DF" stroke-width="1" />
								<circle cx="128" cy="54" r="4.5" fill="#D8A581" />
								<polygon points="88,86 106,68 122,86" fill="#D49970" />
								<polygon points="112,86 128,72 144,86" fill="#BD7B4D" />
							</g>

							<!-- Floating Controls / Settings Slider Card -->
							<g filter="url(#sliderShadow)">
								<rect x="150" y="50" width="56" height="52" rx="8" fill="#FFFFFF" stroke="#ECE6DE" stroke-width="1.2" />
								
								<!-- Slider 1 -->
								<line x1="160" y1="65" x2="196" y2="65" stroke="#ECE6DE" stroke-width="2.5" stroke-linecap="round" />
								<circle cx="184" cy="65" r="4" fill="#994200" stroke="#FFFFFF" stroke-width="1.5" />

								<!-- Slider 2 -->
								<line x1="160" y1="85" x2="196" y2="85" stroke="#ECE6DE" stroke-width="2.5" stroke-linecap="round" />
								<circle cx="172" cy="85" r="4" fill="#994200" stroke="#FFFFFF" stroke-width="1.5" />
							</g>
						</svg>
					</div>
				</div>

				<!-- Lower Row: Notice + Action Buttons -->
				<div style="display: flex; justify-content: space-between; align-items: center; margin-top: 22px; flex-wrap: wrap; gap: 16px;">
					<!-- Notice Pill -->
					<div>
						<?php if ( 'success' === $notice_type ) : ?>
							<div id="fp-header-notice" style="display: inline-flex; align-items: center; gap: 10px; background: #EAF7EE; border: 1px solid #B8E4C4; border-radius: 8px; padding: 7px 14px; font-size: 13px; color: #1C1A17; max-width: 100%;">
								<span style="width: 20px; height: 20px; border-radius: 50%; background: #28a745; color: #FFFFFF; display: inline-flex; align-items: center; justify-content: center; font-size: 11px; font-weight: bold; flex-shrink: 0;">✓</span>
								<span><strong><?php esc_html_e( 'Success!', 'pixelpost' ); ?></strong> <?php echo esc_html( $notice_text ); ?></span>
								<a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="button" style="height: 28px; line-height: 26px; padding: 0 12px; font-size: 12px; font-weight: 500; color: #2271b1; border: 1px solid #2271b1; background: #FFFFFF; border-radius: 5px; text-decoration: none; margin-left: 8px; white-space: nowrap;">
									<?php esc_html_e( 'Open Customizer', 'pixelpost' ); ?>
								</a>
								<span onclick="document.getElementById('fp-header-notice').style.display='none';" style="cursor: pointer; color: #6B665F; font-size: 14px; margin-left: 6px; line-height: 1; padding: 2px;" title="<?php esc_attr_e( 'Dismiss', 'pixelpost' ); ?>">✕</span>
							</div>
						<?php elseif ( 'error' === $notice_type ) : ?>
							<div id="fp-header-notice" style="display: inline-flex; align-items: center; gap: 10px; background: #FDF2F2; border: 1px solid #F5C6CB; border-radius: 8px; padding: 7px 14px; font-size: 13px; color: #721C24; max-width: 100%;">
								<span style="width: 20px; height: 20px; border-radius: 50%; background: #dc3545; color: #FFFFFF; display: inline-flex; align-items: center; justify-content: center; font-size: 11px; font-weight: bold; flex-shrink: 0;">✕</span>
								<span><strong><?php esc_html_e( 'Import Failed:', 'pixelpost' ); ?></strong> <?php echo esc_html( $notice_text ); ?></span>
								<span onclick="document.getElementById('fp-header-notice').style.display='none';" style="cursor: pointer; color: #721C24; font-size: 14px; margin-left: 6px; line-height: 1; padding: 2px;">✕</span>
							</div>
						<?php endif; ?>
					</div>

					<!-- Action Buttons -->
					<div style="display: flex; gap: 10px; margin-left: auto;">
						<a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="button button-primary" style="background: #994200; border: none; height: 38px; line-height: 38px; padding: 0 18px; font-weight: 600; font-size: 13px; border-radius: 7px; color: #FFFFFF; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 1px 2px rgba(153, 66, 0, 0.2); transition: all 0.2s ease;">
							<?php esc_html_e( 'Open Customizer', 'pixelpost' ); ?>
						</a>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" target="_blank" class="button button-secondary" style="height: 38px; line-height: 36px; padding: 0 16px; font-weight: 600; font-size: 13px; border-radius: 7px; color: #2271b1; border: 1.5px solid #2271b1; background: #FFFFFF; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; transition: all 0.2s ease;">
							<?php esc_html_e( 'View Live Site ↗', 'pixelpost' ); ?>
						</a>
					</div>
				</div>
			</div>

			<!-- MAIN 2-COLUMN BALANCED GRID -->
			<div class="fp-grid-2col" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(420px, 1fr)); gap: 24px; margin-bottom: 24px;">
				
				<!-- CARD 1: EXPORT CUSTOMIZER DATA -->
				<div class="fp-card" style="padding: 28px; display: flex; flex-direction: column; justify-content: space-between;">
					<div>
						<!-- Card Header -->
						<div style="display: flex; align-items: flex-start; gap: 16px; margin-bottom: 20px;">
							<div style="width: 44px; height: 44px; border-radius: 10px; background: #FAF0E8; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
								<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#994200" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
									<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
									<polyline points="7 10 12 15 17 10"></polyline>
									<line x1="12" y1="15" x2="12" y2="3"></line>
								</svg>
							</div>
							<div>
								<h2 style="margin: 0 0 6px 0; font-size: 18px; font-weight: 700; color: #1C1A17; line-height: 1.3;">
									<?php esc_html_e( 'Export Customizer Data', 'pixelpost' ); ?>
								</h2>
								<p style="margin: 0; font-size: 13px; color: #6B665F; line-height: 1.5;">
									<?php esc_html_e( 'Creates a downloadable JSON file containing all theme settings and custom content. You can import this into any new Pixelpost installation.', 'pixelpost' ); ?>
								</p>
							</div>
						</div>

						<!-- Included in Export Container -->
						<div style="background: #FAF6F0; border: 1px solid #EFECE6; border-radius: 10px; padding: 18px 20px; margin-bottom: 22px;">
							<div style="display: flex; align-items: center; gap: 8px; margin-bottom: 14px; font-weight: 700; font-size: 13px; color: #1C1A17;">
								<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#994200" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
									<polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
									<polyline points="2 17 12 22 22 17"></polyline>
									<polyline points="2 12 12 17 22 12"></polyline>
								</svg>
								<span><?php esc_html_e( 'Included in Export', 'pixelpost' ); ?></span>
							</div>
							<ul style="margin: 0; padding: 0; list-style: none;">
								<li style="display: flex; align-items: flex-start; gap: 10px; margin-bottom: 11px; font-size: 13px; color: #3C3833; line-height: 1.45;">
									<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#994200" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0; margin-top: 2px;"><polyline points="20 6 9 17 4 12"></polyline></svg>
									<span><?php esc_html_e( 'Hero section (headline, intro, CTA buttons, indicators)', 'pixelpost' ); ?></span>
								</li>
								<li style="display: flex; align-items: flex-start; gap: 10px; margin-bottom: 11px; font-size: 13px; color: #3C3833; line-height: 1.45;">
									<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#994200" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0; margin-top: 2px;"><polyline points="20 6 9 17 4 12"></polyline></svg>
									<span><?php esc_html_e( 'Projects I\'ve built (all 4 project cards, links, SVGs)', 'pixelpost' ); ?></span>
								</li>
								<li style="display: flex; align-items: flex-start; gap: 10px; margin-bottom: 11px; font-size: 13px; color: #3C3833; line-height: 1.45;">
									<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#994200" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0; margin-top: 2px;"><polyline points="20 6 9 17 4 12"></polyline></svg>
									<span><?php esc_html_e( 'Skills categorized items & Work Experience timeline', 'pixelpost' ); ?></span>
								</li>
								<li style="display: flex; align-items: flex-start; gap: 10px; margin-bottom: 11px; font-size: 13px; color: #3C3833; line-height: 1.45;">
									<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#994200" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0; margin-top: 2px;"><polyline points="20 6 9 17 4 12"></polyline></svg>
									<span><?php esc_html_e( 'Statistics metrics & About Me attributes', 'pixelpost' ); ?></span>
								</li>
								<li style="display: flex; align-items: flex-start; gap: 10px; margin-bottom: 11px; font-size: 13px; color: #3C3833; line-height: 1.45;">
									<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#994200" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0; margin-top: 2px;"><polyline points="20 6 9 17 4 12"></polyline></svg>
									<span><?php esc_html_e( 'Brand display (text vs logo, dimensions, tagline)', 'pixelpost' ); ?></span>
								</li>
								<li style="display: flex; align-items: flex-start; gap: 10px; font-size: 13px; color: #3C3833; line-height: 1.45;">
									<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#994200" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0; margin-top: 2px;"><polyline points="20 6 9 17 4 12"></polyline></svg>
									<span><?php esc_html_e( 'Footer social links, copyright, and Additional CSS', 'pixelpost' ); ?></span>
								</li>
							</ul>
						</div>
					</div>

					<!-- Export Button -->
					<a href="<?php echo esc_url( $export_url ); ?>" class="fp-btn-primary" style="width: 100%;">
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
							<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
							<polyline points="7 10 12 15 17 10"></polyline>
							<line x1="12" y1="15" x2="12" y2="3"></line>
						</svg>
						<span><?php esc_html_e( 'Download Export File (.json)', 'pixelpost' ); ?></span>
					</a>
				</div>

				<!-- CARD 2: IMPORT CUSTOMIZER DATA -->
				<div class="fp-card" style="padding: 28px; display: flex; flex-direction: column; justify-content: space-between;">
					<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" enctype="multipart/form-data" style="margin: 0; display: flex; flex-direction: column; justify-content: space-between; height: 100%;">
						<input type="hidden" name="action" value="pixelpost_import_customizer" />
						<?php wp_nonce_field( 'pixelpost_import_customizer_nonce' ); ?>

						<div>
							<!-- Card Header -->
							<div style="display: flex; align-items: flex-start; gap: 16px; margin-bottom: 20px;">
								<div style="width: 44px; height: 44px; border-radius: 10px; background: #EEF4FB; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
									<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#2271b1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
										<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
										<polyline points="17 8 12 3 7 8"></polyline>
										<line x1="12" y1="3" x2="12" y2="15"></line>
									</svg>
								</div>
								<div>
									<h2 style="margin: 0 0 6px 0; font-size: 18px; font-weight: 700; color: #1C1A17; line-height: 1.3;">
										<?php esc_html_e( 'Import Customizer Data', 'pixelpost' ); ?>
									</h2>
									<p style="margin: 0; font-size: 13px; color: #6B665F; line-height: 1.5;">
										<?php esc_html_e( 'Upload your exported JSON file to immediately configure this site to match your previous setup.', 'pixelpost' ); ?>
									</p>
								</div>
							</div>

							<!-- Custom File Upload Field -->
							<div style="margin-bottom: 20px;">
								<label style="display: block; font-weight: 700; font-size: 13px; margin-bottom: 8px; color: #1C1A17;">
									<?php esc_html_e( 'Choose Export File (.json):', 'pixelpost' ); ?>
								</label>

								<div id="fp-dropzone" class="fp-upload-zone" tabindex="0" role="button" aria-label="<?php esc_attr_e( 'Upload JSON export file', 'pixelpost' ); ?>">
									<input type="file" name="pixelpost_import_file" id="pixelpost_import_file" accept=".json,application/json" required="required" class="fp-hidden-file-input" />

									<!-- State: Empty / No File Selected -->
									<div id="fp-upload-empty-state" class="fp-upload-state-row" style="display: flex;">
										<div style="display: flex; align-items: center; gap: 12px; min-width: 0; flex: 1;">
											<!-- JSON Document Icon Badge -->
											<div style="width: 34px; height: 34px; border-radius: 8px; background: #FAF0E8; border: 1px solid #EFE4D8; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
												<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#994200" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
													<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
													<polyline points="14 2 14 8 20 8"></polyline>
													<path d="M9 13h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H9"></path>
													<path d="M15 13h-2v4h2"></path>
												</svg>
											</div>
											<div style="min-width: 0; line-height: 1.35;">
												<span style="font-size: 13px; font-weight: 600; color: #44403C; display: block;">
													<?php esc_html_e( 'No file selected', 'pixelpost' ); ?>
												</span>
												<span style="font-size: 11px; color: #8C867E; display: block;">
													<?php esc_html_e( 'Click to browse or drop .json file here', 'pixelpost' ); ?>
												</span>
											</div>
										</div>

										<button type="button" id="fp-btn-browse-trigger" class="fp-browse-btn">
											<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#6B665F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
												<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
												<polyline points="17 8 12 3 7 8"></polyline>
												<line x1="12" y1="3" x2="12" y2="15"></line>
											</svg>
											<span><?php esc_html_e( 'Browse Files', 'pixelpost' ); ?></span>
										</button>
									</div>

									<!-- State: File Selected -->
									<div id="fp-upload-selected-state" class="fp-upload-state-row" style="display: none;">
										<div style="display: flex; align-items: center; gap: 12px; min-width: 0; flex: 1;">
											<!-- Active JSON Badge -->
											<div style="width: 34px; height: 34px; border-radius: 8px; background: #FAF0E8; border: 1px solid #EBD5C5; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
												<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#994200" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
													<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
													<polyline points="14 2 14 8 20 8"></polyline>
													<polyline points="9 15 12 12 15 15"></polyline>
												</svg>
											</div>
											<div style="min-width: 0; line-height: 1.35; padding-right: 8px;">
												<span id="fp-filename-text" style="font-size: 13px; font-weight: 700; color: #1C1A17; display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"></span>
												<span id="fp-filesize-text" style="font-size: 11px; color: #28a745; font-weight: 500; display: block; margin-top: 1px;"></span>
											</div>
										</div>

										<div style="display: flex; align-items: center; gap: 8px; flex-shrink: 0;">
											<button type="button" id="fp-btn-replace-trigger" class="fp-replace-btn">
												<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#6B665F" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
													<path d="M21 2v6h-6"></path>
													<path d="M3 12a9 9 0 0 1 15-6.7L21 8"></path>
												</svg>
												<span><?php esc_html_e( 'Replace File', 'pixelpost' ); ?></span>
											</button>
											<button type="button" id="fp-btn-remove-trigger" class="fp-remove-btn" title="<?php esc_attr_e( 'Remove file', 'pixelpost' ); ?>">
												<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
													<line x1="18" y1="6" x2="6" y2="18"></line>
													<line x1="6" y1="6" x2="18" y2="18"></line>
												</svg>
											</button>
										</div>
									</div>
								</div>
							</div>

							<!-- Import Options Container -->
							<div style="background: #FAF6F0; border: 1px solid #EFECE6; border-radius: 10px; padding: 16px 20px; margin-bottom: 22px;">
								<label class="fp-checkbox-label" style="margin-bottom: 12px;">
									<input type="checkbox" name="replace_urls" value="1" checked="checked" />
									<div>
										<strong style="color: #1C1A17; font-size: 13px;"><?php esc_html_e( 'Replace domain URLs automatically', 'pixelpost' ); ?></strong>
										<span style="display: block; color: #6B665F; font-size: 12px; line-height: 1.45; margin-top: 3px;">
											<?php esc_html_e( 'Converts previous site URLs (e.g. image assets) to this current site URL:', 'pixelpost' ); ?><br />
											<code style="background: #EAE6DF; border: 1px solid #DDD8D0; border-radius: 4px; padding: 2px 6px; font-size: 11px; color: #1C1A17; font-family: monospace; display: inline-block; margin-top: 3px;"><?php echo esc_html( home_url() ); ?></code>
										</span>
									</div>
								</label>
								<label class="fp-checkbox-label" style="margin-bottom: 10px;">
									<input type="checkbox" name="import_css" value="1" checked="checked" />
									<strong style="color: #1C1A17; font-size: 13px;"><?php esc_html_e( 'Import Custom CSS', 'pixelpost' ); ?></strong>
								</label>
								<label class="fp-checkbox-label">
									<input type="checkbox" name="import_site_identity" value="1" />
									<strong style="color: #1C1A17; font-size: 13px;"><?php esc_html_e( 'Import Site Title & Tagline', 'pixelpost' ); ?></strong>
								</label>
							</div>
						</div>

						<!-- Import Button -->
						<button type="submit" class="fp-btn-secondary" style="width: 100%;">
							<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2271b1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
								<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
								<polyline points="17 8 12 3 7 8"></polyline>
								<line x1="12" y1="3" x2="12" y2="15"></line>
							</svg>
							<span><?php esc_html_e( 'Upload & Apply Settings', 'pixelpost' ); ?></span>
						</button>
					</form>
				</div>
			</div>

			<!-- CARD 3: RESET DEMO DEFAULTS -->
			<div class="fp-card" style="padding: 18px 26px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
				<div>
					<h3 style="margin: 0 0 3px 0; font-size: 14px; font-weight: 700; color: #1C1A17;">
						<?php esc_html_e( 'Reset to Demo Defaults', 'pixelpost' ); ?>
					</h3>
					<p style="margin: 0; font-size: 12px; color: #6B665F;">
						<?php esc_html_e( 'Restore standard default starter content, 4 sample projects, skills, experience, and editorial color schemes.', 'pixelpost' ); ?>
					</p>
				</div>
				<a href="<?php echo esc_url( $reset_url ); ?>" class="button" onclick="return confirm('<?php echo esc_js( __( 'Are you sure you want to reset all theme options to default? Any custom work will be overwritten.', 'pixelpost' ) ); ?>');" style="color: #b32d2e; border: 1px solid #F0B8B8; background: #FFF5F5; font-weight: 600; font-size: 12px; padding: 4px 14px; border-radius: 6px; text-decoration: none; transition: all 0.2s ease;">
					<?php esc_html_e( 'Reset to Demo Defaults', 'pixelpost' ); ?>
				</a>
			</div>
		</div>

		<script>
		document.addEventListener('DOMContentLoaded', function() {
			var fileInput     = document.getElementById('pixelpost_import_file');
			var dropzone      = document.getElementById('fp-dropzone');
			var emptyState    = document.getElementById('fp-upload-empty-state');
			var selectedState = document.getElementById('fp-upload-selected-state');
			var filenameText  = document.getElementById('fp-filename-text');
			var filesizeText  = document.getElementById('fp-filesize-text');
			var browseBtn     = document.getElementById('fp-btn-browse-trigger');
			var replaceBtn    = document.getElementById('fp-btn-replace-trigger');
			var removeBtn     = document.getElementById('fp-btn-remove-trigger');

			function formatBytes(bytes) {
				if (!bytes || bytes === 0) return '0 KB';
				var k = 1024;
				var sizes = ['Bytes', 'KB', 'MB'];
				var i = Math.floor(Math.log(bytes) / Math.log(k));
				return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
			}

			function showSelectedFile(file) {
				if (!file) return;
				if (filenameText) {
					filenameText.textContent = file.name;
				}
				if (filesizeText) {
					filesizeText.textContent = '✓ ' + formatBytes(file.size) + ' · <?php echo esc_js( __( 'Ready to import', 'pixelpost' ) ); ?>';
				}
				if (emptyState) emptyState.style.display = 'none';
				if (selectedState) selectedState.style.display = 'flex';
				if (dropzone) {
					dropzone.style.borderColor = '#B8D4EE';
					dropzone.style.background = '#F6F9FC';
				}
			}

			function resetFile() {
				if (fileInput) fileInput.value = '';
				if (filenameText) filenameText.textContent = '';
				if (filesizeText) filesizeText.textContent = '';
				if (selectedState) selectedState.style.display = 'none';
				if (emptyState) emptyState.style.display = 'flex';
				if (dropzone) {
					dropzone.style.borderColor = '#D3CEC6';
					dropzone.style.background = '#FAF9F7';
				}
			}

			if (fileInput) {
				fileInput.addEventListener('change', function() {
					if (this.files && this.files.length > 0) {
						var file = this.files[0];
						if (file.name.slice(-5).toLowerCase() !== '.json') {
							alert('<?php echo esc_js( __( 'Please select a valid .json export file.', 'pixelpost' ) ); ?>');
							resetFile();
							return;
						}
						showSelectedFile(file);
					} else {
						resetFile();
					}
				});
			}

			if (dropzone && fileInput) {
				dropzone.addEventListener('click', function(e) {
					// Don't trigger browse if clicking the remove button
					if (removeBtn && (e.target === removeBtn || removeBtn.contains(e.target))) {
						return;
					}
					fileInput.click();
				});

				dropzone.addEventListener('keydown', function(e) {
					if (e.key === 'Enter' || e.key === ' ') {
						e.preventDefault();
						fileInput.click();
					}
				});

				['dragenter', 'dragover'].forEach(function(evtName) {
					dropzone.addEventListener(evtName, function(e) {
						e.preventDefault();
						e.stopPropagation();
						dropzone.classList.add('is-dragover');
					});
				});

				['dragleave', 'drop'].forEach(function(evtName) {
					dropzone.addEventListener(evtName, function(e) {
						e.preventDefault();
						e.stopPropagation();
						dropzone.classList.remove('is-dragover');
					});
				});

				dropzone.addEventListener('drop', function(e) {
					if (e.dataTransfer && e.dataTransfer.files && e.dataTransfer.files.length > 0) {
						var dropped = e.dataTransfer.files[0];
						if (dropped.name.slice(-5).toLowerCase() !== '.json') {
							alert('<?php echo esc_js( __( 'Please select a valid .json export file.', 'pixelpost' ) ); ?>');
							return;
						}
						fileInput.files = e.dataTransfer.files;
						showSelectedFile(dropped);
					}
				});
			}

			if (removeBtn) {
				removeBtn.addEventListener('click', function(e) {
					e.preventDefault();
					e.stopPropagation();
					resetFile();
				});
			}

			if (replaceBtn) {
				replaceBtn.addEventListener('click', function(e) {
					e.preventDefault();
					e.stopPropagation();
					if (fileInput) fileInput.click();
				});
			}

			if (browseBtn) {
				browseBtn.addEventListener('click', function(e) {
					e.preventDefault();
					e.stopPropagation();
					if (fileInput) fileInput.click();
				});
			}
		});
		</script>
		<?php
	}
}

// Initialize Export / Import manager
Pixelpost_Export_Import::get_instance();
