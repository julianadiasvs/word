<div class="section">  
	<div class="container">
		<div class="container-heading text-center">
			<?php if ( get_theme_mod( 'testimonial_section_title', 'Testimonials' ) != '' ) : ?>
				<div class="section-title">
					<h4><?php echo esc_html( get_theme_mod( 'testimonial_section_title', 'Testimonials' ) ); ?></h4>
				</div>
			<?php endif; ?>
			<?php if ( get_theme_mod( 'testimonial_section_desc', '' ) != '' ) : ?>
				<div class="sub-title"><span><?php echo esc_html( get_theme_mod( 'testimonial_section_desc', '' ) ); ?></span></div>
			<?php endif; ?>
		</div>
		<?php
		$repeater_value = get_theme_mod( 'repeater_testimonial', '' );
		if ( $repeater_value ) : ?>
			<div class="row">
				<div class="col-md-12" data-wow-delay="0.2s">                        
					<div class="carousel slide" data-ride="carousel" id="quote-carousel">                            
						<!-- Bottom Carousel Indicators -->                            
						<ol class="carousel-indicators">                                
							<?php
							$i = 0;
							foreach ( $repeater_value as $row ) :
								?>                                                                    
								<li data-target="#quote-carousel" data-slide-to="<?php echo absint( $i ); ?>" class="<?php if ( $i == 0 ) { echo 'active '; } ?>">                                     
									<?php if ( isset( $row['testimonial_image'] ) && ! empty( $row['testimonial_image'] ) ) :
										$image_id	 = $row['testimonial_image'];
										$image_thumb = wp_get_attachment_image( $image_id, 'thumbnail' );

										if ( $image_thumb ) {
											echo $image_thumb;
										}
									endif; 
									?>                                   
								</li>                                  
								<?php $i++; ?>                                
							<?php endforeach; ?>                            
						</ol>                            
						<!-- Carousel Slides / Quotes -->                            
						<div class="carousel-inner text-center">                                
							<?php
							$j = 0;
							foreach ( $repeater_value as $row ) :
								?>                                  
								<div class="item <?php if ( $j == 0 ) { echo 'active '; } ?>">                                    
									<blockquote>                                        
										<div class="row">                                            
											<div class="col-sm-8 col-sm-offset-2">                                                
												<?php if ( isset( $row['testimonial_desc'] ) && ! empty( $row['testimonial_desc'] ) ) : ?>                                                  
													<p>
														<?php echo esc_html( $row['testimonial_desc'] ); ?>
													</p>                                                
												<?php endif; ?>                                                
												<small>                                                  
													<?php if ( isset( $row['testimonial_name'] ) && ! empty( $row['testimonial_name'] ) ) : ?>                                                    
														<?php echo esc_html( $row['testimonial_name'] ); ?>                                                  
													<?php endif; ?>                                                  
													<?php if ( isset( $row['testimonial_url'] ) && ! empty( $row['testimonial_url'] ) ) : ?>                                                    
														<?php echo ' &#124; '; ?>
														<a href="<?php echo esc_url( $row['testimonial_url'] ); ?>">
															<?php echo esc_html( $row['testimonial_url'] ); ?>
														</a>                                                  
													<?php endif; ?>                                                
												</small>                                            
											</div>                                        
										</div>                                    
									</blockquote>                                  
								</div>                                  
								<?php $j++; ?>                                
							<?php endforeach; ?>                            
						</div>                            
						<!-- Carousel Buttons Next/Prev -->                            
						<a data-slide="prev" href="#quote-carousel" class="left carousel-control">
							<i class="fa fa-chevron-left"></i>
						</a>                            
						<a data-slide="next" href="#quote-carousel" class="right carousel-control">
							<i class="fa fa-chevron-right"></i>
						</a>                        
					</div>                    
				</div>                
			</div>
		<?php endif; ?>
	</div>
</div>
