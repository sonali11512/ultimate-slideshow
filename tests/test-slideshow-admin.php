<?php
/**
 * Contains test for Ultimate_Slideshow_Admin class
 *
 * @link       https://github.com/sonali11512/ultimate-slideshow
 * @since      1.0.0
 *
 * @package    Ultimate_Slideshow
 * @subpackage Ultimate_Slideshow/test
 */

 /**
  * The admin-specific test functionality of the plugin.
  *
  * @package    Ultimate_Slideshow
  * @subpackage Ultimate_Slideshow/test
  * @author     Sonali Agrawal <sonali.1215@gmail.com>
  */
class PluginAdminTest extends WP_UnitTestCase {

	/**
	 * Stores current class instance
	 *
	 * @access   private
	 * @var      Ultimate_Slideshow_Admin $admin
	 */
	private $admin;

	/**
	 * Initialize the test and set its properties.
	 */
	public function setUp() {
        parent::setup();  

        
		require_once plugin_dir_path((dirname(__FILE__))).'admin/partials/class-global-setting.php';
		$this->admin = new Wpslide\GlobalSettings();

		// set default admin - some test change user
        wp_set_current_user( 1 );
       // Util::set_admin_role( true );

	}

	/**
	 * Test to check if plugin has been initializes.
	 */
	public function test_plugin_initialization() {

		$this->assertFalse( null == $this->admin );

	}


	public function test_setup_for_admin () {
        global $current_screen;
        $screen = WP_Screen::get( 'admin_init' );
        $current_screen = $screen;
    }

    public function test_add_demo_plugin_scripts () {
         
        
        do_action( 'admin_enqueue_scripts' );
        $this->assertTrue( wp_script_is( 'jquery', 'enqueued' ) );
        $this->assertTrue( wp_script_is( 'jquery-ui-core', 'enqueued' ) );
        $this->assertTrue( wp_script_is( 'jquery-ui-sortable', 'enqueued' ) );

        $this->assertTrue( wp_style_is( 'slideshow', 'registered' ) );
        $this->assertTrue( wp_script_is( 'uploader', 'registered' ) );
        
        $this->assertTrue( wp_style_is( 'slideshow', 'enqueued' ) );
        $this->assertTrue( wp_script_is( 'uploader', 'enqueued' ) );
     


}

    public function _make_attachment( $upload, $parent_post_id = 0 ) {
        $type = '';
        if ( !empty($upload['type']) ) {
            $type = $upload['type'];
        } else {
            $mime = wp_check_filetype( $upload['file'] );
            if ($mime)
                $type = $mime['type'];
        }

        $attachment = array(
            'post_title' => basename( $upload['file'] ),
            'post_content' => '',
            'post_type' => 'attachment',
            'post_mime_type' => $type,
            'guid' => $upload[ 'url' ],
        );

        // Save the data
        $id = wp_insert_attachment( $attachment, $upload[ 'file' ]);
        wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $upload['file'] ) );

        return $this->ids[] = $id;
    }

    public function test_admin_menu() {

                $this->admin->wdmAddMenu();

        $this->assertNotEmpty( menu_page_url( 'globalsettings' ) );
    }

    public function tearDown(){
        parent::tearDown();  
    }

   
}