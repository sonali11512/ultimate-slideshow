<?php
/**
 * Contains  case for the Ajax callback to update 'my_slideshow_images'.
 *
 * @link       https://github.com/sonali11512/ultimate-slideshow
 * @since      1.0.0
 *
 * @package    Ultimate_Slideshow
 * @subpackage Ultimate_Slideshow/test
 */

/**
 * The frontend-specific test functionality of the plugin.
 *
 * @package    Ultimate_Slideshow
 * @subpackage Ultimate_Slideshow/test
 * @author     Sonali Agrawal <sonali.1215@gmail.com>
 */
class MySlideshowImagesAjaxTest extends WP_Ajax_UnitTestCase {

	/**
	 * Test that the callback saves the value for administrators.
	 */
	public function test_my_slideshow_images_is_saved() {
		$this->_setRole( 'administrator' );

		// upload attachment for testing.
		$filename = plugin_dir_path( ( dirname( __FILE__ ) ) ) . 'tests/test-images/img2.jpg';

		// Check the type of file. We'll use this as the 'post_mime_type'.
		$filetype = wp_check_filetype( basename( $filename ), null );
		// Get the path to the upload directory.
		$wp_upload_dir = wp_upload_dir();

		// Prepare an array of post data for the attachment.
		$attachment = array(
			'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ),
			'post_mime_type' => $filetype['type'],
			'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
			'post_content'   => '',
			'post_status'    => 'inherit',
		);

		// Insert the attachment.
		$attach_id           = wp_insert_attachment( $attachment, $filename );
		$_POST['slideshows'] = array( 'gallery_name' => array( $attach_id ) );

		try {
			$this->_handleAjax( 'saveimages' );
		} catch ( WPAjaxDieContinueException  $e ) {
			$this->assertSame( 'Slideshows Saved Sucessfully', $this->_last_response );
		}
		$this->assertNotEmpty( get_option( 'my_slideshow_images' ) );
	}
}
