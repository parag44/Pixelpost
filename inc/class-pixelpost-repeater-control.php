<?php
/**
 * Pixelpost Repeater Customizer Control
 *
 * A lightweight, drag-sortable and button-reorderable repeater control for the native WordPress Customizer.
 * Supports add, duplicate, delete, reorder (up/down/drag), and collapse/expand.
 * Synchronizes with Customizer setting and fires postMessage updates.
 *
 * @package Pixelpost
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return;
}

/**
 * Class Pixelpost_Repeater_Control
 */
class Pixelpost_Repeater_Control extends WP_Customize_Control {

	/**
	 * Control type identifier.
	 *
	 * @var string
	 */
	public $type = 'pixelpost-repeater';

	/**
	 * Field definitions for each repeater item.
	 * Format: array( array( 'key' => '', 'label' => '', 'type' => 'text|url|textarea|select', 'choices' => [], 'default' => '' ) )
	 *
	 * @var array
	 */
	public $fields = array();

	/**
	 * Field key whose value is shown as the item's primary title when collapsed.
	 *
	 * @var string
	 */
	public $item_label_key = 'title';

	/**
	 * Field key whose value is shown as the item's secondary subtitle when collapsed.
	 *
	 * @var string
	 */
	public $item_subtitle_key = '';

	/**
	 * Label for the "Add Item" button.
	 *
	 * @var string
	 */
	public $add_item_label = '';

	/**
	 * Constructor.
	 *
	 * @param WP_Customize_Manager $manager Customizer manager.
	 * @param string               $id      Control ID.
	 * @param array                $args    Arguments.
	 */
	public function __construct( $manager, $id, $args = array() ) {
		parent::__construct( $manager, $id, $args );
		if ( empty( $this->add_item_label ) ) {
			$this->add_item_label = __( '+ Add Item', 'pixelpost' );
		}
	}

	/**
	 * Render the repeater control in the Customizer.
	 */
	public function render_content() {
		$setting_value = $this->value();
		if ( ( empty( $setting_value ) || '[]' === $setting_value ) && isset( $this->setting->default ) ) {
			$setting_value = $this->setting->default;
		}
		$items         = array();

		if ( ! empty( $setting_value ) ) {
			if ( is_array( $setting_value ) ) {
				$items = $setting_value;
			} else {
				$decoded = json_decode( $setting_value, true );
				if ( is_array( $decoded ) ) {
					$items = $decoded;
				}
			}
		}

		$control_id  = 'fp-repeater-' . esc_attr( preg_replace( '/[^a-z0-9_-]/i', '-', $this->id ) );
		$flags       = JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP;
		$fields_json = wp_json_encode( $this->fields, $flags );
		$items_json  = wp_json_encode( $items, $flags );
		?>
		<div class="fp-repeater-control" id="<?php echo esc_attr( $control_id ); ?>"
			data-fields="<?php echo esc_attr( $fields_json ); ?>"
			data-items="<?php echo esc_attr( $items_json ); ?>"
			data-item-label-key="<?php echo esc_attr( $this->item_label_key ); ?>"
			data-item-subtitle-key="<?php echo esc_attr( $this->item_subtitle_key ); ?>"
			data-setting-id="<?php echo esc_attr( $this->settings['default']->id ); ?>"
			data-add-label="<?php echo esc_attr( $this->add_item_label ); ?>">

			<?php if ( ! empty( $this->label ) ) : ?>
				<span class="customize-control-title fp-repeater-label"><?php echo esc_html( $this->label ); ?></span>
			<?php endif; ?>

			<?php if ( ! empty( $this->description ) ) : ?>
				<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
			<?php endif; ?>

			<textarea class="fp-repeater-value" style="display:none;" <?php $this->link(); ?>><?php echo esc_textarea( is_string( $setting_value ) ? $setting_value : wp_json_encode( $setting_value ) ); ?></textarea>

			<div class="fp-repeater-list" role="list"></div>

			<button type="button" class="fp-repeater-add button button-secondary">
				<span class="dashicons dashicons-plus-alt2" aria-hidden="true"></span>
				<?php echo esc_html( $this->add_item_label ); ?>
			</button>
		</div>
		<?php
	}
}
