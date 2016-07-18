<?php
/**
 * Template Name: No Sidebar
 *
 * A page template for placing the focus on the content.
 *
 * @package Promenade
 * @since 1.6.0
 */

get_header();
?>

<main id="primary" class="content-area" role="main" itemprop="mainContentOfPage">

	<?php while ( have_posts() ) : the_post(); ?>

		<?php get_template_part( 'templates/parts/content', 'page' ); ?>

		<?php comments_template( '', true ); ?>

	<?php endwhile; ?>

</main>

<?php
get_footer();
