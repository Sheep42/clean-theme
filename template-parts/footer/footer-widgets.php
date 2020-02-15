<?php
/**
 * Displays footer widgets if assigned
 *
 * @subpackage cleantheme
 * @since 1.0
 * @version 1.0
 */

?>

<?php if ( is_active_sidebar( 'footer-widgets' ) ) : ?>

	<aside class="widget-area" role="complementary" aria-label="<?php esc_attr_e( 'Footer', 'cleantheme' ); ?>">
		
	</aside><!-- .widget-area -->

<?php endif; ?>
