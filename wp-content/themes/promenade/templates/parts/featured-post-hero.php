<?php
/**
 * The template for displaying the featured hero post.
 *
 * @package Promenade
 * @since 1.0.0
 */
?>

<article <?php post_class( 'featured-content-hero' ); ?>>
	<?php
	if ( $thumbnail_id = get_post_thumbnail_id() ) :
		printf( '<div class="entry-thumbnail"><a href="%s" style="background-image:url(%s);"></a></div>',
			esc_url( get_permalink() ),
			esc_url( wp_get_attachment_url( $thumbnail_id ) )
		);
	endif;
	?>

	<div class="entry-content">
		<h1 class="entry-title" itemprop="headline">
			<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark" itemprop="url">
				<?php echo apply_filters( 'promenade_featured_content_title', get_the_title() ); ?>
			</a>
		</h1>

		<div class="entry-summary">
			<?php echo apply_filters( 'promenade_featured_content_summary', get_the_excerpt() ); ?>
		</div>
	</div>
</article>
