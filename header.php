<?php
/**
 * The header template.
 *
 * Outputs the <head>, site branding, social links and the primary
 * navigation. Closes after the navigation; footer.php closes the page.
 *
 * @package timesoftheatre
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'timesoftheatre' ); ?></a>

<header id="masthead" class="site-header">
	<div class="tot-wrap logo-section">
		<div class="logo">
			<a class="logo-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/timesoftheatre-logo.png' ); ?>" width="387" height="200" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
			</a>
		</div>

		<?php if ( has_nav_menu( 'social' ) ) : ?>
			<nav class="social-nav" aria-label="<?php esc_attr_e( 'Social links', 'timesoftheatre' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'social',
						'container'      => false,
						'menu_class'     => 'social-icons',
						'depth'          => 1,
						'fallback_cb'    => false,
						'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
					)
				);
				?>
			</nav>
		<?php endif; ?>
	</div>

	<div class="nav-section">
		<div class="tot-wrap nav-bar">
			<button type="button" class="menu-toggle" aria-controls="nav-panel" aria-expanded="false">
				<i class="fa-solid fa-bars" aria-hidden="true"></i>
				<span><?php esc_html_e( 'Menu', 'timesoftheatre' ); ?></span>
			</button>

			<div id="nav-panel" class="nav-panel">
				<nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Primary menu', 'timesoftheatre' ); ?>">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'container'      => false,
							'menu_class'     => 'primary-menu',
							'depth'          => 2,
							'fallback_cb'    => false,
							'walker'         => new Tot_Nav_Walker(),
						)
					);
					?>
				</nav>
			</div>
		</div>
	</div>
</header>
