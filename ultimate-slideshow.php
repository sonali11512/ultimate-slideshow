<?php
/**
 * The plugin main file
 *
 * This file is read by WordPress to include files of admin and public area
 *
 * @package    WordPress
 * @subpackage Ultimate_Slideshow
 * @author     sonali agrawal
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv
 * @link    https://github.com/sonali11512/ultimate-slideshow
 *
 * @wordpress-plugin
 * Plugin Name: Ultimate Slideshow
 * Description: This plugin is used to display slideshow.
 * Author: Sonali
 * Text Domain: ultimate-slideshow
 * Version: 1.0.0.
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
