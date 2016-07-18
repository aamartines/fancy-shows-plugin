<?php
/**
 * The template for displaying an individual record.
 *
 * @package Promenade
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="content-area single-record" role="main" itemprop="mainContentOfPage">

	<?php while ( have_posts() ) : the_post(); ?>

		<?php get_template_part( 'audiotheme/parts/record', str_replace( 'record-type-', '', get_audiotheme_record_type() ) ); ?>

	<?php endwhile; ?>

	<?php promenade_related_posts( null, array( 'posts_per_page' => 4 ) ); ?>

</main>

<?php
get_footer();
