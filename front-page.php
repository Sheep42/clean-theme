<?php
/**
 * The front page template file
 *
 * If the user has selected a static page for their homepage, this is what will
 * appear.
 */

get_header(); ?>

<div id="primary" class="content-area">

	<main id="main" class="site-main" role="main">
		
		<?php 
		if ( have_posts() ):
			while ( have_posts() ) : the_post();
				get_template_part( 'template-parts/page/content', 'front-page' );
			endwhile;
		else:
			get_template_part( 'template-parts/post/content', 'none' );
		endif; ?>
		
	</main><!-- #main -->
</div><!-- #primary -->

<?php get_footer();
