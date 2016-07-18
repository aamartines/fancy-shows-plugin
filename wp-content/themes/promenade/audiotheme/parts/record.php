<?php
/**
 * The template used for displaying individual records.
 *
 * @package Promenade
 * @since 1.0.0
 */

$type = str_replace( 'audiotheme_', '', get_post_type() );
$schema = ( 'record' === $type ) ? 'itemscope itemtype="http://schema.org/MusicAlbum"' : 'itemscope itemtype="http://schema.org/MusicRecording"';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'record' ); ?> <?php echo $schema; ?>>
	<div class="primary-area">
		<header class="entry-header">
			<?php the_title( '<h1 class="entry-title" itemprop="name">', '</h1>' ); ?>

			<meta content="<?php the_permalink(); ?>" itemprop="url" />

			<?php get_template_part( 'audiotheme/parts/record-details', $type ); ?>
		</header>

		<?php get_template_part( 'audiotheme/parts/record-tracklist', $type ); ?>

		<div class="entry-content">
			<?php do_action( 'promenade_entry_content_top' ); ?>

			<?php the_content( '' ); ?>

			<?php do_action( 'promenade_entry_content_bottom' ); ?>
		</div>
	</div>

	<div class="secondary-area">
		<?php get_template_part( 'audiotheme/parts/record-meta', $type ); ?>
	</div>
</article>
