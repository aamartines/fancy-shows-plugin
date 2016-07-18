<?php
/**
 * The front page template file.
 *
 * @package Promenade
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="content-area" role="main" itemprop="mainContentOfPage">

	<?php while ( have_posts() ) : the_post(); ?>

		<?php if ( promenade_has_content() ) : ?>

			<?php get_template_part( 'templates/parts/content', 'page' ); ?>

		<?php endif; ?>

	<?php endwhile; ?>

</main>

<?php
get_footer();
