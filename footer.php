<?php
/**
 * The footer template.
 *
 * Footer navigation columns (one per primary-menu group), optional footer
 * menu, copyright and wp_footer().
 *
 * @package timesoftheatre
 */

$timesoftheatre_groups = timesoftheatre_menu_groups( 'primary' );
?>

<footer id="colophon" class="site-footer">
	<div class="tot-wrap">

		<?php if ( $timesoftheatre_groups ) : ?>
			<nav class="footer-content" aria-label="<?php esc_attr_e( 'Site map', 'timesoftheatre' ); ?>">
				<?php foreach ( $timesoftheatre_groups as $timesoftheatre_group ) : ?>
					<div class="footer-section">
						<h2 class="footer-heading"><?php echo esc_html( $timesoftheatre_group['title'] ); ?></h2>
						<ul>
							<?php foreach ( $timesoftheatre_group['items'] as $timesoftheatre_link ) : ?>
								<li><a href="<?php echo esc_url( $timesoftheatre_link['url'] ); ?>"><i class="<?php echo esc_attr( $timesoftheatre_link['icon'] ); ?> menu-icon" aria-hidden="true"></i><span><?php echo esc_html( $timesoftheatre_link['title'] ); ?></span></a></li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endforeach; ?>
			</nav>
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
