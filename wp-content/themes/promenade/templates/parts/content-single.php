<?php
/**
 * The template part for displaying content for individual posts.
 *
 * @package Promenade
 * @since 1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="http://schema.org/BlogPosting" itemprop="blogPost">
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title" itemprop="headline">', '</h1>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>

			<p class="entry-meta entry-meta--header">
				<?php promenade_posted_by(); ?>

				<span class="sep">|</span>

				<?php promenade_entry_date( true ); ?>
			</p>

		<?php endif; ?>
	</header>

	<div class="entry-content" itemprop="articleBody">
		<?php do_action( 'promenade_entry_content_top' ); ?>

		<?php the_content(); ?>

		<?php promenade_page_links(); ?>

		<?php do_action( 'promenade_entry_content_bottom' ); ?>
	</div>

	<footer class="entry-meta entry-meta--footer">
		<?php promenade_post_terms(); ?>

		<?php edit_post_link( __( 'Edit', 'promenade' ), '<span class="edit-link">', '</span>' ); ?>
	</footer>
</article>
