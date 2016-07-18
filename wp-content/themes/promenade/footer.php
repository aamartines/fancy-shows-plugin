<?php
/**
 * The template for displaying the site footer.
 *
 * @package Promenade
 * @since 1.0.0
 */
?>

					<?php do_action( 'promenade_content_inside_bottom' ); ?>

				</div><!-- .page-fence -->
			</div><!-- .site-content-inside -->

			<?php do_action( 'promenade_content_bottom' ); ?>

		</div><!-- #content -->

		<?php do_action( 'promenade_content_after' ); ?>

		<footer id="footer" class="site-footer" role="contentinfo" itemscope itemtype="http://schema.org/WPFooter">
			<?php if ( is_active_sidebar( 'footer-widgets' ) ) : ?>

				<div class="footer-widgets">
					<div class="page-fence">
						<div class="widgets-area widget-area--footer block-grid block-grid-3">
							<?php do_action( 'promenade_footer_widgets_top' ); ?>

							<?php dynamic_sidebar( 'footer-widgets' ); ?>

							<?php do_action( 'promenade_footer_widgets_bottom' ); ?>
						</div>
					</div>
				</div>

			<?php endif; ?>

			<?php if ( has_nav_menu( 'social' ) ) : ?>

				<nav class="social-nav menu-social-container">
					<?php
					wp_nav_menu( array(
						'theme_location' => 'social',
						'container'      => false,
						'depth'          => 1,
						'menu_class'     => 'menu page-fence',
					) );
					?>
				</nav>

			<?php endif; ?>

			<div class="credits">
				<div class="page-fence">
					<?php promenade_credits(); ?>
				</div>
			</div>
		</footer>

		<?php do_action( 'promenade_after' ); ?>

	</div><!-- #page -->

	<?php wp_footer(); ?>

</body>
</html>
