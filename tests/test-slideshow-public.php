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
  * The frontend-specific test functionality of the plugin.
  *
  * @package    Ultimate_Slideshow
  * @subpackage Ultimate_Slideshow/test
  * @author     Sonali Agrawal <sonali.1215@gmail.com>
  */
class PluginPublicTest extends WP_UnitTestCase {


	// private $frontend;
	protected $shortcodes = array( 'myslideshow' );

	public function setUp() {
		parent::setUp();

		global $post;
		$this->create_posts();
		$post = get_post( $this->child_post_id );
		setup_postdata( $post );

		require_once plugin_dir_path( ( dirname( __FILE__ ) ) ) . 'public/partials/class-ultimateslideshowdisplay.php';
		$this->frontend = new Wpslide\UltimateSlideshowDisplay();

		foreach ( $this->shortcodes as $shortcode ) {
			add_shortcode( $shortcode, array( $this, '_shortcode_' . str_replace( '-', '_', $shortcode ) ) );
		}

		$this->atts    = null;
		$this->content = null;
		$this->tagname = null;
	}

	private function create_posts() {
		$args                 = array(
			'post_name'    => 'parent test page',
			'post_title'   => 'parent test page title',
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => '<a href="http://codex.wordpress.org/Function_Reference/setup_postdata" target="_blank">[myslideshow][/myslideshow]]',
		);
		$post_id              = $this->factory->post->create( $args );
		$this->parent_post_id = $post_id;

		$args                = array(
			'post_name'    => 'child test page',
			'post_title'   => 'child test page title',
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_parent'  => $this->parent_post_id,
			'post_content' => '[[myslideshow]test-content[/myslideshow]]',
		);
		$post_id             = $this->factory->post->create( $args );
		$this->child_post_id = $post_id;
	}

	function _shortcode_myslideshow( $atts, $content = null, $tagname = null ) {
		$this->atts    = $atts;
		$this->content = $content;
		$this->tagname = $tagname;
	}

	public function test_noatts() {
		 do_shortcode( '[myslideshow /]' );
		$this->assertEmpty( '', $this->atts );
		$this->assertSame( 'myslideshow', $this->tagname );
	}

	public function test_enqueue_scripts_callback() {
		 // if shortcode exists
		$this->setUp();
		$this->frontend->enqueue_scripts_callback();
		$this->assertTrue( wp_style_is( 'slickcss', 'registered' ) );
		$this->assertTrue( wp_style_is( 'slickthemecss', 'registered' ) );
		$this->assertTrue( wp_script_is( 'slickjs', 'registered' ) );
		$this->assertTrue( wp_script_is( 'slides', 'registered' ) );

		$this->assertTrue( wp_style_is( 'slickcss', 'enqueued' ) );
		$this->assertTrue( wp_style_is( 'slickthemecss', 'enqueued' ) );
		$this->assertTrue( wp_script_is( 'slickjs', 'enqueued' ) );
		$this->assertTrue( wp_script_is( 'slides', 'enqueued' ) );
	}
}
