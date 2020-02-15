<?php

get_header(); ?>

<div class="wrap">

	<?php if ( have_posts() ) : ?>
		<header class="page-header">
			<h1 class="page-title"><?php esc_html_e( get_the_archive_title() ); ?></h1>
		</header><!-- .page-header -->
	<?php endif; ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) : ?>
			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/' . get_post_type() . '/content', 'archive' );

			endwhile;

			// the_posts_pagination( array(
			// 	'prev_text' => cleantheme_get_svg( array( 'icon' => 'arrow-left' ) ) . '<span class="screen-reader-text">' . __( 'Previous page', 'cleantheme' ) . '</span>',
			// 	'next_text' => '<span class="screen-reader-text">' . __( 'Next page', 'cleantheme' ) . '</span>' . cleantheme_get_svg( array( 'icon' => 'arrow-right' ) ),
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
