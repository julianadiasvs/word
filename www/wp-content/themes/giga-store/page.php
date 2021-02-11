<?php
get_header();

if ( class_exists( 'WooCommerce' ) && get_theme_mod( 'breadcrumbs-check', 1 ) != 0 ) {
	woocommerce_breadcrumb();
}
?>

<!-- start content container -->
<?php get_template_part( 'content', 'page' ); ?>
<!-- end content container -->

<?php

get_template_part( 'template-part', 'footernav' );

get_footer();
