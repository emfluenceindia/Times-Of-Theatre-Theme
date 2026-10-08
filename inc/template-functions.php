<?php
/**
 * Template helper functions.
 *
 * @package timesoftheatre
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns the permalink of a page by its path, or an empty string.
 *
 * Used for homepage links so a missing page never produces a broken link.
 *
 * @param string $path Page path, for example "tot-school-of-drama/about-the-school".
 * @return string Escaped-safe URL, or '' when the page does not exist.
 */
function timesoftheatre_page_url( $path ) {
	$page = get_page_by_path( $path );

	if ( ! $page || 'publish' !== $page->post_status ) {
		return '';
	}

	return (string) get_permalink( $page );
}

/**
 * Returns the Font Awesome class for a social link URL.
 *
 * @param string $url Link URL.
 * @return string Font Awesome class string.
 */
function timesoftheatre_social_icon( $url ) {
	$map = array(
		'facebook.com'  => 'fa-brands fa-facebook-f',
		'instagram.com' => 'fa-brands fa-instagram',
		'youtube.com'   => 'fa-brands fa-youtube',
		'youtu.be'      => 'fa-brands fa-youtube',
		'twitter.com'   => 'fa-brands fa-x-twitter',
		'x.com'         => 'fa-brands fa-x-twitter',
		'linkedin.com'  => 'fa-brands fa-linkedin-in',
		'spotify.com'   => 'fa-brands fa-spotify',
		'whatsapp.com'  => 'fa-brands fa-whatsapp',
		'wa.me'         => 'fa-brands fa-whatsapp',
		'telegram.me'   => 'fa-brands fa-telegram',
		't.me'          => 'fa-brands fa-telegram',
	);

	if ( 0 === strpos( $url, 'mailto:' ) ) {
		return 'fa-solid fa-envelope';
	}

	$host = wp_parse_url( $url, PHP_URL_HOST );
	$host = $host ? preg_replace( '/^www\./', '', strtolower( $host ) ) : '';

	foreach ( $map as $domain => $icon ) {
		if ( $host === $domain || ( '' !== $host && substr( $host, -strlen( '.' . $domain ) ) === '.' . $domain ) ) {
			return $icon;
		}
	}

	return 'fa-solid fa-link';
}

/**
 * Renders social menu items as icon links.
 *
 * @param string   $item_output The menu item's starting HTML output.
 * @param WP_Post  $menu_item   Menu item data object.
 * @param int      $depth       Depth of menu item.
 * @param stdClass $args        An object of wp_nav_menu() arguments.
 * @return string
 */
function timesoftheatre_social_menu_item( $item_output, $menu_item, $depth, $args ) {
	if ( empty( $args->theme_location ) || 'social' !== $args->theme_location ) {
		return $item_output;
	}

	return sprintf(
		'<a href="%1$s"%2$s><i class="%3$s" aria-hidden="true"></i><span class="screen-reader-text">%4$s</span></a>',
		esc_url( $menu_item->url ),
		' target="_blank" rel="noopener noreferrer"',
		esc_attr( timesoftheatre_social_icon( $menu_item->url ) ),
		esc_html( $menu_item->title )
	);
}
add_filter( 'walker_nav_menu_start_el', 'timesoftheatre_social_menu_item', 10, 4 );
