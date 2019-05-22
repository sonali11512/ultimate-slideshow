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
		wp_register_script( 'uploader', plugins_url( 'js/uploader.js', dirname( __FILE__ ) ), array( 'jquery', 'jquery-ui-core', 'jquery-ui-sortable' ), array( 'jquery', 'jquery-ui-core', 'jquery-ui-sortable' ), '1.0.0', false );
		wp_enqueue_script( 'uploader' );
		wp_localize_script( 'uploader', 'uploader_obj', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
		wp_register_style( 'slideshow', plugins_url( 'css/ultimateslideshow.css', dirname( __FILE__ ) ), '', '1.0.0' );
		wp_enqueue_style( 'slideshow' );
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
		<div class="wrap">
		<form id="uploader" method="post">
		<input type="button" class="button wp_slide_image_upload" name="<?php esc_html_e( 'Select Images', 'ultimate-slideshow' ); ?>" value="<?php esc_html_e( 'Select Images', 'ultimate-slideshow' ); ?>">
		<input type="submit" name="submit" id="submit" class="save_btn button button-primary" value="Save Changes">
		</form>

		<div class="dx-eig-gallery-row-content" id="gallery">
				<?php

				$get_attachments = get_option( 'my_slideshow_images' );
				if ( isset( $get_attachments ) && ! empty( $get_attachments ) ) {
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
				} else {
					echo '<p class="no-images-message">' . esc_html_e( 'Please add images in this gallery', 'ultimate-slideshow' ) . '</p>';
				}
				?>
			</div>
</div>


		<?php
	}

	/**
	 * Ajax call to save images
	 */
	public function saveimages_clbk() {

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
