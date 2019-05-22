<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package    WordPress
 * @subpackage   Ultimate_Slideshow
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

$option_name = 'my_slideshow_images';
delete_option( $option_name );
