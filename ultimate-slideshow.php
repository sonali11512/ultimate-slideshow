<?php
/**
 * Ultimate Slideshow
 *
 * @package     Ultimate_Slideshow
 * @author      sonali agrawal
 * @copyright   2019 sonali agrawal
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: Ultimate Slideshow
 * Plugin URI:  https://github.com/sonali11512/ultimate-slideshow
 * Description: This plugin displays the slideshow in frontend.
 * Version:     1.0.1
 * Author:      sonali agrawal
 * Text Domain: ultimate-slideshow
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

/*
*Includes admin and public main files
*/
require_once plugin_dir_path( __FILE__ ) . '/admin/class-ultimate-slideshow-admin.php';
require_once plugin_dir_path( __FILE__ ) . '/public/class-ultimate-slideshow-public.php';

add_action( 'plugins_loaded', 'load_slide_text_domain' );

/**
 * Loads text domain
 */
function load_slide_text_domain() {
	$plugin_dir = basename( dirname( __FILE__ ) ) . '/languages';
	load_plugin_textdomain( 'ultimate-slideshow', false, $plugin_dir );
}
