<?php
/**
 * The template for displaying video archives.
 *
 * @package Promenade
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" <?php audiotheme_archive_class( array( 'content-area', 'archive-video' ) ); ?> role="main" itemprop="mainContentOfPage">

	<?php if ( have_posts() ) : ?>

		<?php if ( 1 === promenade_get_paged_query_var() ) : ?>

			<?php the_audiotheme_archive_description( '<div class="archive-intro" itemprop="text">', '</div>' ); ?>

		<?php endif; ?>

		<?php
		promenade_block_grid( array(
			'classes' => array( 'block-grid-thumbnails', 'block-grid-thumbnails--landscape' ),
			'columns' => get_audiotheme_archive_meta( 'columns', true, 3 ),
		) );
		?>

		<?php promenade_paginate_links(); ?>

	<?php else : ?>

		<?php get_template_part( 'audiotheme/parts/no-results', 'video' ); ?>

	<?php endif; ?>

</main>

<?php
get_footer();
