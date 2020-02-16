<?php
/**
 * Template part for displaying page content in page.php
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title">
			<?php esc_html_e( get_the_title() ); ?>
		</h1>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
			the_content();

			// wp_link_pages( array(
			// 	'before' => '<div class="page-links">' . __( 'Pages:', 'cleantheme' ),
			// 	'after'  => '</div>',
			// ) );
		?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
