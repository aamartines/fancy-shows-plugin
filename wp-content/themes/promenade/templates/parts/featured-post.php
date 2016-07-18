<?php
/**
 * The template for displaying featured posts.
 *
 * @package Promenade
 * @since 1.0.0
 */
?>

<li <?php post_class( 'block-grid-item' ); ?>>
	<a class="block-grid-item-inside" href="<?php the_permalink(); ?>">
		<span class="block-grid-item-date">
			<?php echo apply_filters( 'promenade_featured_content_date', promenade_entry_date( false, false ) ); ?>
		</span>

		<h1 class="block-grid-item-title">
			<?php echo apply_filters( 'promenade_featured_content_title', get_the_title() ); ?>
		</h1>
	</a>
</li>
