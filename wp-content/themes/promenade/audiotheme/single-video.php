<?php
/**
 * The template for displaying a single video.
 *
 * @package Promenade
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="content-area single-video" role="main" itemprop="mainContentOfPage">

	<?php while ( have_posts() ) : the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class( 'video' ); ?> itemprop="video" itemscope itemtype="http://schema.org/VideoObject">
			<?php if ( $thumbnail = get_post_thumbnail_id() ) : ?>
				<meta itemprop="thumbnailUrl" content="<?php echo esc_url( wp_get_attachment_url( $thumbnail, 'full' ) ); ?>">
			<?php endif; ?>

			<?php if ( $video_url = get_audiotheme_video_url() ) : ?>
				<meta itemprop="embedUrl" content="<?php echo esc_url( $video_url ); ?>">
				<figure class="entry-video content-stretch-wide">
					<?php the_audiotheme_video(); ?>
				</figure>
			<?php endif; ?>

			<header class="entry-header">
				<?php the_title( '<h1 class="entry-title" itemprop="name">', '</h1>' ); ?>
			</header>

			<div class="entry-content" itemprop="description">
				<?php do_action( 'promenade_entry_content_top' ); ?>

				<?php the_content( '' ); ?>

				<?php promenade_page_links(); ?>

				<?php do_action( 'promenade_entry_content_bottom' ); ?>
			</div>

			<?php comments_template( '', true ); ?>
		</article>

	<?php endwhile; ?>

	<?php promenade_related_posts(); ?>

</main>

<?php
get_footer();
