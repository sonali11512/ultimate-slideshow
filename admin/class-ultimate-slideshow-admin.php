<?php
/**
 * This file contains object of class
 *
 * @category GlobalSettings
 * @package  WordPress
 * @subpackage  GlobalSettings
 * @author    sonali agrawal
 * @license  https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv
 * @link     https://github.com/sonali11512/ultimate-slideshow
 */

/*
*Includes object of admin global setting file
*/
require_once 'partials/class-globalsettings.php';
new Wpslide\GlobalSettings();

/*
*Includes object of admin shortcode generator file
*/
require_once 'partials/class-shortcodegenerator.php';
new Wpslide\ShortcodeGenerator();
