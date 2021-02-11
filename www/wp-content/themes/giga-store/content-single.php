<?php if ( has_post_thumbnail() ) : ?>                                
	<div class="single-thumbnail"><?php echo get_the_post_thumbnail( $post->ID, 'giga-store-single' ); ?></div>                                     
	<div class="clear"></div>                            
<?php endif; ?>     
<!-- start content container -->
<div class="row container rsrc-content">     
	<?php get_sidebar( 'left' ); ?>    
	<article class="col-md-<?php giga_store_main_content_width_columns(); ?> rsrc-main">        
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>                                       
				<div <?php post_class( 'rsrc-post-content' ); ?>>                            
					<header>
						<time class="single-meta-date published" datetime="<?php the_time( 'Y-m-d' ); ?>">
							<div class="day"><?php the_time( 'd', $post->ID ); ?></div>
							<div class="month"><?php the_time( 'M', $post->ID ); ?></div>
						</time>
						<h1 class="entry-title page-header">
							<?php the_title(); ?>
						</h1>                              
						<?php get_template_part( 'template-part', 'postmeta' ); ?>                            
					</header>                                                                                      
					<div class="entry-content">
						<?php the_content(); ?>
					</div>   
					<div id="custom-box"></div>                         
					<?php wp_link_pages(); ?>                                                        
					<?php get_template_part( 'template-part', 'posttags' ); ?>
					<?php if ( get_theme_mod( 'post-nav-check', 1 ) == 1 ) : ?>                            
						<div class="post-navigation row">
							<div class="post-previous col-md-6"><?php previous_post_link( '%link', '<span class="meta-nav">' . __( 'Previous:', 'giga-store' ) . '</span> %title' ); ?></div>
							<div class="post-next col-md-6"><?php next_post_link( '%link', '<span class="meta-nav">' . __( 'Next:', 'giga-store' ) . '</span> %title' ); ?></div>
						</div>
					<?php endif; ?>
					<?php if ( get_theme_mod( 'related-posts-check', 1 ) == 1 ) : ?>
						<?php get_template_part( 'template-part', 'related' ); ?>
					<?php endif; ?>
					<?php if ( get_theme_mod( 'author-check', 1 ) == 1 ) : ?>
						<?php get_template_part( 'template-part', 'postauthor' ); ?>
					<?php endif; ?>
					<?php comments_template(); ?>
				</div>
			<?php endwhile; ?>
		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>
	</article>
	<?php get_sidebar( 'right' ); ?>
</div>
<!-- end content container -->
