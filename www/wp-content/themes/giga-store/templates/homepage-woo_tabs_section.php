<?php $sortable_value	 = maybe_unserialize( get_theme_mod( 'woo_tabs_settings', array( 'sale_products', 'recent_products', 'featured_products', 'best_selling_products', 'top_rated_products' ) ) ); ?>
<div class="section">  
	<div class="container">
		<div class="container-heading text-center">
			<?php if ( get_theme_mod( 'woo_tabs_section_title', '' ) != '' ) : ?>
				<h4><?php echo esc_html( get_theme_mod( 'woo_tabs_section_title', '' ) ); ?></h4>
			<?php endif; ?>
			<?php if ( get_theme_mod( 'woo_tabs_section_desc', '' ) != '' ) : ?>
				<div class="sub-title"><span><?php echo esc_html( get_theme_mod( 'woo_tabs_section_desc', '' ) ); ?></span></div>
			<?php endif; ?>
		</div>
		<?php if ( class_exists( 'WooCommerce' ) ) : ?>
			<div class="woo-tabs-section row">
				<div class="col-sm-3">
					<ul class="nav nav-tabs tabs-left">
						<?php $i = 0; ?>
						<?php foreach ( $sortable_value as $checked_value ) : ?>
							<?php $title = str_replace( '_', ' ', $checked_value ); ?>	
							<li class="<?php if ( $i == 0 ) { echo 'active'; } ?>">
								<a href="#<?php echo esc_attr( $checked_value ); ?>" data-toggle="tab">
									<?php
									if ( $checked_value == 'recent_products' ) {
										esc_html_e( 'recent products', 'giga-store' );
									}
									?>
									<?php
									if ( $checked_value == 'sale_products' ) {
										esc_html_e( 'sale products', 'giga-store' );
									}
									?>
									<?php
									if ( $checked_value == 'featured_products' ) {
										esc_html_e( 'featured products', 'giga-store' );
									}
									?>
									<?php
									if ( $checked_value == 'best_selling_products' ) {
										esc_html_e( 'best selling products', 'giga-store' );
									}
									?>
									<?php
									if ( $checked_value == 'top_rated_products' ) {
										esc_html_e( 'top rated products', 'giga-store' );
									}
									?>
								</a>
							</li>
							<?php $i++; ?>
						<?php endforeach; ?>
					</ul>
				</div>
				<div class="col-sm-9">
					<div class="tab-content">
						<?php $i = 0; ?>
						<?php foreach ( $sortable_value as $checked_value ) : ?>	
							<div class="tab-pane <?php if ( $i == 0 ) { echo 'active'; } ?>" id="<?php echo esc_attr( $checked_value ); ?>" data-container="<?php echo esc_attr( $checked_value ); ?>" >
								<?php echo do_shortcode( '[' . $checked_value . ' per_page="' . absint( get_theme_mod( 'tabs_products_per_row', '3' ) ) . '" columns="' . absint( get_theme_mod( 'tabs_products_per_row', '3' ) ) . '"]' ) ?>
							</div>
							<?php $i++; ?>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		<?php elseif ( ! class_exists( 'WooCommerce' ) && current_user_can( 'edit_theme_options' ) ) : ?>
			<?php esc_html_e( 'This area needs to function the WooCommerce Plugin. Install the WooCommerce plugin or disable this area in customizer admin panel.', 'giga-store' ) ?>
		<?php endif; ?>
	</div>
</div>
