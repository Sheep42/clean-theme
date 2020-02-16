<?php 

?>
		</div><!-- #content -->

		<footer id="colophon" class="site-footer" role="contentinfo">
			<div class="wrap">
				<?php
					get_template_part( 'template-parts/footer/footer', 'widgets' );

					get_template_part( 'template-parts/navigation/navigation', 'social' );

					get_template_part( 'template-parts/footer/site', 'info' );
				?>
			</div><!-- .wrap -->
		</footer><!-- #colophon -->
	</div><!-- .site-content-contain -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
