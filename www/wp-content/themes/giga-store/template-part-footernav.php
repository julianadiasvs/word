<?php if ( has_nav_menu( 'footer_menu' ) ) : ?>
	<div class="row rsrc-footer-menu">
		<div class="container">
			<nav id="footer-navigation" class="navbar navbar-inverse" role="navigation">
				<a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php echo esc_html( get_bloginfo( 'name', 'display' ) ); ?></a>
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-2-collapse">
						<span class="sr-only"><?php esc_html_e( 'Toggle navigation', 'giga-store' ); ?></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<?php
				wp_nav_menu( array(
					'theme_location'	 => 'footer_menu',
					'depth'				 => 1,
					'container'			 => 'div',
					'container_class'	 => 'collapse navbar-collapse navbar-2-collapse navbar-right',
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
