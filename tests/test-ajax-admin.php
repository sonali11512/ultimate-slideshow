<?php
/**
 * Test case for the Ajax callback to update 'my_slideshow_images'.
 *
 * @group ajax
 */
class My_Slideshow_Images_Ajax_Test extends WP_Ajax_UnitTestCase {

    public function setup() {
        parent::setup();
        // your init codes here
        // require_once plugin_dir_path((dirname(__FILE__))).'admin/partials/class-global-setting.php';
        // $this->admin = new Wpslide\GlobalSettings();

    }
 
    /**
     * Test that the callback saves the value for administrators.
     */
    public function test_my_slideshow_images_is_saved() {
 
        $this->_setRole( 'administrator' );
 
        // $_POST['_wpnonce'] = wp_create_nonce( 'my_nonce' );
        // upload attachment for testing
        $filename = plugin_dir_path((dirname(__FILE__))).'tests/test-images/img2.jpg';

        // Check the type of file. We'll use this as the 'post_mime_type'
        $filetype = wp_check_filetype( basename( $filename ), null ); 

        // Get the path to the upload directory.
        $wp_upload_dir = wp_upload_dir();

        // Prepare an array of post data for the attachment.
        $attachment = array(
            'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ), 
            'post_mime_type' => $filetype['type'],
            'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
            'post_content'   => '',
            'post_status'    => 'inherit'
        );

        // Insert the attachment.
        $attach_id = wp_insert_attachment( $attachment, $filename);
       $_POST['ids'] = array($attach_id);
 
        try {
            $this->_handleAjax( 'saveimages' );
        } catch ( WPAjaxDieContinueException  $e ) {
            // var_dump($this->_last_response);
            // We expected this, do nothing.
            $this->assertSame( 'Images Saved Sucessfully', $this->_last_response );
        }
 
        // Check that the exception was thrown.
      // $this->assertFalse( isset( $e ) );
 
        // The output should be a 1 for success.
 
        $this->assertNotEmpty( get_option( 'my_slideshow_images' ) );
    }
 
    
}