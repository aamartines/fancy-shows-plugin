<?php
/**
 * The template used for displaying content in page.php.
 *
 * @package Promenade
 * @since 1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="http://schema.org/CreativeWork">
	<header class="entry-header">
		<div class="page-fence">
			<?php the_title( '<h1 class="entry-title" itemprop="headline">', '</h1>' ); ?>
		</div>
	</header>

	<div class="entry-content" itemprop="text">
		<?php do_action( 'promenade_entry_content_top' ); ?>

		<?php the_content(); ?>

		<?php promenade_page_links(); ?>

		<?php do_action( 'promenade_entry_content_bottom' ); ?>
	</div>

	<?php edit_post_link( __( 'Edit', 'promenade' ), '<footer class="entry-meta entry-meta--footer"><span class="edit-link">', '</span></footer>' ); ?>
</article>
