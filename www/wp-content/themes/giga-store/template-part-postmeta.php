<div class="post-meta text-left">
	<span><?php esc_html_e( 'By', 'giga-store' ); ?></span><span class="author-link"><?php the_author_posts_link(); ?></span><?php echo '// '; ?>
	<span class="comments-meta"><?php comments_popup_link( __( '0 Comments', 'giga-store' ), __( '1 Comment', 'giga-store' ), __( '% Comments', 'giga-store' ), 'comments-link', __( 'Comments are Off', 'giga-store' ) ); ?></span><?php echo '&#47;&#47; '; ?>
	<?php the_category( ', ' ); ?>
	<?php edit_post_link( __( 'Edit', 'giga-store' ), '<span class="fa fa-pencil-square"></span>', '' ); ?>
</div>
