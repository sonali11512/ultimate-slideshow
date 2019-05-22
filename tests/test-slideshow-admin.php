<?php
/**
 * Contains test for PluginAdminTest class
 *
 * @link       https://github.com/sonali11512/ultimate-slideshow
 * @since      1.0.0
 *
 * @package    Ultimate_Slideshow
 * @subpackage Ultimate_Slideshow/test
 */

/**
 * PluginAdminTest Class Doc Comment
 *
 * @category Class
 * @package  WordPress
 * @subpackage  PluginAdminTest
 * @author    sonali agrawal
 * @license  https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv
 * @link     https://github.com/sonali11512/ultimate-slideshow
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
		parent::setUp();
		require_once plugin_dir_path( ( dirname( __FILE__ ) ) ) . 'admin/partials/class-globalsettings.php';
		$this->admin = new Wpslide\GlobalSettings();
		wp_set_current_user( 1 );
	}

	/**
	 * Test to check if plugin has been initializes.
	 */
	public function test_plugin_initialization() {
		$this->assertFalse( null === $this->admin );
	}

	/**
	 * Test setup for admin.
	 */
	public function test_setup_for_admin() {
		global $current_screen;
		$screen         = WP_Screen::get( 'admin_init' );
		$current_screen = $screen;
	}

	/**
	 * Test to check enqueue scripts.
	 */
	public function test_enqueue_callback() {
		$this->admin->enqueue_callback();
		$this->assertTrue( wp_script_is( 'jquery', 'enqueued' ) );
		$this->assertTrue( wp_script_is( 'jquery-ui-core', 'enqueued' ) );
		$this->assertTrue( wp_script_is( 'jquery-ui-sortable', 'enqueued' ) );

		$this->assertTrue( wp_style_is( 'slideshow', 'registered' ) );
		$this->assertTrue( wp_script_is( 'uploader', 'registered' ) );

		$this->assertTrue( wp_style_is( 'slideshow', 'enqueued' ) );
		$this->assertTrue( wp_script_is( 'uploader', 'enqueued' ) );
	}

	/**
	 * Create attachment.
	 *
	 * @param type $upload uploaded file.
	 * @param type $parent_post_id Optional. parent post id. Default.
	 */
	public function _make_attachment( $upload, $parent_post_id = 0 ) {
		$type = '';
		if ( ! empty( $upload['type'] ) ) {
			$type = $upload['type'];
		} else {
			$mime = wp_check_filetype( $upload['file'] );
			if ( $mime ) {
				$type = $mime['type'];
			}
		}

		$attachment = array(
			'post_title'     => basename( $upload['file'] ),
			'post_content'   => '',
			'post_type'      => 'attachment',
			'post_mime_type' => $type,
			'guid'           => $upload['url'],
		);

		$id = wp_insert_attachment( $attachment, $upload['file'] );
		wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $upload['file'] ) );
        $this->ids[] = $id;
		return $this->ids;
	}

	/**
	 * Test to check admin menu.
	 */
	public function test_admin_menu() {
		$this->admin->add_menu();
		$this->assertNotEmpty( menu_page_url( 'globalsettings' ) );
	}

}
