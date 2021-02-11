<?php

/**
 * Customizer options
 * This will display some important notices
 *
 * @package giga-store
 */
// Early exit if Kirki is installed
if ( class_exists( 'Kirki' ) ) {
	return;
}

function giga_store_customizer_options( $wp_customize ) {

	if ( class_exists( 'WooCommerce' ) && get_option( 'show_on_front' ) != 'page' && !is_child_theme() ) {
		$wp_customize->add_section( 'giga_store_woo_demo_section', array(
			'title'		 => __( 'WooCommerce Homepage', 'giga-store' ),
			'priority'	 => 10,
		) );
	}

	$wp_customize->add_setting( 'demo_front_page', array(
		'capability'		 => 'edit_theme_options',
		'type'				 => 'theme_mod',
		'default'			 => '1',
		'transport'			 => 'refresh',
		'sanitize_callback'	 => 'absint',
	) );

	$wp_customize->add_control( 'demo_front_page', array(
		'section'		 => 'giga_store_woo_demo_section',
		'label'			 => __( 'Enable WooCommerce Homepage?', 'giga-store' ),
		'description'	 => sprintf( __( 'When the theme is first installed and WooCommerce plugin activated, the WooCommerce homepage would be turned on. This will display WooCommerce content. You should turn this off. Check the %s page for more informations.', 'giga-store' ), '<a href="' . esc_url( admin_url( 'themes.php?page=giga-store' ) ) . '"><strong>' . __( 'Theme info', 'giga-store' ) . '</strong></a>' ),
		'type'			 => 'checkbox'
	)
	);
}

add_action( 'customize_register', 'giga_store_customizer_options' );
