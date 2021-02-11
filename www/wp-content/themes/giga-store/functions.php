<?php
////////////////////////////////////////////////////////////////////
// Setting theme options
//////////////////////////////////////////////////////////////////// 
include_once( trailingslashit( get_template_directory() ) . 'lib/plugin-activation.php' );
include_once( trailingslashit( get_template_directory() ) . 'lib/theme-config.php' );
include_once( trailingslashit( get_template_directory() ) . 'lib/include-kirki.php' );
include_once( trailingslashit( get_template_directory() ) . 'lib/customizer.php' );

add_action( 'after_setup_theme', 'giga_store_setup' );

if ( !function_exists( 'giga_store_setup' ) ) :

	function giga_store_setup() {

		// Theme lang
		load_theme_textdomain( 'giga-store', get_template_directory() . '/languages' );

		// Add Title Tag Support
		add_theme_support( 'title-tag' );

		add_theme_support( 'custom-logo', array(
			'height'		 => 100,
			'width'			 => 400,
			'flex-height'	 => true,
			'flex-width'	 => true,
		) );

		// Register Menus
		register_nav_menus(
		array(
			'top_menu'		 => __( 'Top Menu', 'giga-store' ),
			'main_menu'		 => __( 'Main Menu', 'giga-store' ),
			'footer_menu'	 => __( 'Footer Menu', 'giga-store' ),
		)
		);

		// Add support for a featured image and the size
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 300, 300, true );
		add_image_size( 'giga-store-home', 400, 300, true );
		add_image_size( 'giga-store-square', 400, 400, true );
		add_image_size( 'giga-store-single', 1600, 400, true );
		
		// Add Custom Background Support
		$args = array(
			'default-color' => 'FFFFFF',
		);
		add_theme_support( 'custom-background', $args );

		// Adds RSS feed links to for posts and comments.
		add_theme_support( 'automatic-feed-links' );

		// WooCommerce support
		add_theme_support( 'woocommerce' );
		if ( get_theme_mod( 'woo_gallery_zoom', 0 ) == 1 ) {
			add_theme_support( 'wc-product-gallery-zoom' );
		}
		if ( get_theme_mod( 'woo_gallery_lightbox', 1 ) == 1 ) {
			add_theme_support( 'wc-product-gallery-lightbox' );
		}
		if ( get_theme_mod( 'woo_gallery_slider', 0 ) == 1 ) {
			add_theme_support( 'wc-product-gallery-slider' );
		}
	}

endif;

// Set Content Width
function giga_store_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'giga_store_content_width', 1170 );
}
add_action( 'after_setup_theme', 'giga_store_content_width', 0 );

////////////////////////////////////////////////////////////////////
// Enqueue Styles (normal style.css and bootstrap.css)
////////////////////////////////////////////////////////////////////
function giga_store_theme_stylesheets() {
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array(), '3.3.6' );
	wp_enqueue_style( 'giga-store-stylesheet', get_stylesheet_uri(), array(), '1.1.0', 'all' );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', array(), '4.6.3' );
	wp_enqueue_style( 'flexslider', get_template_directory_uri() . '/css/flexslider.css', array(), '2.6.0' );
	wp_enqueue_style( 'of-canvas-menu', get_template_directory_uri() . '/css/jquery.mmenu.all.css', array(), '5.5.3' );
	wp_enqueue_style( 'animate', get_template_directory_uri() . '/css/animate.min.css', array(), '3.5.1' );
}

add_action( 'wp_enqueue_scripts', 'giga_store_theme_stylesheets' );

////////////////////////////////////////////////////////////////////
// Register Bootstrap JS with jquery
////////////////////////////////////////////////////////////////////
function giga_store_theme_js() {
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.js', array( 'jquery' ), '3.3.6', true );
	wp_enqueue_script( 'giga-store-theme-js', get_template_directory_uri() . '/js/customscript.js', array( 'jquery', 'flexslider' ), '1.1.0', true );
	wp_enqueue_script( 'flexslider', get_template_directory_uri() . '/js/jquery.flexslider-min.js', array( 'jquery' ), '2.6.0', true );
	wp_enqueue_script( 'of-canvas-menu', get_template_directory_uri() . '/js/jquery.mmenu.min.all.js', array( 'jquery' ), '5.5.3', true );
}

add_action( 'wp_enqueue_scripts', 'giga_store_theme_js' );


////////////////////////////////////////////////////////////////////
// Register Custom Navigation Walker include custom menu widget to use walkerclass
////////////////////////////////////////////////////////////////////

require_once( trailingslashit( get_template_directory() ) . 'lib/wp_bootstrap_navwalker.php' );

////////////////////////////////////////////////////////////////////
// Theme Info page
////////////////////////////////////////////////////////////////////

if ( is_admin() ) {
	require_once( trailingslashit( get_template_directory() ) . 'lib/theme-info.php' );
}

////////////////////////////////////////////////////////////////////
// Register the Sidebar(s)
////////////////////////////////////////////////////////////////////
add_action( 'widgets_init', 'giga_store_widgets_init' );

function giga_store_widgets_init() {
	register_sidebar(
	array(
		'name'			 => __( 'Right Sidebar', 'giga-store' ),
		'id'			 => 'giga-store-right-sidebar',
		'before_widget'	 => '<div id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</div>',
		'before_title'	 => '<h3 class="widget-title">',
		'after_title'	 => '</h3>',
	) );

	register_sidebar(
	array(
		'name'			 => __( 'Left Sidebar', 'giga-store' ),
		'id'			 => 'giga-store-left-sidebar',
		'before_widget'	 => '<div id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</div>',
		'before_title'	 => '<h3 class="widget-title">',
		'after_title'	 => '</h3>',
	) );

	register_sidebar(
	array(
		'name'			 => __( 'Footer Section', 'giga-store' ),
		'id'			 => 'giga-store-footer-area',
		'description'	 => __( 'Content Footer Section', 'giga-store' ),
		'before_widget'	 => '<div id="%1$s" class="widget %2$s col-md-3"><div class="widget-inner">',
		'after_widget'	 => '</div></div>',
		'before_title'	 => '<h3 class="widget-title">',
		'after_title'	 => '</h3>',
	) );
}

////////////////////////////////////////////////////////////////////
// Register hook and action to set Main content area col-md- width based on sidebar declarations
////////////////////////////////////////////////////////////////////

add_action( 'giga_store_main_content_width_hook', 'giga_store_main_content_width_columns' );

function giga_store_main_content_width_columns() {

	$columns = '12';

	if ( get_theme_mod( 'rigth-sidebar-check', 1 ) != 0 ) {
		$columns = $columns - absint( get_theme_mod( 'right-sidebar-size', 3 ) );
	}

	if ( get_theme_mod( 'left-sidebar-check', 0 ) != 0 ) {
		$columns = $columns - absint( get_theme_mod( 'left-sidebar-size', 3 ) );
	}

	echo absint( $columns );
}

////////////////////////////////////////////////////////////////////
// Social links
////////////////////////////////////////////////////////////////////
if ( !function_exists( 'giga_store_social_links' ) ) :

	function giga_store_social_links() {
		$twp_social_links	 = array(
			'facebook'		 => esc_html__( 'Facebook', 'giga-store' ),
			'twitter'		 => esc_html__( 'Twitter', 'giga-store' ),
			'google-plus'	 => esc_html__( 'Google-Plus', 'giga-store' ),
			'instagram'		 => esc_html__( 'Instagram', 'giga-store' ),
			'pinterest-p'	 => esc_html__( 'Pinterest', 'giga-store' ),
			'youtube'		 => esc_html__( 'YouTube', 'giga-store' ),
			'reddit'		 => esc_html__( 'Reddit', 'giga-store' ),
			'linkedin'		 => esc_html__( 'LinkedIn', 'giga-store' ),
			'vimeo'			 => esc_html__( 'Vimeo', 'giga-store' ),
			'envelope-o'	 => esc_html__( 'Email', 'giga-store' ),
		);
		?>
		<div class="social-links">
			<ul>
				<?php
				$i					 = 0;
				$twp_links_output	 = '';
				foreach ( $twp_social_links as $key => $value ) {
					$link = get_theme_mod( $key, '' );
					if ( !empty( $link ) ) {
						$twp_links_output .=
						'<li><a href="' . esc_url( $link ) . '" title="' . esc_attr( $value ) . '" target="_blank"><i class="fa fa-' . strtolower( $key ) . '"></i></a></li>';
					}
					$i++;
				}
				echo $twp_links_output;
				?>
			</ul>
		</div><!-- .social-links -->
		<?php
	}

endif;

////////////////////////////////////////////////////////////////////
// Excerpt functions
////////////////////////////////////////////////////////////////////
function giga_store_excerpt_length( $length ) {
	return 20;
}

add_filter( 'excerpt_length', 'giga_store_excerpt_length', 999 );

function giga_store_excerpt_more( $more ) {
	return '&hellip;';
}

add_filter( 'excerpt_more', 'giga_store_excerpt_more' );

////////////////////////////////////////////////////////////////////
// Comment style
////////////////////////////////////////////////////////////////////
function giga_store_comment_text( $content ) {
    return "<div class=\"comment-inner\">" . $content . "</div>";
}
add_filter( 'comment_text', 'giga_store_comment_text', 1000 );

////////////////////////////////////////////////////////////////////
// WooCommerce section
////////////////////////////////////////////////////////////////////
if ( class_exists( 'WooCommerce' ) ) {

////////////////////////////////////////////////////////////////////
// WooCommerce header cart
////////////////////////////////////////////////////////////////////
	if ( !function_exists( 'giga_store_cart_link' ) ) {

		function giga_store_cart_link() {
			?>	
			<a class="cart-contents text-right" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'giga-store' ); ?>">
				<i class="fa fa-shopping-cart"><span class="count"><?php echo wp_kses_data( WC()->cart->get_cart_contents_count() ); ?></span></i><div class="amount-title"><?php echo esc_html_e( 'Cart ', 'giga-store' ); ?></div><div class="amount-cart"><?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?></div> 
			</a>
			<?php
		}

	}
	if ( !function_exists( 'giga_store_head_wishlist' ) ) {

		function giga_store_head_wishlist() {
			if ( function_exists( 'YITH_WCWL' ) ) {
				$wishlist_url = YITH_WCWL()->get_wishlist_url();
				?>
				<div class="top-wishlist text-right">
					<a href="<?php echo esc_url( $wishlist_url ); ?>" title="<?php esc_attr_e( 'Wishlist', 'giga-store' ); ?>" data-toggle="tooltip" data-placement="top">
						<div class="fa fa-heart"><div class="count"><span><?php echo absint( yith_wcwl_count_products() ); ?></span></div></div>
					</a>
				</div>
				<?php
			}
		}

	}
	add_action( 'wp_ajax_yith_wcwl_update_single_product_list', 'giga_store_head_wishlist' );
	add_action( 'wp_ajax_nopriv_yith_wcwl_update_single_product_list', 'giga_store_head_wishlist' );

	if ( !function_exists( 'giga_store_header_cart' ) ) {

		function giga_store_header_cart() {
			?>
			<div class="header-cart text-right col-sm-5 text-center-sm text-center-xs no-gutter">
				<div class="header-cart-block">
					<div class="header-cart-inner">
						<?php giga_store_cart_link(); ?>
						<ul class="site-header-cart menu list-unstyled">
							<li>
								<?php the_widget( 'WC_Widget_Cart', 'title=' ); ?>
							</li>
						</ul>
					</div>
					<?php
					if ( get_theme_mod( 'wishlist-top-icon', 0 ) != 0 ) {
						giga_store_head_wishlist();
					}
					?>
				</div>
			</div>
			<?php
		}

	}
	if ( ! function_exists( 'giga_store_header_add_to_cart_fragment' ) ) {
		add_filter( 'woocommerce_add_to_cart_fragments', 'giga_store_header_add_to_cart_fragment' );

		function giga_store_header_add_to_cart_fragment( $fragments ) {
			ob_start();

			giga_store_cart_link();

			$fragments[ 'a.cart-contents' ] = ob_get_clean();

			return $fragments;
		}
	}
	
	add_filter( 'loop_shop_columns', 'giga_store_loop_columns' );
	
	if ( !function_exists( 'giga_store_loop_columns' ) ) {

		function giga_store_loop_columns() {
			return absint( get_theme_mod( 'archive_number_columns', 4 ) );
		}

	}
	add_filter( 'loop_shop_per_page', 'giga_store_new_loop_shop_per_page', 20 );

	function giga_store_new_loop_shop_per_page( $cols ) {
	  // $cols contains the current number of products per page based on the value stored on Options -> Reading
	  // Return the number of products you wanna show per page.
	  $cols = absint( get_theme_mod( 'archive_number_products', 24 ) );
	  return $cols;
	}
	
	// WooCommerce Breadcrumbs Styling.
	add_filter( 'woocommerce_breadcrumb_defaults', 'giga_store_custom_breadcrumb' );
	function giga_store_custom_breadcrumb() {
		return array(
				'delimiter'   => ' &raquo; ',
				'wrap_before' => '<div id="breadcrumbs" ><div class="breadcrumbs-inner container text-left"><i class="fa fa-home" aria-hidden="true"></i>',
				'wrap_after'  => '</div></div>',
				'before'      => '',
				'after'       => '',
				'home'        => esc_html_x( 'Home', 'breadcrumb', 'giga-store' ),
			);
	}
	
}

if ( ! function_exists( 'wp_body_open' ) ) :
    /**
     * Fire the wp_body_open action.
     *
     * Added for backwards compatibility to support pre 5.2.0 WordPress versions.
     *
     */
    function wp_body_open() {
        /**
         * Triggered after the opening <body> tag.
         *
         */
        do_action( 'wp_body_open' );
    }
endif;

/**
 * Include a skip to content link at the top of the page so that users can bypass the header.
 */
function giga_store_skip_link() {
	echo '<a class="skip-link screen-reader-text" href="#site-content">' . esc_html__( 'Skip to the content', 'giga-store' ) . '</a>';
}

add_action( 'wp_body_open', 'giga_store_skip_link', 5 );

