<?php
/**
 * The template for displaying gig archives.
 *
 * @package Promenade
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" <?php audiotheme_archive_class( array( 'content-area', 'archive-gig' ) ); ?> role="main" itemprop="mainContentOfPage">

	<?php if ( have_posts() ) : ?>

		<?php if ( 1 === promenade_get_paged_query_var() ) : ?>

			<?php the_audiotheme_archive_description( '<div class="archive-intro" itemprop="text">', '</div>' ); ?>

		<?php endif; ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'audiotheme/parts/gig-card' ); ?>

		<?php endwhile; ?>

		<?php promenade_paginate_links(); ?>

	<?php else : ?>

		<?php get_template_part( 'audiotheme/parts/no-results', 'gig' ); ?>

	<?php endif; ?>

</main>

<?php
get_footer();
