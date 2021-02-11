<?php
function giga_store_advanced_sections_init_options() {
	if( class_exists( 'Kirki' ) ) {
  
  Kirki::add_config( 'giga_store_settings', array(
  	'capability'	 => 'edit_theme_options',
  	'option_type'	 => 'theme_mod',
  ) );
  
  /**
   * Sections base settings
   */
  $sections = array(
  	'banner'		 => array(
  		'color'			 => '#ffffff',
  		'title'			 => '',
  		'description'	 => '',
  	),
  	'testimonial'	 => array(
  		'color'			 => '#ffffff',
  		'title'			 => '',
  		'description'	 => '',
  	),
  );
  
  foreach ( $sections as $keys => $values ) {
  
  	Kirki::add_field( 'giga_store_settings', array(
  		'type'		 => 'color',
  		'settings'	 => $keys . '_section_color',
  		'label'		 => __( 'Section Background Color', 'giga-store-advanced-sections' ),
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
  		'label'		 => __( 'Section Font Color', 'giga-store-advanced-sections' ),
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
  		'label'		 => __( 'Section Title', 'giga-store-advanced-sections' ),
  		'default'	 => $values[ 'title' ],
  		'section'	 => $keys . '_section',
  		'priority'	 => 10,
  	) );
  	Kirki::add_field( 'giga_store_settings', array(
  		'type'		 => 'text',
  		'settings'	 => $keys . '_section_desc',
  		'label'		 => __( 'Section Description', 'giga-store-advanced-sections' ),
  		'default'	 => $values[ 'description' ],
  		'section'	 => $keys . '_section',
  		'priority'	 => 10,
  	) );
  }
  
  
  
  /**
   * Slider
   */
  Kirki::add_field( 'giga_store_settings', array(
  	'type'			 => 'switch',
  	'settings'		 => 'home_slider',
  	'label'			 => __( 'Slider', 'giga-store-advanced-sections' ),
  	'description'	 => __( 'Enable or Disable Slider on homepage', 'giga-store-advanced-sections' ),
  	'section'		 => 'homepage_layout',
  	'default'		 => '0',
  	'priority'		 => 10,
  ) );
  Kirki::add_field( 'giga_store_settings', array(
  	'type'		 => 'multicolor',
  	'settings'	 => 'slider_section',
  	'label'		 => esc_attr__( 'Button Color', 'giga-store-advanced-sections' ),
  	'section'	 => 'bg_image_section',
  	'priority'	 => 10,
  	'choices'	 => array(
  		'link'	 => esc_attr__( 'Color', 'giga-store-advanced-sections' ),
  		'hover'	 => esc_attr__( 'Hover', 'giga-store-advanced-sections' ),
  	),
  	'default'	 => array(
  		'link'	 => '#FFFFFF',
  		'hover'	 => '#666666',
  	),
  	'output'	 => array(
  		array(
  			'choice'	 => 'link',
  			'element'	 => 'a.flexslider-button',
  			'property'	 => 'color',
  		),
  		array(
  			'choice'	 => 'hover',
  			'element'	 => 'a.flexslider-button:hover',
  			'property'	 => 'color',
  		),
  	),
  ) );
  Kirki::add_field( 'giga_store_settings', array(
  	'type'		 => 'repeater',
  	'label'		 => __( 'Slider', 'giga-store-advanced-sections' ),
  	'section'	 => 'slider_section',
  	'priority'	 => 10,
  	'settings'	 => 'repeater_slider',
  	'default'	 => '',
  	'fields'	 => array(
  		'slider_image'		 => array(
  			'type'		 => 'image',
  			'label'		 => __( 'Image', 'giga-store-advanced-sections' ),
  			'default'	 => '',
  		),
  		'slider_heading'	 => array(
  			'type'		 => 'text',
  			'label'		 => __( 'Heading', 'giga-store-advanced-sections' ),
  			'default'	 => '',
  		),
  		'slider_title'		 => array(
  			'type'		 => 'text',
  			'label'		 => __( 'Title', 'giga-store-advanced-sections' ),
  			'default'	 => '',
  		),
  		'slider_desc'		 => array(
  			'type'		 => 'text',
  			'label'		 => __( 'Description', 'giga-store-advanced-sections' ),
  			'default'	 => '',
  		),
  		'slider_url'		 => array(
  			'type'		 => 'text',
  			'label'		 => __( 'URL', 'giga-store-advanced-sections' ),
  			'default'	 => '',
  		),
  		'slider_position'	 => array(
  			'type'		 => 'select',
  			'label'		 => __( 'Caption Position', 'giga-store-advanced-sections' ),
  			'default'	 => 'slider-left',
  			'choices'	 => array(
  				'slider-left'	 => __( 'Left', 'giga-store-advanced-sections' ),
  				'slider-center'	 => __( 'Center', 'giga-store-advanced-sections' ),
  				'slider-right'	 => __( 'Right', 'giga-store-advanced-sections' ),
  			),
  		),
  	),
    'row_label'	 => array(
    	'type'	 => 'text',
    	'value'	 => __( 'Slide', 'giga-store-advanced-sections' ),
    ),
  ) );
  
  /**
   * Testimonial Section
   */
  Kirki::add_field( 'giga_store_settings', array(
  	'type'		 => 'repeater',
  	'label'		 => __( 'Carousel Items', 'giga-store-advanced-sections' ),
  	'section'	 => 'testimonial_section',
  	'priority'	 => 10,
  	'settings'	 => 'repeater_testimonial',
  	'default'	 => '',
  	'fields'	 => array(
  		'testimonial_image'	 => array(
  			'type'		 => 'image',
  			'label'		 => __( 'Photo', 'giga-store-advanced-sections' ),
  			'default'	 => '',
  		),
  		'testimonial_name'	 => array(
  			'type'		 => 'text',
  			'label'		 => __( 'Name', 'giga-store-advanced-sections' ),
  			'default'	 => '',
  		),
  		'testimonial_desc'	 => array(
  			'type'		 => 'textarea',
  			'label'		 => __( 'Testimonial', 'giga-store-advanced-sections' ),
  			'default'	 => '',
  		),
  		'testimonial_url'	 => array(
  			'type'		 => 'text',
  			'label'		 => __( 'Link', 'giga-store-advanced-sections' ),
  			'default'	 => '',
  		),
  	),
    'row_label'	 => array(
    	'type'	 => 'text',
    	'value'	 => __( 'Testimonial', 'giga-store-advanced-sections' ),
    ),
  ) );
  /**
   * Banner Section
   */
  Kirki::add_field( 'giga_store_settings', array(
  	'type'			 => 'image',
  	'settings'		 => 'banner-section-image',
  	'label'			 => __( 'Background Image', 'giga-store-advanced-sections' ),
  	'description'	 => __( 'Recommended size: 760x450px', 'giga-store-advanced-sections' ),
  	'section'		 => 'banner_section',
  	'default'		 => '',
  	'priority'		 => 10,
  ) );
  Kirki::add_field( 'giga_store_settings', array(
  	'type'		 => 'textarea',
  	'settings'	 => 'banner-section-text',
  	'label'		 => __( 'Custom text', 'giga-store-advanced-sections' ),
  	'section'	 => 'banner_section',
  	'default'	 => '',
  	'priority'	 => 10,
  ) );
  Kirki::add_field( 'giga_store_settings', array(
  	'type'		 => 'color',
  	'settings'	 => 'banner-section-bg-color',
  	'label'		 => __( 'Textarea Background Color', 'giga-store-advanced-sections' ),
  	'section'	 => 'banner_section',
  	'default'	 => '#000000',
  	'priority'	 => 10,
  	'transport'	 => 'auto',
  	'output'	 => array(
  		array(
  			'element'	 => '.banner-section',
  			'property'	 => 'background-color',
  		),
  	),
  ) );
  Kirki::add_field( 'giga_store_settings', array(
  	'type'		 => 'color',
  	'settings'	 => 'banner-section-color',
  	'label'		 => __( 'Textarea Text Color', 'giga-store-advanced-sections' ),
  	'section'	 => 'banner_section',
  	'default'	 => '#ffffff',
  	'priority'	 => 10,
  	'transport'	 => 'auto',
  	'output'	 => array(
  		array(
  			'element'	 => '.banner-section',
  			'property'	 => 'color',
  		),
  	),
  ) );
  Kirki::add_field( 'giga_store_settings', array(
  	'type'		 => 'text',
  	'settings'	 => 'banner-section-button-text',
  	'label'		 => __( 'Button Text', 'giga-store-advanced-sections' ),
  	'default'	 => '',
  	'section'	 => 'banner_section',
  	'priority'	 => 10,
  ) );
  Kirki::add_field( 'giga_store_settings', array(
  	'type'		 => 'text',
  	'settings'	 => 'banner-section-button-url',
  	'label'		 => __( 'Button URL', 'giga-store-advanced-sections' ),
  	'default'	 => '',
  	'section'	 => 'banner_section',
  	'priority'	 => 10,
  ) );
  Kirki::add_field( 'giga_store_settings', array(
  	'type'		 => 'multicolor',
  	'settings'	 => 'banner-section-button-colors',
  	'label'		 => esc_attr__( 'Button Color', 'giga-store-advanced-sections' ),
  	'section'	 => 'banner_section',
  	'priority'	 => 10,
  	'choices'	 => array(
  		'link'	 => esc_attr__( 'Color', 'giga-store-advanced-sections' ),
  		'hover'	 => esc_attr__( 'Hover', 'giga-store-advanced-sections' ),
  	),
  	'default'	 => array(
  		'link'	 => '#FFFFFF',
  		'hover'	 => '#666666',
  	),
  	'output'	 => array(
  		array(
  			'choice'	 => 'link',
  			'element'	 => '#banner_section a.custom-button',
  			'property'	 => 'color',
  		),
  		array(
  			'choice'	 => 'hover',
  			'element'	 => '#banner_section a.custom-button:hover',
  			'property'	 => 'color',
  		),
  	),
  ) );
  } 
}
add_action( 'plugins_loaded', 'giga_store_advanced_sections_init_options' );