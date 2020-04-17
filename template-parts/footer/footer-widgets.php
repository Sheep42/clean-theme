<?php
/**
 * Displays footer widgets if assigned
 */

?>

<?php if ( is_active_sidebar( 'footer-widgets' ) ) : ?>

	<aside class="widget-area" role="complementary" aria-label="<?php esc_attr_e( 'Footer', 'cleantheme' ); ?>">
		
	</aside><!-- .widget-area -->

<?php endif; ?>
