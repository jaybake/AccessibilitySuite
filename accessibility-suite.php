<?php
/*
Plugin Name: Accessibility Suite
Plugin URI: http://www.accessibilitysuite.com/
Description: Give your customers the ability to effortlessly consume your content, and make that decision a quick one to buy from you!
Author: Black Wolf Software
Author URI: http://www.blackwolfsoftware.co/
Version: 1.4
Text Domain: accessibility-suite
*/

/**
 * Load Theme CSS/JS
 */

wp_enqueue_script('as_theme_jquery',plugins_url( '/theme/default/js/jquery-3.0.0.min.js', __FILE__ ));
wp_enqueue_script('as_theme_jquery_ui',plugins_url( '/theme/default/js/jquery-ui.min.js', __FILE__ ));
wp_enqueue_style('as__theme_jquery_ui_css',plugins_url( '/theme/default/css/jquery-ui.min.css', __FILE__ ));
wp_enqueue_style('as_theme_style',plugins_url( '/theme/default/css/style.css', __FILE__ ));


 /**
 * Modules Loader
 */
include_once( dirname( __FILE__ ) . '/modules/loader.php' );
?>
