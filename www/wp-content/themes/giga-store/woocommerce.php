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
		<div class="woocommerce">
			<?php woocommerce_content(); ?>
		</div>
	</div>      
	<?php get_sidebar( 'right' ); ?>
</div>

<!-- end content container -->

<?php
get_footer();
