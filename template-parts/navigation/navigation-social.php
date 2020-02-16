<?php if ( has_nav_menu( 'social' ) ) : ?>
	
	<nav class="social-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Footer Social Links Menu', 'cleantheme' ); ?>">
		<?php
			wp_nav_menu( array(
				'theme_location' => 'social',
				'menu_class'     => 'social-links-menu',
				'depth'          => 1,
				'link_before'    => '<span class="screen-reader-text">',
				'link_after'     => '</span>' . cleantheme_get_svg( array( 'icon' => 'chain' ) ),
			) );
		?>
	</nav><!-- .social-navigation -->

<?php endif;