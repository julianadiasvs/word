<!-- start content container -->
<div class="row container rsrc-content">
	<?php get_sidebar( 'left' ); ?>
	<article class="col-md-<?php giga_store_main_content_width_columns(); ?> rsrc-main">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="single-thumbnail"><?php the_post_thumbnail( 'giga-store-single' ); ?></div>
					<div class="clear">
					</div>
				<?php endif; ?>
				<div <?php post_class( 'rsrc-post-content' ); ?>>
					<header>
						<h1 class="entry-title page-header">
							<?php the_title(); ?>
						</h1>
					</header>
					<div class="entry-content">
						<?php the_content(); ?>
					</div>
					<?php wp_link_pages(); ?>
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
