<div class="container-fluid rsrc-container-header">
	<div class="header-section row">
		<div class="container">
			<header id="site-header" class="col-sm-3 text-center-sm hidden-xs rsrc-header" itemscope itemtype="http://schema.org/WPHeader" role="banner"> 
				<?php
				if ( function_exists( 'has_custom_logo' ) && has_custom_logo() ) {
					the_custom_logo();
				} else {
					if ( is_front_page() && is_home() ) :
						?>
						<h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php echo esc_html( get_bloginfo( 'name', 'display' ) ); ?></a></h1>
					<?php else : ?>
						<div><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php echo esc_html( get_bloginfo( 'name', 'display' ) ); ?></a></div>
					<?php endif; ?>
				<?php } ?>	
			</header>
			<?php if ( class_exists( 'WooCommerce' ) ) : ?>
				<div class="header-right col-sm-9" >
					<div class="header-line-search col-sm-7"> 
						<div class="top-infobox text-left">
							<?php
							if ( get_theme_mod( 'infobox-text', '' ) != '' ) {
								echo wp_kses_post( get_theme_mod( 'infobox-text', '' ) );
							}
							?> 
						</div>              
						<div class="header-search-form">
							<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
								<input type="hidden" name="post_type" value="product" />
								<input class="product-header-search col-xs-8" name="s" type="text" placeholder="<?php esc_attr_e( 'Search...', 'giga-store' ); ?>"/>
								<select class="col-xs-4" name="product_cat">
									<option value=""><?php esc_html_e( 'All Categories', 'giga-store' ); ?></option> 
									<?php
									$categories = get_categories( 'taxonomy=product_cat' );
									foreach ( $categories as $category ) {
										$option = '<option value="' . esc_attr( $category->category_nicename ) . '">';
										$option .= esc_html( $category->cat_name );
										$option .= ' (' . absint( $category->category_count ) . ')';
										$option .= '</option>';
										echo $option;
									}
									?>
								</select>
								<button type="submit"><i class="fa fa-search"></i></button>
							</form>
						</div>
					</div>
					<?php
					if ( function_exists( 'giga_store_header_cart' ) ) {
						giga_store_header_cart();
					}
					?>
				</div>
			<?php endif; ?>
		</div> 
	</div>
	<div class="main-menu-section row">
		<div class="container">
			<div class="rsrc-main-menu col-md-12 no-gutter">
				<nav id="main-navigation" class="navbar" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement"> 
					<div class="navbar-header">
						<a href="#menu">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="off-canvas">
								<span class="sr-only"><?php esc_html_e( 'Toggle navigation', 'giga-store' ); ?></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</a> 	
						<div class="navbar-text mobile-title visible-xs">
							<?php
							if ( function_exists( 'has_custom_logo' ) && has_custom_logo() ) {
								the_custom_logo();
							} else {
								?>
								<?php if ( is_front_page() && is_home() ) : ?>
									<h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php echo esc_html( get_bloginfo( 'name', 'display' ) ); ?></a></h1>
								<?php else : ?>
									<div><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php echo esc_html( get_bloginfo( 'name', 'display' ) ); ?></a></div>
								<?php endif; ?>	
								<?php
							}
							?>	
						</div>
					</div>
					
					<?php
					wp_nav_menu( array(
						'theme_location'	 => 'main_menu',
						'depth'				 => 3,
						'container'			 => 'div',
						'container_class'	 => 'collapse navbar-collapse navbar-2-collapse',
						'menu_class'		 => 'nav navbar-nav',
						'fallback_cb'		 => 'wp_bootstrap_navwalker::fallback',
						'walker'			 => new wp_bootstrap_navwalker(),
						)
					);
					?>
				</nav>
			</div>
		</div>
	</div>
</div>
<div id="site-content" class="container-fluid rsrc-container" role="main">
