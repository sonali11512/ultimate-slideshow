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
class PluginPublicTest extends WP_UnitTestCase {

    // private $frontend;
	protected $shortcodes = array( 'myslideshow');
	
	function setUp() {
		parent::setUp();

			require_once plugin_dir_path((dirname(__FILE__))).'public/partials/class-display-slideshow.php';
		$this->frontend = new Wpslide\UltimateSlideshow();


		foreach ( $this->shortcodes as $shortcode )
			add_shortcode( $shortcode, array( $this, '_shortcode_' . str_replace( '-', '_', $shortcode ) ) );

		$this->atts = null;
		$this->content = null;
		$this->tagname = null;
		
	}

	function _shortcode_myslideshow( $atts, $content = null, $tagname = null ) {
		$this->atts = $atts;
		$this->content = $content;
		$this->tagname = $tagname;
	}

    public function test_noatts() {
		do_shortcode('[myslideshow /]');
	    $this->assertEmpty( '', $this->atts );
		$this->assertSame( 'myslideshow', $this->tagname );
		
	}

	public function test_enqueueScriptsCallback() {
         
        
        // do_action( 'wp_enqueue_scripts' );

        // if shortcode exists 
        $this->setUp();
        $this->frontend->enqueueScriptsCallback();
        

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