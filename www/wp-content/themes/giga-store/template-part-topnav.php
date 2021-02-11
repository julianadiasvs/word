<?php if ( has_nav_menu( 'top_menu' ) || get_theme_mod( 'giga_store_socials', 0 ) == 1 || class_exists( 'WooCommerce' ) && get_theme_mod( 'giga_store_account', 1 ) == 1 ) : ?>
	<div class="rsrc-top-menu ">
		<div class="container">
			<nav id="site-navigation" class="navbar navbar-inverse" role="navigation">    
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-1-collapse">
						<span class="sr-only"><?php esc_html_e( 'Toggle navigation', 'giga-store' ); ?></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<div class="visible-xs navbar-brand"><?php esc_html_e( 'Menu', 'giga-store' ); ?></div>
				</div>
				<?php if ( get_theme_mod( 'giga_store_socials', 0 ) == 1 ) : ?>
					<div class="top-section nav navbar-nav navbar-right">
						<?php giga_store_social_links(); ?>                 
					</div>
				<?php endif; ?>
				<div class="header-login nav navbar-nav navbar-right"> 
					<?php if ( class_exists( 'WooCommerce' ) ) { ?>
						<?php if ( get_theme_mod( 'giga_store_account', 1 ) == 1 ) { ?>
							<?php if ( is_user_logged_in() ) { ?>
								<a class="login-link" href="<?php echo esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ); ?>" title="<?php esc_attr_e( 'My Account', 'giga-store' ); ?>"><?php esc_html_e( 'My Account', 'giga-store' ); ?></a>
							<?php } else { ?>
								<a class="login-link" href="<?php echo esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ); ?>" title="<?php esc_attr_e( 'Login / Register', 'giga-store' ); ?>"><?php esc_html_e( 'Login / Register', 'giga-store' ); ?></a>
							<?php } ?>
					<?php } ?> 
				<?php } ?>
				</div> 
				<?php
				wp_nav_menu( array(
					'theme_location'	 => 'top_menu',
					'depth'				 => 3,
					'container'			 => 'div',
					'container_class'	 => 'collapse navbar-collapse navbar-1-collapse',
					'menu_class'		 => 'nav navbar-nav',
					'fallback_cb'		 => 'wp_bootstrap_navwalker::fallback',
					'walker'			 => new wp_bootstrap_navwalker(),
					)
				);
				?>
			</nav>
		</div>
	</div>
	<?php
endif;
