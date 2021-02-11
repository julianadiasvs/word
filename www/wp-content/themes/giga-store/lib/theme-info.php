<?php

/* * *
 * Theme Info
 *
 * Adds a simple Theme Info page to the Appearance section of the WordPress Dashboard.
 *
 */

// Add Theme Info page to admin menu.
add_action( 'admin_menu', 'giga_store_add_theme_info_page' );

function giga_store_add_theme_info_page() {

	// Get Theme Details from style.css
	$theme = wp_get_theme();

	add_theme_page(
		sprintf( esc_html__( 'Welcome to %1$s %2$s', 'giga-store' ), $theme->get( 'Name' ), $theme->get( 'Version' ) ), esc_html__( 'Theme Info', 'giga-store' ), 'edit_theme_options', 'giga-store', 'giga_store_display_theme_info_page'
	);
}

// Display Theme Info page.
function giga_store_display_theme_info_page() {

	// Get Theme Details from style.css.
	$theme = wp_get_theme();
	?>

	<div class="wrap theme-info-wrap">

		<h1><?php printf( esc_html__( 'Welcome to %1$s %2$s', 'giga-store' ), $theme->get( 'Name' ), $theme->get( 'Version' ) ); ?></h1>

		<div class="theme-description"><?php echo esc_html( $theme->get( 'Description' ) ); ?></div>

		<hr>
		<div class="important-links clearfix">
			<p><strong><?php esc_html_e( 'Theme Links', 'giga-store' ); ?>:</strong>
				<a href="<?php echo esc_url( 'http://themes4wp.com/theme/giga-store' ); ?>" target="_blank"><?php esc_html_e( 'Theme Page', 'giga-store' ); ?></a>
				<a href="<?php echo esc_url( 'http://demo.themes4wp.com/giga-store/' ); ?>" target="_blank"><?php esc_html_e( 'Theme Demo', 'giga-store' ); ?></a>
				<a href="<?php echo esc_url( 'http://demo.themes4wp.com/documentation/category/giga-store/' ); ?>" target="_blank"><?php esc_html_e( 'Theme Documentation', 'giga-store' ); ?></a>
				<a href="<?php echo esc_url( 'http://wordpress.org/support/view/theme-reviews/giga-store?filter=5' ); ?>" target="_blank"><?php esc_html_e( 'Rate this theme', 'giga-store' ); ?></a>
				<a href="<?php echo esc_url( 'https://wordpress.org/plugins/kirki/' ); ?>" target="_blank"><?php esc_html_e( 'Kirki (Theme options toolkit)', 'giga-store' ); ?></a>
			</p>
		</div>
		<hr>

		<div id="getting-started">

			<h3><?php printf( esc_html__( 'Getting Started with %s', 'giga-store' ), $theme->get( 'Name' ) ); ?></h3>

			<div class="columns-wrapper clearfix">

				<div class="column column-half clearfix">

					<div class="section">
						<h4><?php esc_html_e( 'Theme Documentation', 'giga-store' ); ?></h4>

						<p class="about">
							<?php esc_html_e( 'You need help to setup and configure this theme? We got you covered with an extensive theme documentation on our website.', 'giga-store' ); ?>
						</p>
						<p>
							<a href="<?php echo esc_url( 'http://demo.themes4wp.com/documentation/category/giga-store/' ); ?>" target="_blank" class="button button-secondary">
								<?php printf( esc_html__( 'View %s Documentation', 'giga-store' ), 'Giga Store' ); ?>
							</a>
						</p>
					</div>

					<div class="section">
						<h4><?php esc_html_e( 'Theme Options', 'giga-store' ); ?></h4>

						<p class="about">
							<?php printf( esc_html__( '%s makes use of the Customizer for all theme settings. First install Kirki Toolkit and than click on "Customize Theme" to open the Customizer.', 'giga-store' ), $theme->get( 'Name' ) ); ?>
						</p>
						<p>
							<a href="<?php echo wp_customize_url(); ?>" class="button button-primary">
								<?php esc_html_e( 'Customize Theme', 'giga-store' ); ?>
							</a>
						</p>
					</div>

				</div>

				<div class="column column-half clearfix">

					<img src="<?php echo esc_url(get_template_directory_uri()); ?>/screenshot.png" />

				</div>

			</div>

		</div>

		<hr>

		<div id="theme-author">

			<p>
				<?php printf( esc_html__( '%1$s is proudly brought to you by %2$s. If you like this theme, %3$s :)', 'giga-store' ), $theme->get( 'Name' ), '<a target="_blank" href="http://themes4wp.com/" title="Themes4WP">Themes4WP</a>', '<a target="_blank" href="http://wordpress.org/support/view/theme-reviews/giga-store?filter=5" title="' . esc_html__( 'Giga Store Review', 'giga-store' ) . '">' . esc_html__( 'rate it', 'giga-store' ) . '</a>' ); ?>
			</p>

		</div>

	</div>

	<?php
}

// Add CSS for Theme Info Panel.
add_action( 'admin_enqueue_scripts', 'giga_store_theme_info_page_css' );

function giga_store_theme_info_page_css( $hook ) {

	// Load styles and scripts only on theme info page.
	if ( 'appearance_page_giga-store' != $hook ) {
		return;
	}

	// Embed theme info css style.
	wp_enqueue_style( 'giga-store-theme-info-css', get_template_directory_uri() . '/css/theme-info.css' );
}
