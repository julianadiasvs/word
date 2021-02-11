<?php
/**
 *
 * Template name: Homepage
 * The template for displaying homepage.
 *
 * @package giga-store
 */
get_header();
?>

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

<?php
get_footer();
