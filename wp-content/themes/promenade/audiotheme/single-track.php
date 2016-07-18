<?php
/**
 * The template for displaying an individual track.
 *
 * @package Promenade
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="content-area single-record single-track" role="main" itemprop="mainContentOfPage">

	<?php while ( have_posts() ) : the_post(); ?>

		<?php get_template_part( 'audiotheme/parts/record', 'track' ); ?>

	<?php endwhile; ?>

	<?php promenade_related_posts( get_post()->post_parent, array( 'posts_per_page' => 4 ) ); ?>

</main>

<?php
get_footer();
