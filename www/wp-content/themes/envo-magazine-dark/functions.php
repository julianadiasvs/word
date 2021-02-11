<?php
/**
 * Function describe for envo magazine child
 * 
 * @package envo-magazine-dark
 */


add_action( 'wp_enqueue_scripts', 'envo_magazine_child_enqueue_styles' );
function envo_magazine_child_enqueue_styles() {

    $parent_style = 'envo-magazine-stylesheet';

        wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css', array( 'bootstrap' ));
        wp_enqueue_style('envo-magazine-child-style',
                get_stylesheet_directory_uri() . '/style.css',
                array($parent_style),
                wp_get_theme()->get('Version')
        );


}

/**
 * Register Theme Info Page
 */
require_once( trailingslashit( get_template_directory() ) . 'lib/dashboard.php' );
/**
 * Register PRO notify
 */
require_once( trailingslashit( get_template_directory() ) . 'lib/customizer.php' );
