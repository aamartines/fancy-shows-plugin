<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Promenade
 * @since 1.0.0
 */
?>

<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>

	<div id="secondary" class="widget-area widget-area--main" role="complementary" itemscope itemtype="http://schema.org/WPSideBar">

		<?php do_action( 'promenade_sidebar_top' ); ?>

		<?php dynamic_sidebar( 'sidebar-1' ); ?>

		<?php do_action( 'promenade_sidebar_bottom' ); ?>

	</div>

<?php
endif;
