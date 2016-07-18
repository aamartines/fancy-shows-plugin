<?php
/**
 * The default template part for displaying content.
 *
 * @package Promenade
 * @since 1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="http://schema.org/BlogPosting" itemprop="blogPost">
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title" itemprop="headline"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" itemprop="url">', '</a></h1>' ); ?>

		<?php if ( is_search() ) : ?>

			<p class="entry-meta entry-meta--header">
				<span class="post-type">
					<?php echo esc_html( get_post_type_object( get_post_type() )->labels->singular_name ); ?>
				</span>
			</p>

		<?php elseif ( 'post' === get_post_type() ) : ?>

			<p class="entry-meta entry-meta--header">
				<?php promenade_posted_by(); ?>

				<span class="sep">|</span>

				<?php promenade_entry_date(); ?>
			</p>

		<?php endif; ?>
	</header>

	<?php if ( is_search() ) : ?>

		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div>

	<?php else : ?>

		<div class="entry-content" itemprop="articleBody">
			<?php do_action( 'promenade_entry_content_top' ); ?>

			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'promenade' ) ); ?>

			<?php promenade_page_links(); ?>

			<?php do_action( 'promenade_entry_content_bottom' ); ?>
		</div>

	<?php endif; ?>

	<?php if ( ! is_search() ) : ?>

		<footer class="entry-meta entry-meta--footer">
			<?php if ( 'post' === get_post_type() ) : ?>

				<?php promenade_post_terms(); ?>

			<?php endif; ?>

			<?php if ( ! post_password_required() && ( comments_open() || '0' !== get_comments_number() ) ) : ?>

				<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'promenade' ), __( '1 Comment', 'promenade' ), __( '% Comments', 'promenade' ) ); ?></span>

			<?php endif; ?>

			<?php edit_post_link( __( 'Edit', 'promenade' ), '<span class="edit-link">', '</span>' ); ?>
		</footer>

	<?php endif; ?>
</article>
