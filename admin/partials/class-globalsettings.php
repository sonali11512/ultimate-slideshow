<?php
/**
 * GlobalSettings File Doc Comment
 *
 * @category GlobalSettings
 * @package  WordPress
 * @subpackage  GlobalSettings
 * @author    sonali agrawal
 * @license  https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv
 * @link     https://github.com/sonali11512/ultimate-slideshow
 */

namespace Wpslide;

/**
 * GlobalSettings Class Doc Comment
 *
 * @category Class
 * @package  WordPress
 * @subpackage  GlobalSettings
 * @author    sonali agrawal
 * @license  https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv
 * @link     https://github.com/sonali11512/ultimate-slideshow
 */
class GlobalSettings {

	/**
	 * Loads hooks
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_callback' ), 10, 1 );

		add_action( 'current_screen', array( $this, 'add_admin_head_hook' ) );

		add_action( 'wp_ajax_saveimages', array( $this, 'saveimages_clbk' ) );
		add_action( 'wp_ajax_nopriv_saveimages', array( $this, 'saveimages_clbk' ) );
	}

	/**
	 * Loads scripts and styles
	 */
	public function enqueue_callback() {

		wp_enqueue_script( 'jquery' );
		wp_enqueue_media();
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'jquery-ui-dialog' );

		wp_register_script( 'jquery-ui-modal-script', plugins_url( 'js/jquery.modal.min.js', dirname( __FILE__ ) ), array( 'jquery-ui-dialog' ), '1.0.0', false );
		wp_enqueue_script( 'jquery-ui-modal-script' );

		wp_register_style( 'wdm-jquery-ui-style', plugins_url( 'css/jquery-ui.min.css', dirname( __FILE__ ) ), '', '1.0.0' );
		wp_enqueue_style( 'wdm-jquery-ui-style' );

		wp_register_style( 'wdm-jquery-ui-modal-style', plugins_url( 'css/jquery.modal.min.css', dirname( __FILE__ ) ), '', '1.0.0' );
		wp_enqueue_style( 'wdm-jquery-ui-modal-style' );

		wp_register_script( 'repeatable', plugins_url( 'js/repeatable-fields.js', dirname( __FILE__ ) ), array( 'jquery', 'jquery-ui-core', 'jquery-ui-sortable' ), array( 'jquery', 'jquery-ui-core', 'jquery-ui-sortable' ), '1.0.0', false );
		wp_enqueue_script( 'repeatable' );

		wp_register_script( 'uploader', plugins_url( 'js/uploader.js', dirname( __FILE__ ) ), array( 'jquery', 'jquery-ui-core', 'jquery-ui-sortable' ), array( 'jquery', 'jquery-ui-core', 'jquery-ui-sortable', 'repeatable' ), '1.0.0', false );
		wp_enqueue_script( 'uploader' );
		wp_localize_script( 'uploader', 'uploader_obj', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
		wp_register_style( 'slideshow', plugins_url( 'css/ultimateslideshow.css', dirname( __FILE__ ) ), '', '1.0.0' );
		wp_enqueue_style( 'slideshow' );
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
		$slideshow_title = __( 'Select a slideshow to add shortcode', 'ultimate-slideshow' );
		$slideshow_dialog = '<a class="open_modal" href="#slideshow_list" rel="modal:open" style="display:none">Open Modal</a><div id="slideshow_list" style="display:none" title="' . $slideshow_title . '">';
		$get_slideshows = get_option( 'my_slideshow_images' );
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
		// register buttons with their id.
		array_push( $buttons, 'slideshow_mce_button' );
		// echo 'hellloo';print_R($buttons);die();
		return $buttons;
	}
	/**
	 * This adds menu in navigation bar.
	 */
	public function add_menu() {
		add_menu_page(
			__( 'Ultimate Slideshow', 'ultimate-slideshow' ),
			__( 'Ultimate Slideshow', 'ultimate-slideshow' ),
			'manage_options',
			'globalsettings',
			array( $this, 'globalsettings_callback' )
		);
	}

	/**
	 * Admin setting page
	 */
	public function globalsettings_callback() {
		?>
		

		<div id="dx-eig-gallery">
			<div class="repeat">
				<div class="repeat_container">
					<div class="buttons">
						<input id="gallery_name" type="text" name="gallery_name" value="">
						<span class="button button-primary button-large add"><?php esc_html_e( 'Add new slideshow', 'ultimate-slideshow' ); ?></span>
					</div>
					<div class="repeat_body">
						<div class="template dx-eig-gallery-row row">
							<div class="dx-eig-gallery-row-heading move">
								<input type="text" hidden="" class="row_count" data-count="{{row-count-placeholder}}">
								<input type="text" hidden="" id="attachment_ids_{{row-count-placeholder}}" name="image_gallery[{{row-count-placeholder}}][DATA]" value="">
								<span class="name">My Slideshow</span>
								<input type="button" class="button wp_slide_image_upload" data-count="{{row-count-placeholder}}" name="<?php esc_html_e( 'Add Images', 'ultimate-slideshow' ); ?>" value="<?php esc_html_e( 'Add Images', 'ultimate-slideshow' ); ?>">
								
								<div class="dx-eig-clear"></div>
							</div>
							<div class="dx-eig-gallery-row-content" id="gallery-{{row-count-placeholder}}">
								<p class="no-images-message"><?php esc_html_e( 'Please add images in this slideshow', 'ultimate-slideshow' ); ?></p>
							</div>
						</div><!--end of template-->
		<?php

						$get_slideshows = get_option( 'my_slideshow_images' );
		if ( isset( $get_slideshows ) && ! empty( $get_slideshows ) ) {
			foreach ( $get_slideshows as $key => $value ) {
				?>
									<div class="dx-eig-gallery-row row" >
										<div class="dx-eig-gallery-row-content"  id="gallery-{{row-count-placeholder}}">

						<?php
						if ( ! empty( $value ) ) {
							?>
										<p class="no-images-message" style="display: none;"><?php esc_html_e( 'Please add images in this gallery', 'ultimate-slideshow' ); ?></p>
											<ul id='sortable1' class="gallery_images">
												<div class="dx-eig-images sortable ui-sortable">
								<?php
								foreach ( $get_attachments as $attachemnt ) {
									$html  = '<li class="image attachment details ui-state-highlight" data-attachment_id="' . $attachemnt . '" data-gallery="' . $gallery_count . '">';
									$html .= '<div class="attachment-preview">
							                                <div class="thumbnail">
							                                    ' . wp_get_attachment_image( $attachemnt, 'thumbnail' ) . '
							                                </div>';
									$html .= '<a href="#" class="delete_dx_image check" title="Remove Image"><div class="media-modal-icon"></div></a></div></li>';
									echo $html;
								}
								?>
												</div>
												<div class="dx-eig-clear"></div>
											</ul>
							<?php
						} //end of else.
						?>
										</div><!-- dx-eig-gallery-row-content -->
									</div><!-- dx-eig-gallery-row -->
				<?php
			}
		}
		?>

							</div>
							<div class="buttons">
							<input class="button button-primary button-large save_btn" name="Save Changes" value="Save Changes">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		


		<?php
	}

	/**
	 * Ajax call to save images
	 */
	public function saveimages_clbk() {
		die();

		if ( isset( $_POST['ids'] ) && ! empty( $_POST['ids'] ) ) {
			$ids = wp_unslash( $_POST['ids'] );
			update_option( 'my_slideshow_images', array_unique( $ids ) );
			esc_html_e( 'Images Saved Sucessfully', 'ultimate-slideshow' );
		} else {
			update_option( 'my_slideshow_images', '' );
			esc_html_e( 'No Images Found', 'ultimate-slideshow' );
		}
		wp_die();
	}
}
