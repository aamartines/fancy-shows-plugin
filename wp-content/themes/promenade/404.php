<?php
/**
 * The template for displaying 404 (Not Found) pages.
 *
 * @package Promenade
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="content-area" role="main" itemprop="mainContentOfPage">
	<section class="error-404 not-found">
		<header class="page-header">
			<p><?php _e( 'Nothing was found at this location. Maybe try searching below?', 'promenade' ); ?></p>
		</header>

		<div class="page-content">
			<?php get_search_form(); ?>
		</div>
	</section>
</main>

<?php
get_footer();
