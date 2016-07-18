<?php
/**
 * The sidebar containing the home widget area.
 *
 * @package Promenade
 * @since 1.5.0
 */
?>

<div class="widget-area widget-area--home block-grid block-grid-3">

	<?php do_action( 'promenade_home_widgets_top' ); ?>

	<?php dynamic_sidebar( 'home-widgets' ); ?>

	<?php do_action( 'promenade_home_widgets_bottom' ); ?>

</div>
