<?php
get_header();

if ( class_exists( 'WooCommerce' ) && get_theme_mod( 'breadcrumbs-check', 1 ) != 0 ) {
	woocommerce_breadcrumb();
}
?>

<!-- start content container -->
<div class="row container rsrc-content">

	<?php get_sidebar( 'left' ); ?>

	<div class="col-md-<?php giga_store_main_content_width_columns(); ?> rsrc-main">
		<div class="rsrc-post-content">
			<div class="error-template text-center">
				<h1><?php esc_html_e( 'Oops!', 'giga-store' ); ?></h1>
				<h2><?php esc_html_e( '404 Not Found', 'giga-store' ); ?></h2>
				<p class="error-details">
					<?php esc_html_e( 'Sorry, an error has occured, Requested page not found!', 'giga-store' ); ?>
				</p>
				<div class="error-actions">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary btn-lg"><span class="fa fa-home"></span><?php esc_html_e( ' Take Me Home', 'giga-store' ); ?></a>    
				</div>
			</div>
		</div>
	</div>

	<?php get_sidebar( 'right' ); ?>

</div>
<!-- end content container -->

<?php
get_footer();
