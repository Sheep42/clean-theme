<?php
/**
 * Displays content for front page
 *
 * @package WordPress
 * @subpackage cleantheme
 * @since 1.0
 * @version 1.0
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >

	<div class="panel-content">
		<div class="wrap">
			<header class="entry-header">
				<h1><?php esc_html_e( get_the_title() ); ?></h1>
			</header><!-- .entry-header -->

			<div class="entry-content">
				<?php the_content(); ?>
			</div><!-- .entry-content -->

		</div><!-- .wrap -->
	</div><!-- .panel-content -->

</article><!-- #post-## -->
