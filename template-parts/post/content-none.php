<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage cleantheme
 * @since 1.0
 * @version 1.0
 */

?>

<section class="no-results not-found">
	<header class="page-header">
		<h1 class="page-title">Nothing Found</h1>
	</header>

	<div class="page-content">
		<p>It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.</p>
		<?php get_search_form(); ?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
