<?php
/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments">

	<?php $comments_number = absint( get_comments_number() ); ?>
	<div class="comments-header">

		<h2 class="comment-reply-title">
			<?php
				if ( ! have_comments() ) {
					_e( 'Leave a comment', 'cleantheme' );
				} elseif ( '1' === $comments_number ) {
					/* translators: %s: post title */
					printf( _x( 'One reply on &ldquo;%s&rdquo;', 'comments title', 'cleantheme' ), esc_html( get_the_title() ) );
				} else {
					echo sprintf(
						/* translators: 1: number of comments, 2: post title */
						_nx(
							'%1$s reply on &ldquo;%2$s&rdquo;',
							'%1$s replies on &ldquo;%2$s&rdquo;',
							$comments_number,
							'comments title',
							'cleantheme'
						),
						number_format_i18n( $comments_number ),
						esc_html( get_the_title() )
					);
				}
			?>
		</h2><!-- .comments-title -->

	</div><!-- .comments-header -->

	<div class="comments-inner">

		<?php
			wp_list_comments();

			$comment_pagination = paginate_comments_links(
				array(
					'echo'      => false,
					'end_size'  => 0,
					'mid_size'  => 0,
					'next_text' => __( 'Newer Comments', 'cleantheme' ) . ' <span aria-hidden="true">&rarr;</span>',
					'prev_text' => '<span aria-hidden="true">&larr;</span> ' . __( 'Older Comments', 'cleantheme' ),
				)
			);

			if ( $comment_pagination ) {
				$pagination_classes = '';

				// If we're only showing the "Next" link, add a class indicating so.
				if ( false === strpos( $comment_pagination, 'prev page-numbers' ) ) {
					$pagination_classes = ' only-next';
				}
				?>

				<nav class="comments-pagination pagination<?php echo $pagination_classes; ?>">
					<?php echo wp_kses_post( $comment_pagination ); ?>
				</nav>

				<?php
			}
		?>

	</div><!-- .comments-inner -->	

</div><!-- #comments -->

<?php 
	if ( comments_open() || pings_open() ) {

		if ( $comments ) {
			echo '<hr class="separator" />';
		}

		comment_form(
			array(
				'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
				'title_reply_after'  => '</h2>',
			)
		);

	} elseif ( is_single() ) {

		if ( $comments ) {
			echo '<hr class="separator" />';
		}

		?>

		<div class="comment-respond" id="respond">

			<p class="comments-closed"><?php _e( 'Comments are closed.', 'cleantheme' ); ?></p>

		</div><!-- #respond -->

		<?php
	}