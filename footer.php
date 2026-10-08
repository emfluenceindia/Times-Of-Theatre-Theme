<?php
/**
 * The footer template.
 *
 * Footer widget columns, optional footer menu, copyright and wp_footer().
 *
 * @package timesoftheatre
 */

$timesoftheatre_columns = array();

for ( $timesoftheatre_i = 1; $timesoftheatre_i <= 4; $timesoftheatre_i++ ) {
	if ( is_active_sidebar( 'footer-' . $timesoftheatre_i ) ) {
		$timesoftheatre_columns[] = 'footer-' . $timesoftheatre_i;
	}
}
?>

<footer id="colophon" class="site-footer">
	<div class="tot-wrap">

		<?php if ( $timesoftheatre_columns ) : ?>
			<div class="footer-content">
				<?php foreach ( $timesoftheatre_columns as $timesoftheatre_sidebar ) : ?>
					<div class="footer-section">
						<?php dynamic_sidebar( $timesoftheatre_sidebar ); ?>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<div class="footer-bottom">
			<?php if ( has_nav_menu( 'footer' ) ) : ?>
				<nav class="footer-navigation" aria-label="<?php esc_attr_e( 'Footer menu', 'timesoftheatre' ); ?>">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'footer',
							'container'      => false,
							'menu_class'     => 'footer-menu',
							'depth'          => 1,
							'fallback_cb'    => false,
						)
					);
					?>
				</nav>
			<?php endif; ?>

			<p>
				<?php
				printf(
					/* translators: 1: copyright year, 2: site name. */
					esc_html__( '&copy; %1$s %2$s. All rights reserved.', 'timesoftheatre' ),
					esc_html( gmdate( 'Y' ) ),
					esc_html( get_bloginfo( 'name' ) )
				);
				?>
			</p>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
