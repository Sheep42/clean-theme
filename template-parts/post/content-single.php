<?php
/**
 * Template part for displaying posts
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php esc_html_e( get_the_title() ); ?></h1>
		
		<div class="entry-meta">
			<?php esc_html_e( get_the_date() ); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<?php if ( '' !== get_the_post_thumbnail() && ! is_single() ) : ?>
		<div class="post-thumbnail">
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'cleantheme-featured-image' ); ?>
			</a>
		</div><!-- .post-thumbnail -->
	<?php endif; ?>

	<div class="entry-content">
		<?php
			the_content();

			// wp_link_pages( array(
			// 	'before'      => '<div class="page-links">' . __( 'Pages:', 'cleantheme' ),
			// 	'after'       => '</div>',
			// 	'link_before' => '<span class="page-number">',
			// 	'link_after'  => '</span>',
			// ) );
		
			comments_template();
		?>
	</div><!-- .entry-content -->

</article><!-- #post-## -->
