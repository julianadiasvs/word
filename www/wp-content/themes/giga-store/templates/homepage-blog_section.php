<div class="section">  
	<div class="container">
		<div class="container-heading text-center">
			<?php if ( get_theme_mod( 'blog_section_title', 'News' ) != '' ) : ?>
				<h4><?php echo esc_html( get_theme_mod( 'blog_section_title', __( 'News', 'giga-store' ) ) ); ?></h4>
				<?php endif; ?>
				<?php if ( get_theme_mod( 'blog_section_desc', 'From Our Blog' ) != '' ) : ?>
					<div class="sub-title"><span><?php echo esc_html( get_theme_mod( 'blog_section_desc', __( 'From Our Blog', 'giga-store' ) ) ); ?></span></div>
				<?php endif; ?>
		</div>
		<div class="blog-home">
			<?php
			$query_args	 = array(
				'post_type'		 => 'post',
				'posts_per_page' => 3,
				'post_status'	 => 'publish',
			);
			$the_query	 = new WP_Query( $query_args );
			if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
					get_template_part( 'content', '' );
				endwhile;
				wp_reset_postdata();
			else :
				?>
				<p><?php esc_html_e( 'Sorry, no posts matched your criteria.', 'giga-store' ); ?></p>
			<?php endif; ?>
		</div>
	</div>
</div>
