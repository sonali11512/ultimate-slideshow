<?php
/**
 * Plugin Name: Ultimate Slideshow
 * Description: This plugin is used to display slideshow.
 * Author: Sonali
 * Text Domain: wp-slide
 * Version: 1.0.0.
 */

require_once plugin_dir_path(__FILE__).'/admin/class-ultimate-slideshow-admin.php';
require_once plugin_dir_path(__FILE__).'/public/class-ultimate-slideshow-public.php';

add_action('plugins_loaded', 'loadSlideTextDomain');

function loadSlideTextDomain()
{
    $plugin_dir = basename(dirname(__FILE__)).'/languages';
    load_plugin_textdomain('ultimate-slideshow', false, $plugin_dir);
}
