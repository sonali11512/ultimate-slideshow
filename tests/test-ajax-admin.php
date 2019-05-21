<?php
/**
 * Test case for the Ajax callback to update 'my_slideshow_images'.
 *
 * @group ajax
 */
class MySlideshowImagesAjaxTest extends WP_Ajax_UnitTestCase
{

    public function setUp()
    {
        parent::setUp();
    }
 
    /**
     * Test that the callback saves the value for administrators.
     */
    public function test_my_slideshow_images_is_saved()
    {
 
        $this->_setRole('administrator');
 
        // upload attachment for testing
        $filename = plugin_dir_path((dirname(__FILE__))).'tests/test-images/img2.jpg';

        // Check the type of file. We'll use this as the 'post_mime_type'
        $filetype = wp_check_filetype(basename($filename), null);
        // Get the path to the upload directory.
        $wp_upload_dir = wp_upload_dir();

        // Prepare an array of post data for the attachment.
        $attachment = array(
            'guid'           => $wp_upload_dir['url'] . '/' . basename($filename),
            'post_mime_type' => $filetype['type'],
            'post_title'     => preg_replace('/\.[^.]+$/', '', basename($filename)),
            'post_content'   => '',
            'post_status'    => 'inherit'
        );

        // Insert the attachment.
        $attach_id = wp_insert_attachment($attachment, $filename);
        $_POST['ids'] = array($attach_id);
 
        try {
            $this->_handleAjax('saveimages');
        } catch (WPAjaxDieContinueException  $e) {
            $this->assertSame('Images Saved Sucessfully', $this->_last_response);
        }
        $this->assertNotEmpty(get_option('my_slideshow_images'));
    }
}
