<?php

/**
 * Kirki Advanced Customizer
 *
 * @package giga-store
 */
// Early exit if Kirki is not installed
if ( ! class_exists( 'Kirki' ) ) {
	return;
}
/* Register Kirki config */
Kirki::add_config( 'giga_store_settings', array(
	'capability'	 => 'edit_theme_options',
	'option_type'	 => 'theme_mod',
) );


/**
 * Add sections
 */
if ( class_exists( 'WooCommerce' ) && get_option( 'show_on_front' ) != 'page' && !is_child_theme() ) {
	Kirki::add_section( 'giga_store_woo_demo_section', array(
		'title'		 => __( 'WooCommerce Homepage Demo', 'giga-store' ),
		'priority'	 => 8,
	) );
}
Kirki::add_panel( 'homepage', array(
	'priority'	 => 10,
	'title'		 => __( 'Homepage Settings', 'giga-store' ),
) );

Kirki::add_section( 'homepage_layout', array(
	'title'		 => __( 'Homepage Layout', 'giga-store' ),
	'panel'		 => 'homepage',
	'priority'	 => 10,
) );
Kirki::add_section( 'slider_section', array(
	'title'		 => __( 'Slider Settings', 'giga-store' ),
	'panel'		 => 'homepage',
	'priority'	 => 10,
) );
Kirki::add_section( 'woo_tabs_section', array(
	'title'		 => __( 'WooCommerce Tabs Section Settings', 'giga-store' ),
	'panel'		 => 'homepage',
	'priority'	 => 10,
) );
Kirki::add_section( 'woo_products_section', array(
	'title'		 => __( 'WooCommerce Products Section Settings', 'giga-store' ),
	'panel'		 => 'homepage',
	'priority'	 => 10,
) );
Kirki::add_section( 'banner_section', array(
	'title'		 => __( 'Banner Section Settings', 'giga-store' ),
	'panel'		 => 'homepage',
	'priority'	 => 10,
) );
Kirki::add_section( 'testimonial_section', array(
	'title'		 => __( 'Testimonial Section Settings', 'giga-store' ),
	'panel'		 => 'homepage',
	'priority'	 => 10,
) );
Kirki::add_section( 'blog_section', array(
	'title'		 => __( 'Blog Section Settings', 'giga-store' ),
	'panel'		 => 'homepage',
	'priority'	 => 10,
) );

Kirki::add_section( 'sidebar_section', array(
	'title'			 => __( 'Sidebars', 'giga-store' ),
	'priority'		 => 10,
	'description'	 => __( 'Sidebar layouts.', 'giga-store' ),
) );

Kirki::add_section( 'layout_section', array(
	'title'			 => __( 'Main styling', 'giga-store' ),
	'priority'		 => 10,
	'description'	 => __( 'Define theme layout', 'giga-store' ),
) );

Kirki::add_section( 'search_bar_section', array(
	'title'		 => __( 'Search Bar', 'giga-store' ),
	'priority'	 => 10,
) );

Kirki::add_section( 'social_icons_section', array(
	'title'		 => __( 'Social icons', 'giga-store' ),
	'priority'	 => 10,
) );

Kirki::add_section( 'post_section', array(
	'title'			 => __( 'Post settings', 'giga-store' ),
	'priority'		 => 10,
	'description'	 => __( 'Single post settings', 'giga-store' ),
) );

if ( class_exists( 'WooCommerce' ) ) {
	Kirki::add_section( 'woo_section', array(
		'title'		 => __( 'WooCommerce', 'giga-store' ),
		'priority'	 => 10,
	) );
}

/**
 * Homepage cutom sections plugin
 */
if ( ! function_exists( 'giga_store_advanced_sections' ) ) {
	Kirki::add_field( 'giga_store_settings', array(
		'type'        => 'custom',
		'settings'    => 'plugin-deactivated',
		'label'       => __( 'Giga Store Advanced Sections plugin is deactivated!', 'giga-store' ),
		'description' => __( 'In order to use and setup slider, testimonials and custom image homepage sections, please install and activate the Giga Store Advanced Sections plugin.', 'giga-store' ),
		'section'     => 'homepage_layout',
		'default'     =>  '<a class="install-now button-primary button" href="' . esc_url( admin_url( 'themes.php?page=tgmpa-install-plugins' ) ) . '">' . esc_html__( 'Install Now','giga-store' ) . '</a>',
		'priority'    => 10,
	) );
}
/**
 * Homepage demo
 */
Kirki::add_field( 'giga_store_settings', array(
	'type'			 => 'switch',
	'settings'		 => 'demo_front_page',
	'label'			 => __( 'Enable WooCommerce Homepage?', 'giga-store' ),
	'description'	 => sprintf( __( 'When the theme is first installed and WooCommerce plugin activated, the WooCommerce homepage would be turned on. This will display WooCommerce content. You should turn this off. Check the %s page for more informations.', 'giga-store' ), '<a href="' . esc_url( admin_url( 'themes.php?page=giga-store' ) ) . '"><strong>' . __( 'Theme info', 'giga-store' ) . '</strong></a>' ),
	'section'		 => 'giga_store_woo_demo_section',
	'default'		 => 1,
	'priority'		 => 10,
) );
/**
 * Homepage Layout
 */
Kirki::add_field( 'giga_store_settings', array(
	'type'		 => 'sortable',
	'settings'	 => 'home_layout',
	'label'		 => esc_attr__( 'Homepage Blocks', 'giga-store' ),
	'section'	 => 'homepage_layout',
	'help'		 => esc_attr__( 'Drag and Drop and enable the homepage blocks.', 'giga-store' ),
	'default'	 => array( 'woo_tabs_section', 'woo_products_section', 'blog_section' ),
	'priority'	 => 10,
	'choices'	 => ( function_exists( 'giga_store_advanced_sections' ) ) ? array(
		'blog_section'			 => esc_attr__( 'Blog', 'giga-store' ),
		'woo_tabs_section'		 => esc_attr__( 'WooCommerce Tabs', 'giga-store' ),
		'woo_products_section'	 => esc_attr__( 'WooCommerce Products', 'giga-store' ),
		'banner_section'		 => esc_attr__( 'Banner', 'giga-store' ),
		'testimonial_section'	 => esc_attr__( 'Testimonial', 'giga-store' ) ) : array(
		'blog_section'			 => esc_attr__( 'Blog', 'giga-store' ),
		'woo_tabs_section'		 => esc_attr__( 'WooCommerce Tabs', 'giga-store' ),
		'woo_products_section'	 => esc_attr__( 'WooCommerce Products', 'giga-store' ),
	),
) );


/**
 * Sections base settings
 */
$sections = array(
	'woo_tabs'		 => array(
		'color'			 => '#ffffff',
		'title'			 => '',
		'description'	 => '',
	),
	'woo_products'	 => array(
		'color'			 => '#ffffff',
		'title'			 => '',
		'description'	 => '',
	),
	'blog'			 => array(
		'color'			 => '#ffffff',
		'title'			 => __( 'News', 'giga-store' ),
		'description'	 => __( 'From Our Blog', 'giga-store' ),
	),
);

foreach ( $sections as $keys => $values ) {

	Kirki::add_field( 'giga_store_settings', array(
		'type'		 => 'color',
		'settings'	 => $keys . '_section_color',
		'label'		 => __( 'Section Background Color', 'giga-store' ),
		'section'	 => $keys . '_section',
		'default'	 => $values[ 'color' ],
		'priority'	 => 10,
		'transport'	 => 'auto',
		'output'	 => array(
			array(
				'element'	 => '#' . $keys . '_section .section, #main-navigation .nav a.nav-' . $keys . '_section:after, #' . $keys . '_section .sub-title span',
				'property'	 => 'background-color',
			),
			array(
				'element'	 => '#' . $keys . '_section .border-top, #' . $keys . '_section .border-bottom',
				'property'	 => 'border-color',
			),
		),
	) );
	Kirki::add_field( 'giga_store_settings', array(
		'type'		 => 'color',
		'settings'	 => $keys . '_section_font_color',
		'label'		 => __( 'Section Font Color', 'giga-store' ),
		'section'	 => $keys . '_section',
		'default'	 => '#212121',
		'priority'	 => 10,
		'transport'	 => 'auto',
		'output'	 => array(
			array(
				'element'	 => '#' . $keys . '_section .section, #' . $keys . '_section .section a',
				'property'	 => 'color',
			),
			array(
				'element'	 => '#' . $keys . '_section .sub-title:before',
				'property'	 => 'background-color',
			),
		),
	) );
	Kirki::add_field( 'giga_store_settings', array(
		'type'		 => 'text',
		'settings'	 => $keys . '_section_title',
		'label'		 => __( 'Section Title', 'giga-store' ),
		'default'	 => $values[ 'title' ],
		'section'	 => $keys . '_section',
		'priority'	 => 10,
	) );
	Kirki::add_field( 'giga_store_settings', array(
		'type'		 => 'text',
		'settings'	 => $keys . '_section_desc',
		'label'		 => __( 'Section Description', 'giga-store' ),
		'default'	 => $values[ 'description' ],
		'section'	 => $keys . '_section',
		'priority'	 => 10,
	) );
}
/**
 * Woo Tabs Section
 */
Kirki::add_field( 'giga_store_settings', array(
	'type'		 => 'sortable',
	'settings'	 => 'woo_tabs_settings',
	'label'		 => esc_attr__( 'Blocks', 'giga-store' ),
	'section'	 => 'woo_tabs_section',
	'help'		 => esc_attr__( 'Drag and Drop and enable the blocks.', 'giga-store' ),
	'default'	 => array( 'sale_products', 'recent_products', 'featured_products', 'best_selling_products', 'top_rated_products' ),
	'priority'	 => 10,
	'choices'	 => array(
		'recent_products'		 => __( 'recent products', 'giga-store' ),
		'sale_products'			 => __( 'sale products', 'giga-store' ),
		'featured_products'		 => __( 'featured products', 'giga-store' ),
		'best_selling_products'	 => __( 'best selling products', 'giga-store' ),
		'top_rated_products'	 => __( 'top rated products', 'giga-store' ),
	),
) );
Kirki::add_field( 'giga_store_settings', array(
	'type'		 => 'radio-buttonset',
	'settings'	 => 'tabs_products_per_row',
	'label'		 => __( 'Visible products', 'giga-store' ),
	'section'	 => 'woo_tabs_section',
	'default'	 => '3',
	'priority'	 => 10,
	'choices'	 => array(
		'2'	 => '2',
		'3'	 => '3',
		'4'	 => '4',
	),
) );

/**
 * Woo Products Section
 */
Kirki::add_field( 'giga_store_settings', array(
	'type'		 => 'select',
	'settings'	 => 'woo_products_settings',
	'label'		 => esc_attr__( 'Products type', 'giga-store' ),
	'section'	 => 'woo_products_section',
	'default'	 => 'recent_products',
	'priority'	 => 10,
	'choices'	 => array(
		'sale_products'			 => __( 'sale products', 'giga-store' ),
		'featured_products'		 => __( 'featured products', 'giga-store' ),
		'best_selling_products'	 => __( 'best selling products', 'giga-store' ),
		'top_rated_products'	 => __( 'top rated products', 'giga-store' ),
		'recent_products'		 => __( 'recent products', 'giga-store' ),
	),
) );
Kirki::add_field( 'giga_store_settings', array(
	'type'		 => 'radio-buttonset',
	'settings'	 => 'products_per_row',
	'label'		 => __( 'Products per row', 'giga-store' ),
	'section'	 => 'woo_products_section',
	'default'	 => '4',
	'priority'	 => 10,
	'choices'	 => array(
		'2'	 => '2',
		'3'	 => '3',
		'4'	 => '4',
		'5'	 => '5',
		'6'	 => '6',
	),
) );
Kirki::add_field( 'giga_store_settings', array(
	'type'		 => 'slider',
	'settings'	 => 'products_per_page',
	'label'		 => __( 'Number of products', 'giga-store' ),
	'section'	 => 'woo_products_section',
	'default'	 => 8,
	'priority'	 => 10,
	'choices'	 => array(
		'min'	 => 1,
		'max'	 => 24,
		'step'	 => 1
	),
) );
/**
 * Siedebar Settings
 */
Kirki::add_field( 'giga_store_settings', array(
	'type'			 => 'switch',
	'settings'		 => 'rigth-sidebar-check',
	'label'			 => __( 'Right Sidebar', 'giga-store' ),
	'description'	 => __( 'Enable the Right Sidebar', 'giga-store' ),
	'section'		 => 'sidebar_section',
	'default'		 => 1,
	'priority'		 => 10,
) );

Kirki::add_field( 'giga_store_settings', array(
	'type'		 => 'radio-buttonset',
	'settings'	 => 'right-sidebar-size',
	'label'		 => __( 'Right Sidebar Size', 'giga-store' ),
	'section'	 => 'sidebar_section',
	'default'	 => '3',
	'priority'	 => 10,
	'choices'	 => array(
		'2'	 => '2',
		'3'	 => '3',
		'4'	 => '4',
		'5'	 => '5'
	),
	'required'	 => array(
		array(
			'setting'	 => 'rigth-sidebar-check',
			'operator'	 => '==',
			'value'		 => 1,
		),
	)
) );

Kirki::add_field( 'giga_store_settings', array(
	'type'			 => 'switch',
	'settings'		 => 'left-sidebar-check',
	'label'			 => __( 'Left Sidebar', 'giga-store' ),
	'description'	 => __( 'Enable the Left Sidebar', 'giga-store' ),
	'section'		 => 'sidebar_section',
	'default'		 => 0,
	'priority'		 => 10,
) );

Kirki::add_field( 'giga_store_settings', array(
	'type'		 => 'radio-buttonset',
	'settings'	 => 'left-sidebar-size',
	'label'		 => __( 'Left Sidebar Size', 'giga-store' ),
	'section'	 => 'sidebar_section',
	'default'	 => '2',
	'priority'	 => 10,
	'choices'	 => array(
		'2'	 => '2',
		'3'	 => '3',
		'4'	 => '4',
		'5'	 => '5'
	),
	'required'	 => array(
		array(
			'setting'	 => 'left-sidebar-check',
			'operator'	 => '==',
			'value'		 => 1,
		),
	)
) );


Kirki::add_field( 'giga_store_settings', array(
	'type'			 => 'switch',
	'settings'		 => 'related-posts-check',
	'label'			 => __( 'Related posts', 'giga-store' ),
	'description'	 => __( 'Enable or disable related posts', 'giga-store' ),
	'section'		 => 'post_section',
	'default'		 => 1,
	'priority'		 => 10,
) );
Kirki::add_field( 'giga_store_settings', array(
	'type'			 => 'switch',
	'settings'		 => 'author-check',
	'label'			 => __( 'Author box', 'giga-store' ),
	'description'	 => __( 'Enable or disable author box', 'giga-store' ),
	'section'		 => 'post_section',
	'default'		 => 1,
	'priority'		 => 10,
) );
Kirki::add_field( 'giga_store_settings', array(
	'type'			 => 'switch',
	'settings'		 => 'post-nav-check',
	'label'			 => __( 'Post navigation', 'giga-store' ),
	'description'	 => __( 'Enable or disable navigation below post content', 'giga-store' ),
	'section'		 => 'post_section',
	'default'		 => 1,
	'priority'		 => 10,
) );
if ( class_exists( 'WooCommerce' ) ) {
	Kirki::add_field( 'giga_store_settings', array(
		'type'			 => 'switch',
		'settings'		 => 'breadcrumbs-check',
		'label'			 => __( 'Breadcrumbs', 'giga-store' ),
		'description'	 => __( 'Enable or disable Breadcrumbs', 'giga-store' ),
		'section'		 => 'post_section',
		'default'		 => 1,
		'priority'		 => 10,
	) );
}
Kirki::add_field( 'giga_store_settings', array(
	'type'				 => 'text',
	'settings'			 => 'infobox-text',
	'label'				 => __( 'Search bar info text', 'giga-store' ),
	'help'				 => __( 'You can add custom text. Only text allowed!', 'giga-store' ),
	'section'			 => 'search_bar_section',
	'sanitize_callback'	 => 'wp_kses_post',
	'default'			 => '',
	'priority'			 => 10,
) );
Kirki::add_field( 'giga_store_settings', array(
	'type'			 => 'toggle',
	'settings'		 => 'giga_store_socials',
	'label'			 => __( 'Social Icons', 'giga-store' ),
	'description'	 => __( 'Enable or Disable the social icons', 'giga-store' ),
	'section'		 => 'social_icons_section',
	'default'		 => 0,
	'priority'		 => 10,
) );
$s_social_links = array(
	'facebook'		 => __( 'Facebook', 'giga-store' ),
	'twitter'		 => __( 'Twitter', 'giga-store' ),
	'google-plus'	 => __( 'Google-Plus', 'giga-store' ),
	'instagram'		 => __( 'Instagram', 'giga-store' ),
	'pinterest-p'	 => __( 'Pinterest', 'giga-store' ),
	'youtube'		 => __( 'YouTube', 'giga-store' ),
	'reddit'		 => __( 'Reddit', 'giga-store' ),
	'linkedin'		 => __( 'LinkedIn', 'giga-store' ),
	'vimeo'			 => __( 'Vimeo', 'giga-store' ),
	'envelope-o'	 => __( 'Email', 'giga-store' ),
);

foreach ( $s_social_links as $keys => $values ) {
	Kirki::add_field( 'giga_store_settings', array(
		'type'			 => 'text',
		'settings'		 => $keys,
		'label'			 => $values,
		'description'	 => sprintf( __( 'Insert your custom link to show the %s icon.', 'giga-store' ), $values ),
		'help'			 => __( 'Leave blank to hide icon.', 'giga-store' ),
		'section'		 => 'social_icons_section',
		'default'		 => '',
		'priority'		 => 10,
	) );
}

if ( function_exists( 'YITH_WCWL' ) ) {
	Kirki::add_field( 'giga_store_settings', array(
		'type'			 => 'switch',
		'settings'		 => 'wishlist-top-icon',
		'label'			 => __( 'Header Wishlist icon', 'giga-store' ),
		'description'	 => __( 'Enable or disable heart icon with counter in header', 'giga-store' ),
		'section'		 => 'woo_section',
		'default'		 => 0,
		'priority'		 => 10,
	) );
}
Kirki::add_field( 'giga_store_settings', array(
	'type'		 => 'switch',
	'settings'	 => 'giga_store_account',
	'label'		 => __( 'Header my account/login link', 'giga-store' ),
	'section'	 => 'woo_section',
	'default'	 => 1,
	'priority'	 => 10,
) );
Kirki::add_field( 'giga_store_settings', array(
	'type'		 => 'toggle',
	'settings'	 => 'woo_gallery_zoom',
	'label'		 => esc_attr__( 'Gallery zoom', 'giga-store' ),
	'section'	 => 'woo_section',
	'default'	 => 0,
	'priority'	 => 10,
) );
Kirki::add_field( 'giga_store_settings', array(
	'type'		 => 'toggle',
	'settings'	 => 'woo_gallery_lightbox',
	'label'		 => esc_attr__( 'Gallery lightbox', 'giga-store' ),
	'section'	 => 'woo_section',
	'default'	 => 1,
	'priority'	 => 10,
) );
Kirki::add_field( 'giga_store_settings', array(
	'type'		 => 'toggle',
	'settings'	 => 'woo_gallery_slider',
	'label'		 => esc_attr__( 'Gallery slider', 'giga-store' ),
	'section'	 => 'woo_section',
	'default'	 => 0,
	'priority'	 => 10,
) );
Kirki::add_field( 'giga_store_settings', array(
	'type'			 => 'slider',
	'settings'		 => 'archive_number_products',
	'label'			 => __( 'Number of products', 'giga-store' ),
	'description'	 => __( 'Change number of products displayed per page in archive(shop) page.', 'giga-store' ),
	'section'		 => 'woo_section',
	'default'		 => 24,
	'priority'		 => 10,
	'choices'		 => array(
		'min'	 => 2,
		'max'	 => 60,
		'step'	 => 1
	),
) );
Kirki::add_field( 'giga_store_settings', array(
	'type'			 => 'slider',
	'settings'		 => 'archive_number_columns',
	'label'			 => __( 'Number of products per row', 'giga-store' ),
	'description'	 => __( 'Change the number of product columns per row in archive(shop) page.', 'giga-store' ),
	'section'		 => 'woo_section',
	'default'		 => 4,
	'priority'		 => 10,
	'choices'		 => array(
		'min'	 => 2,
		'max'	 => 5,
		'step'	 => 1
	),
) );


/**
 * Configuration sample for the giga-store Customizer.
 */
function giga_store_configuration_sample() {

	$config[ 'color_back' ]		 = '#192429';
	$config[ 'color_accent' ]	 = '#008ec2';
	$config[ 'width' ]			 = '25%';

	return $config;
}

add_filter( 'kirki/config', 'giga_store_configuration_sample' );

/**
 * Add custom CSS styles
 */
function giga_store_enqueue_header_css() {

	$columns = get_theme_mod( 'archive_number_columns', 4 );

	if ( $columns == '2' ) {
		$css = '@media only screen and (min-width: 769px) {.archive .rsrc-content .woocommerce ul.products li.product{width: 48.05%}}';
	} elseif ( $columns == '3' ) {
		$css = '@media only screen and (min-width: 769px) {.archive .rsrc-content .woocommerce ul.products li.product{width: 30.75%;}}';
	} elseif ( $columns == '5' ) {
		$css = '@media only screen and (min-width: 769px) {.archive .rsrc-content .woocommerce ul.products li.product{width: 16.95%;}}';
	} else {
		$css = '';
	}
	wp_add_inline_style( 'kirki-styles-giga_store_settings', $css );
}

add_action( 'wp_enqueue_scripts', 'giga_store_enqueue_header_css', 9999 );
