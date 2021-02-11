<?php
/*
Plugin Name: Giga Store Advanced Sections
Plugin URI: https://themes4wp.com
Description: Add Testimonials, Slider and Custom Image sections to Giga Store theme.
Version: 1.0.3
Author: Themes4WP
Author URI: http://themes4wp.com
Text Domain: giga-store-advanced-sections
Domain Path: /languages
License: GPLv2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! function_exists( 'add_action' ) ) {
	die( 'Nothing to do...' );
}

/* Important constants */
define( 'GIGA_STORE_ADVANCED_SECTIONS_VERSION', '1.0.1' );
define( 'GIGA_STORE_ADVANCED_SECTIONS_URL', plugin_dir_url( __FILE__ ) );
define( 'GIGA_STORE_ADVANCED_SECTIONS_PATH', plugin_dir_path( __FILE__ ) );

/* Required helper functions */
include_once( dirname( __FILE__ ) . '/inc/settings.php' );


if ( ! function_exists( 'giga_store_advanced_sections' ) ) {
	function giga_store_advanced_sections() {
	}
}

/**
 * Load plugin textdomain.
 *
 * @since 1.0.0
 */

add_action( 'plugins_loaded', 'giga_store_advanced_sections_load_textdomain' );

function giga_store_advanced_sections_load_textdomain() {
	load_plugin_textdomain( 'giga-store-advanced-sections', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

}