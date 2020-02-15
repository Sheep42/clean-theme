<?php
/**
 * The template for displaying all single posts
 */

get_header(); ?>

<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/' . get_post_type() . '/content', 'single' );

				// the_post_navigation( array(
				// 	'prev_text' => '<span class="screen-reader-text">' . __( 'Previous Post', 'cleantheme' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Previous', 'cleantheme' ) . '</span>%title</span>',
				// 	'next_text' => '<span class="screen-reader-text">' . __( 'Next Post', 'cleantheme' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Next', 'cleantheme' ) . '</span> <span class="nav-title">%title</span>',
				// ) );

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->
	
	<?php get_sidebar(); ?>
</div><!-- .wrap -->

<?php get_footer();
