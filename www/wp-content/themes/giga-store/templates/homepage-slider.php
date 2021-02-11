<?php
$repeater_value = get_theme_mod( 'repeater_slider', '' );
if ( ! $repeater_value ) { // Display random images from media gallery.
	$args	 = array( 'numberposts' => 2, 'post_type' => 'attachment', 'fields' => 'ids', 'post_mime_type' => 'image', 'orderby' => 'rand', 'post_status' => 'inherit' );
	$image	 = new WP_Query( $args );
	$count = $image->post_count;
	if ( $image->have_posts() && $count >= '2' ) {
		if ( current_user_can( 'edit_theme_options' ) ) {
			$repeater_desc = __( 'Slider is not set. Slider is now showing random images from your media gallery. Go to customizer and set your own sides.', 'giga-store' );
		} else {
			$repeater_desc = '';
		}
		$repeater_value = array(
			array(
				'slider_image'		 => wp_get_attachment_url( $image->posts[0] ),
				'slider_position'	 => 'slider-right',
				'slider_desc'		 => $repeater_desc,
			),
			array(
				'slider_image'		 => wp_get_attachment_url( $image->posts[1] ),
				'slider_position'	 => 'slider-center',
				'slider_desc'		 => $repeater_desc,
			),
		);
	} else {
		$repeater_value = '';
	}
	wp_reset_postdata();
}
?>
<?php if ( $repeater_value ) : ?>
	<section id="slider" class="content">
		<div class="flexslider-container">
			<div class="homepage-slider flexslider">
				<ul class="slides">
					<?php foreach ( $repeater_value as $row ) : ?>
						<?php if ( isset( $row['slider_image'] ) && ! empty( $row['slider_image'] ) ) : ?>
							<?php
							$image_url	 = $row['slider_image'];
							$image_id	 = wp_get_attachment_url( $image_url );
							if ( $image_id == '' ) {
								$image_id = $row['slider_image'];
							};
							?>
							<li style="background-image: url(<?php echo esc_url( $image_id ); ?>);" >
								<div class="flexslider-inner-container">
									<div class="flexslider-inner text-center <?php echo esc_attr( $row['slider_position'] ); ?>">
										<?php if ( isset( $row['slider_heading'] ) && ! empty( $row['slider_heading'] ) ) : ?>
											<div class="flexslider-heading">
												<?php echo esc_html( $row['slider_heading'] ); ?>
											</div>
										<?php endif; ?>
										<?php if ( isset( $row['slider_title'] ) && ! empty( $row['slider_title'] ) ) : ?>
											<h2 class="flexslider-title">
												<?php echo esc_html( $row['slider_title'] ); ?>
											</h2>
										<?php endif; ?>
										<?php if ( isset( $row['slider_desc'] ) && ! empty( $row['slider_desc'] ) ) : ?>
											<p class="flexslider-desc hidden-xs">
												<?php echo esc_html( $row['slider_desc'] ); ?>
											</p>
										<?php endif; ?>
										<?php if ( isset( $row['slider_url'] ) && ! empty( $row['slider_url'] ) ) : ?>
											<a class="flexslider-button" href="<?php echo esc_url( $row['slider_url'] ); ?>">
												<?php esc_html_e( 'Read More', 'giga-store' ); ?>  
											</a>
										<?php endif; ?>
									</div>
								</div>	
							</li>
						<?php endif; ?> 
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</section>
	<?php
endif;
