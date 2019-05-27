<?php
/**
 * ShortcodeGenerator File Doc Comment
 *
 * @category ShortcodeGenerator
 * @package  WordPress
 * @subpackage  ShortcodeGenerator
 * @author    sonali agrawal
 * @license  https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv
 * @link     https://github.com/sonali11512/ultimate-slideshow
 */

namespace Wpslide;

/**
 * ShortcodeGenerator Class Doc Comment
 *
 * @category Class
 * @package  WordPress
 * @subpackage  ShortcodeGenerator
 * @author    sonali agrawal
 * @license  https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv
 * @link     https://github.com/sonali11512/ultimate-slideshow
 */
class ShortcodeGenerator {
	/**
	 * Loads hooks
	 */
	public function __construct() {
		add_action( 'current_screen', array( $this, 'add_admin_head_hook' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_shortcode_btn_script' ), 10, 1 );

	}

	/**
	 * Load hooks for tinymce
	 */
	public function add_admin_head_hook() {

		global $current_screen;
		add_action( 'admin_head', array( $this, 'wdm_localize_admin_script' ) );
		add_filter( 'mce_external_plugins', array( $this, 'enqueue_sortcode_generator_script' ) );
		add_filter( 'mce_buttons', array( $this, 'register_shortcode_generator' ) );
	}

	/**
	 * Modal for slideshow selection
	 */
	public function wdm_localize_admin_script() {
		$slideshow_title   = __( 'Select a slideshow to add shortcode', 'ultimate-slideshow' );
		$slideshow_dialog  = '<a class="open_modal" href="#slideshow_list" rel="modal:open" style="display:none">Open Modal</a><div id="slideshow_list" style="display:none" title="' . $slideshow_title . '">';
		$get_slideshows    = get_option( 'my_slideshow_images' );
		$slideshow_dialog .= '<div class="slideshow_title"><h3>Slideshow Shortcode Generator</h3></div>';
		$slideshow_dialog .= '<div class="my_slideshow"><label for="select_slideshow">' . __( 'Select a slideshow to insert.', 'ultimate-slideshow' ) . '</label><br><br><select class="select_slideshow">';
		foreach ( $get_slideshows as $key => $value ) {
			$slideshow_dialog .= '<option value="' . $key . '">' . $key . '</option>';
		}
		$slideshow_dialog .= '</select><br><br>';
		$slideshow_dialog .= '<input type="button" class="wdm_insert_slideshow button button-primary button-large" value="' . __( 'Insert', 'ultimate-slideshow' ) . '"></div>';
		?>
		<!-- TinyMCE Shortcode Plugin -->
		<script type='text/javascript'>
			var slideshow_list = '<?php echo $slideshow_dialog; ?>';
		</script>
		<!-- TinyMCE Shortcode Plugin -->
		<?php
	}

	/**
	 * Register shortcode js
	 *
	 * @param array $plugin_array js id.
	 */
	public function enqueue_sortcode_generator_script( $plugin_array ) {
		// enqueue TinyMCE plugin script with its ID.
		$plugin_array['slideshow_mce_button'] = plugins_url( 'js/slideshow-shortcode-generator.js', dirname( __FILE__ ) );

		return $plugin_array;
	}

	/**
	 * Register button
	 *
	 * @param array $buttons array of buttons.
	 */
	public function register_shortcode_generator( $buttons ) {
		array_push( $buttons, 'slideshow_mce_button' );
		return $buttons;
	}

	/**
	 * Register scripts
	 */
	public function enqueue_shortcode_btn_script() {
		wp_enqueue_script( 'jquery-ui-dialog' );

		wp_register_script( 'jquery-ui-modal-script', plugins_url( 'js/jquery.modal.min.js', dirname( __FILE__ ) ), array( 'jquery-ui-dialog' ), '1.0.0', false );
		wp_enqueue_script( 'jquery-ui-modal-script' );

		wp_register_style( 'wdm-jquery-ui-style', plugins_url( 'css/jquery-ui.min.css', dirname( __FILE__ ) ), '', '1.0.0' );
		wp_enqueue_style( 'wdm-jquery-ui-style' );

		wp_register_style( 'wdm-jquery-ui-modal-style', plugins_url( 'css/jquery.modal.min.css', dirname( __FILE__ ) ), '', '1.0.0' );
		wp_enqueue_style( 'wdm-jquery-ui-modal-style' );

	}
}
