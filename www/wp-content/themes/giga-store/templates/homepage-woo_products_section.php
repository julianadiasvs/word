<div class="section">  
	<div class="container">
		<div class="container-heading text-center">
			<?php if ( get_theme_mod( 'woo_products_section_title', '' ) != '' ) : ?>
				<h4><?php echo esc_html( get_theme_mod( 'woo_products_section_title', '' ) ); ?></h4>
			<?php endif; ?>
			<?php if ( get_theme_mod( 'woo_products_section_desc', '' ) != '' ) : ?>
				<div class="sub-title"><span><?php echo esc_html( get_theme_mod( 'woo_products_section_desc', '' ) ); ?></span></div>
			<?php endif; ?>
		</div>
		<?php if ( class_exists( 'WooCommerce' ) ) : ?>
			<div class="woo-tabs-section row">
				<div class="col-sm-12">
					<?php
					$query = new WP_Query( array(
						'post_type' => 'product',
					) );
					if ( $query->have_posts() ) :
						echo do_shortcode( '[' . esc_attr( get_theme_mod( 'woo_products_settings', 'recent_products' ) ) . ' per_page="' . absint( get_theme_mod( 'products_per_page', '8' ) ) . '" columns="' . absint( get_theme_mod( 'products_per_row', '4' ) ) . '"]' ); 
					else : 
					?>
						<div class="text-center">
							<?php esc_html_e( 'No products found', 'giga-store' ) ?>
						</div>	
					<?php endif; ?>
				</div>
			</div>
		<?php elseif ( ! class_exists( 'WooCommerce' ) && current_user_can( 'edit_theme_options' ) ) : ?>
			<?php esc_html_e( 'This area needs to function properly installed WooCommerce Plugin. You can disable this area in customizer admin panel.', 'giga-store' ) ?>
		<?php endif; ?>
	</div>
</div>
