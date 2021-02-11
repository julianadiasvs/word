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
		<?php
		echo '<h2 class="page-header text-center">' . sprintf( __( 'Search Results for: %s', 'giga-store' ), '<span>' . get_search_query() . '</span>' ) . '</h2>';
		if ( have_posts() ) : while ( have_posts() ) : the_post();
				get_template_part( 'content', get_post_format() );
			endwhile;
		else :
			get_template_part( 'content', 'none' );
		endif;
		?>
	</div>

<?php get_sidebar( 'right' ); ?>

</div>
<!-- end content container -->

<?php get_template_part( 'template-part', 'footernav' ); ?>

<?php get_footer();
