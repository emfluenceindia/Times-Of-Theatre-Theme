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
 * Returns a URL's path with a single trailing slash, for comparisons.
 *
 * @param string $url URL.
 * @return string
 */
function timesoftheatre_url_path( $url ) {
	$path = wp_parse_url( $url, PHP_URL_PATH );

	return trailingslashit( $path ? $path : '/' );
}

/**
 * Returns the Font Awesome icon classes for a menu item.
 *
 * Icons are set per item in the menu editor's "CSS Classes" field, for
 * example "fa-solid fa-users". Items without one get a neutral arrow.
 *
 * @param WP_Post $item Menu item.
 * @return string Space-separated Font Awesome classes.
 */
function timesoftheatre_menu_item_icon( $item ) {
	$icon = array();

	foreach ( (array) $item->classes as $class_name ) {
		if ( is_string( $class_name ) && 0 === strpos( $class_name, 'fa-' ) ) {
			$icon[] = sanitize_html_class( $class_name );
		}
	}

	return $icon ? implode( ' ', $icon ) : 'fa-solid fa-angle-right';
}

/**
 * Groups a menu location's items into columns: each top-level item that has
 * sub-items becomes a column heading with its sub-items listed beneath it.
 *
 * @param string $location Registered menu location.
 * @return array[] Each: array( 'title' => string, 'items' => array of title/url ).
 */
function timesoftheatre_menu_groups( $location ) {
	$locations = get_nav_menu_locations();

	if ( empty( $locations[ $location ] ) ) {
		return array();
	}

	$items = wp_get_nav_menu_items( $locations[ $location ] );

	if ( ! $items ) {
		return array();
	}

	$groups = array();

	foreach ( $items as $item ) {
		if ( ! (int) $item->menu_item_parent ) {
			$groups[ (int) $item->ID ] = array(
				'title' => $item->title,
				'items' => array(),
			);
		}
	}

	foreach ( $items as $item ) {
		$parent = (int) $item->menu_item_parent;

		if ( $parent && isset( $groups[ $parent ] ) ) {
			$groups[ $parent ]['items'][] = array(
				'title' => $item->title,
				'url'   => $item->url,
				'icon'  => timesoftheatre_menu_item_icon( $item ),
			);
		}
	}

	return array_values(
		array_filter(
			$groups,
			static function ( $group ) {
				return ! empty( $group['items'] );
			}
		)
	);
}

/**
 * Builds the left-hand section menu for the current page.
 *
 * The menu is derived from the primary menu: the current page is matched to
 * the sub-items of one top-level item, and all sub-items of that top-level
 * item (the "siblings") are listed. Items that point to sections of the
 * current page keep their #anchor; items that point to other pages are plain
 * links, with the current page marked.
 *
 * @return array Empty when the page is not in a primary-menu sub-menu, else
 *               array( 'title' => string, 'items' => array of title/url/current ).
 */
function timesoftheatre_section_menu() {
	$locations = get_nav_menu_locations();

	if ( empty( $locations['primary'] ) || ! is_page() ) {
		return array();
	}

	$items = wp_get_nav_menu_items( $locations['primary'] );

	if ( ! $items ) {
		return array();
	}

	$current   = timesoftheatre_url_path( get_permalink( get_queried_object_id() ) );
	$parent_id = 0;

	foreach ( $items as $item ) {
		if ( (int) $item->menu_item_parent && timesoftheatre_url_path( $item->url ) === $current ) {
			$parent_id = (int) $item->menu_item_parent;
			break;
		}
	}

	if ( ! $parent_id ) {
		return array();
	}

	$menu = array(
		'title' => '',
		'items' => array(),
	);

	foreach ( $items as $item ) {
		if ( (int) $item->ID === $parent_id ) {
			$menu['title'] = $item->title;
		}

		if ( (int) $item->menu_item_parent !== $parent_id ) {
			continue;
		}

		$has_fragment = (bool) wp_parse_url( $item->url, PHP_URL_FRAGMENT );

		$menu['items'][] = array(
			'title'   => $item->title,
			'url'     => $item->url,
			'icon'    => timesoftheatre_menu_item_icon( $item ),
			'current' => ! $has_fragment && timesoftheatre_url_path( $item->url ) === $current,
		);
	}

	return $menu['items'] ? $menu : array();
}

/**
 * Prefixes a content section's heading with the icon of the section-menu
 * item that links to it, so the heading and the left-hand menu match.
 *
 * Applies to Group blocks with an anchor (HTML anchor "facilities" matches a
 * menu item linking to "this-page/#facilities"); only the first h2 in the
 * group gets the icon.
 *
 * @param string $block_content Rendered block.
 * @param array  $block         Parsed block.
 * @return string
 */
function timesoftheatre_section_heading_icon( $block_content, $block ) {
	static $icons = null;

	if ( 'core/group' !== $block['blockName'] || empty( $block['attrs']['anchor'] ) || ! is_page() || ! in_the_loop() ) {
		return $block_content;
	}

	if ( null === $icons ) {
		$icons   = array();
		$menu    = timesoftheatre_section_menu();
		$current = timesoftheatre_url_path( get_permalink( get_queried_object_id() ) );

		foreach ( $menu ? $menu['items'] : array() as $item ) {
			$fragment = wp_parse_url( $item['url'], PHP_URL_FRAGMENT );

			if ( $fragment && timesoftheatre_url_path( $item['url'] ) === $current ) {
				$icons[ $fragment ] = $item['icon'];
			}
		}
	}

	$anchor = $block['attrs']['anchor'];

	if ( empty( $icons[ $anchor ] ) ) {
		return $block_content;
	}

	$icon = '<i class="' . esc_attr( $icons[ $anchor ] ) . ' section-heading-icon" aria-hidden="true"></i>';

	return preg_replace_callback(
		'#<h2\b([^>]*)>#',
		function ( $matches ) use ( $icon ) {
			$attrs = preg_match( '#\bclass="#', $matches[1] )
				? preg_replace( '#\bclass="#', 'class="has-section-icon ', $matches[1], 1 )
				: $matches[1] . ' class="has-section-icon"';

			return '<h2' . $attrs . '>' . $icon;
		},
		$block_content,
		1
	);
}
add_filter( 'render_block', 'timesoftheatre_section_heading_icon', 10, 2 );

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
