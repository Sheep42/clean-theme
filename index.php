<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 */

get_header(); ?>

<div class="wrap">

	<?php if ( have_posts() ) : ?>
		<header class="page-header">
			<h1 class="page-title"><?php esc_html_e( get_option( 'page_for_posts', true ) ); ?></h1>
		</header>
	<?php endif; ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) : ?>
			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/' . get_post_type() . '/content', 'archive' );

			endwhile;

			// the_posts_pagination( array(
			// 	'prev_text' => '&laquo; <span class="screen-reader-text">' . __( 'Previous page', 'cleantheme' ) . '</span>',
			// 	'next_text' => '<span class="screen-reader-text">' . __( 'Next page', 'cleantheme' ) . '</span> &raquo;',
			// 	'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'cleantheme' ) . ' </span>',
			// ) );

		else :

			get_template_part( 'template-parts/' . get_post_type() . '/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->
	
	<?php get_sidebar(); ?>
</div><!-- .wrap -->

<?php get_footer();
