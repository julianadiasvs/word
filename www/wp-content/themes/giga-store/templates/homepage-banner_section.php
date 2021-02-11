<div class="section">
	<div class="container">
		<div class="container-heading text-center">
			<?php if ( get_theme_mod( 'banner_section_title', '' ) != '' ) : ?>
				<h4><?php echo esc_html( get_theme_mod( 'banner_section_title', '' ) ); ?></h4>
			<?php endif; ?>
			<?php if ( get_theme_mod( 'banner_section_desc', '' ) != '' ) : ?>
				<div class="sub-title"><span><?php echo esc_html( get_theme_mod( 'banner_section_desc', '' ) ); ?></span></div>
			<?php endif; ?>
		</div>
		<div class="row banner-section">
			<div class="col-md-8 banner-bg">
				<img src="<?php echo esc_url( get_theme_mod( 'banner-section-image', '' ) ); ?>" alt="" >
			</div>
			<div class="col-md-4 banner-inner">
				<div class="banner-text">
					<?php echo wp_kses_post( get_theme_mod( 'banner-section-text', '' ) ); ?>
				</div>
				<?php if ( get_theme_mod( 'banner-section-button-text', '' ) != '' && get_theme_mod( 'banner-section-button-url', '' ) != '' ) : ?>
					<div class="banner-button">
						<a class="custom-button" href="<?php echo esc_url( get_theme_mod( 'banner-section-button-url', '' ) ); ?>">
							<?php echo esc_html( get_theme_mod( 'banner-section-button-text', '' ) ); ?>
						</a>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
