<?php
if ( get_option( 'show_on_front' ) == 'page' ) {
	include( get_page_template() );
} elseif ( class_exists( 'WooCommerce' ) && get_theme_mod( 'demo_front_page', 1 ) == 1 && ! is_child_theme() ) { // Display demo homepage only if WooCommerce plugin is activated, not a child theme and demo enabled via customizer.
	?>
	<?php get_header(); ?>

	<!-- start content container -->
	<div class="row rsrc-content-home">
		<?php if ( get_theme_mod( 'home_slider', '0' ) != '0' ) : ?>
			<?php get_template_part( 'templates/homepage', 'slider' ); ?>
		<?php endif; ?>
		<?php $sortable_value = maybe_unserialize( get_theme_mod( 'home_layout', array( 'woo_tabs_section', 'woo_products_section', 'blog_section' ) ) ); ?>
		<?php if ( ! empty( $sortable_value ) ) : ?>
			<?php $i = 0; ?>
			<?php foreach ( $sortable_value as $checked_value ) : ?>
				<section id="<?php echo esc_attr( $checked_value ); ?>" class="section<?php echo absint( $i ); ?>"><?php get_template_part( 'templates/homepage', esc_attr( $checked_value ) ); ?></section>
					<?php $i++; ?>
				<?php endforeach; ?>
			<?php endif; ?>
	</div>
	<!-- end content container -->

	<?php get_template_part( 'template-part', 'footernav' ); ?>

	<?php get_footer(); ?>

	<?php
} else { // Display blog posts.
	include( get_home_template() );
}
