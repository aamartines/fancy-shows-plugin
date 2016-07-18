<?php
/**
 * The template for displaying individual posts.
 *
 * @package Promenade
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="content-area" role="main">

	<?php while ( have_posts() ) : the_post(); ?>

		<?php get_template_part( 'templates/parts/content-single', get_post_format() ); ?>

		<?php comments_template( '', true ); ?>

	<?php endwhile; ?>

</main>

<?php get_sidebar(); ?>

<?php
get_footer();
