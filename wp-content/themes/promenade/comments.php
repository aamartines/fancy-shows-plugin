<?php
/**
 * The template for displaying comments.
 *
 * The area of the page that contains both current comments and the comment
 * form.
 *
 * @package Promenade
 * @since 1.0.0
 */

// If the current post is protected by a password and the visitor has not yet
// entered the password, return early without loading the comments.
if ( post_password_required() ) {
	return;
}

// Don't show comments if commenting is closed and the current post doesn't
// have any comments associated with it.
if ( ! comments_open() && '0' === get_comments_number() ) {
	return;
}

$comments_by_type = $wp_query->comments_by_type;
?>

<section id="comments" class="comments-area clearfix">

	<?php if ( have_comments() ) : ?>

		<header class="comments-header">
			<h2 class="comments-title">
				<?php
				printf( _n( '%1$s Comment', '%1$s Comments', count( $comments_by_type['comment'] ), 'promenade' ),
					number_format_i18n( count( $comments_by_type['comment'] ) )
				);
				?>
			</h2>

			<?php if ( comments_open() ) : ?>

				<p>
					<a href="<?php the_permalink(); ?>#respond"><?php _e( 'Leave a Comment', 'promenade' ); ?></a>
				</p>

			<?php endif; ?>
		</header>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>

			<nav id="comment-nav-above" class="pagination paged-comments-nav" role="navigation">
				<h3 class="comment-navigation-title"><?php _e( 'Pages', 'promenade' ); ?></h3>

				<?php paginate_comments_links(); ?>
			</nav>

		<?php endif; ?>

		<ol class="comment-list<?php if ( '1' === get_option( 'show_avatars' ) ) { echo ' show-avatars'; } ?>">
			<?php
			wp_list_comments( array(
				'avatar_size' => 60,
			) );
			?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>

			<nav id="comment-nav-below" class="pagination paged-comments-nav" role="navigation">
				<h3 class="screen-reader-text"><?php _e( 'Comment navigation', 'promenade' ); ?></h3>
				<span class="prev"><?php previous_comments_link(); ?></span>
				<span class="next"><?php next_comments_link(); ?></span>
			</nav>

		<?php endif; ?>

	<?php endif; ?>

	<?php
	// If comments are closed and there are comments, leave a note.
	if ( ! comments_open() && '0' !== get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>

		<p class="comments-message comments-message--closed">
			<?php _e( 'Comments are closed.', 'promenade' ); ?>
		</p>

	<?php endif; ?>

	<?php comment_form(); ?>

</section>
