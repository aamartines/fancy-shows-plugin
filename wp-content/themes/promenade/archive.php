<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Promenade
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="content-area" role="main">

	<?php if ( have_posts() ) : ?>

		<?php if ( $term_description = term_description() ) : ?>

			<?php printf( '<div class="archive-intro taxonomy-description" itemprop="text">%s</div>', $term_description ); ?>

		<?php endif; ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'templates/parts/content', get_post_format() ); ?>

		<?php endwhile; ?>

		<?php promenade_paginate_links(); ?>

	<?php else : ?>

		<?php get_template_part( 'templates/parts/no-results', 'archive' ); ?>

	<?php endif; ?>

</main>

<?php get_sidebar(); ?>

<?php
get_footer();
