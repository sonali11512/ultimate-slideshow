<?php
// If uninstall not called from WordPress, then exit.
if (! defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

$option_name = 'my_slideshow_images';
delete_option($option_name);
