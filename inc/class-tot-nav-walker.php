<?php
/**
 * Primary navigation walker.
 *
 * Top-level items that have children never navigate: they render as a
 * <button> that only opens the sub-menu. Every other item renders as a
 * normal link. Only items without children at depth 0 (such as Home) link.
 *
 * @package timesoftheatre
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Tot_Nav_Walker.
 */
class Tot_Nav_Walker extends Walker_Nav_Menu {

	/**
	 * ID of the most recent menu item that opened a sub-menu.
	 *
	 * @var int
	 */
	private $parent_item_id = 0;

	/**
	 * Builds an HTML attribute string, skipping empty values.
	 *
	 * @param array $atts Attribute name => value pairs.
	 * @return string
	 */
	private function tot_atts( $atts ) {
		$html = '';

		foreach ( $atts as $name => $value ) {
			if ( '' === $value || null === $value || false === $value ) {
				continue;
			}

			$value = ( 'href' === $name ) ? esc_url( $value ) : esc_attr( $value );
			$html .= ' ' . $name . '="' . $value . '"';
		}

		return $html;
	}

	/**
	 * Starts a sub-menu list.
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param int      $depth  Depth of menu item.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ) {
		$id = ( 0 === $depth && $this->parent_item_id ) ? ' id="submenu-' . (int) $this->parent_item_id . '"' : '';

		$output .= '<ul class="sub-menu"' . $id . '>';
	}

	/**
	 * Ends a sub-menu list.
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param int      $depth  Depth of menu item.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function end_lvl( &$output, $depth = 0, $args = null ) {
		$output .= '</ul>';
	}

	/**
	 * Starts a menu item.
	 *
	 * @param string   $output            Used to append additional content (passed by reference).
	 * @param WP_Post  $data_object       Menu item data object.
	 * @param int      $depth             Depth of menu item.
	 * @param stdClass $args              An object of wp_nav_menu() arguments.
	 * @param int      $current_object_id Optional. ID of the current menu item.
	 */
	public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
		$menu_item = $data_object;

		$classes   = empty( $menu_item->classes ) ? array() : (array) $menu_item->classes;
		$classes[] = 'menu-item-' . $menu_item->ID;

		$args        = apply_filters( 'nav_menu_item_args', $args, $menu_item, $depth );
		$class_names = implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $menu_item, $args, $depth ) );
		$id          = apply_filters( 'nav_menu_item_id', 'menu-item-' . $menu_item->ID, $menu_item, $args, $depth );

		$output .= '<li' . $this->tot_atts(
			array(
				'id'    => $id,
				'class' => $class_names,
			)
		) . '>';

		$title = apply_filters( 'the_title', $menu_item->title, $menu_item->ID );
		$title = apply_filters( 'nav_menu_item_title', $title, $menu_item, $args, $depth );

		$is_toggle = ( 0 === $depth && $this->has_children );

		if ( $is_toggle ) {
			$this->parent_item_id = $menu_item->ID;

			$item_output  = '<button type="button" class="menu-link menu-toggle-sub"';
			$item_output .= ' aria-haspopup="true" aria-expanded="false" aria-controls="submenu-' . (int) $menu_item->ID . '">';
			$item_output .= '<span>' . $title . '</span>';
			$item_output .= '<i class="fa-solid fa-chevron-down menu-caret" aria-hidden="true"></i>';
			$item_output .= '</button>';
		} else {
			$atts = array(
				'class'        => 'menu-link',
				'href'         => ! empty( $menu_item->url ) ? $menu_item->url : '',
				'target'       => ! empty( $menu_item->target ) ? $menu_item->target : '',
				'rel'          => ! empty( $menu_item->xfn ) ? $menu_item->xfn : '',
				'aria-current' => ! empty( $menu_item->current ) ? 'page' : '',
			);

			/** This filter is documented in wp-includes/class-walker-nav-menu.php */
			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $menu_item, $args, $depth );

			$item_output  = '<a' . $this->tot_atts( $atts ) . '>';
			$item_output .= '<span>' . $title . '</span>';
			$item_output .= '</a>';
		}

		/** This filter is documented in wp-includes/class-walker-nav-menu.php */
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $menu_item, $depth, $args );
	}

	/**
	 * Ends a menu item.
	 *
	 * @param string   $output      Used to append additional content (passed by reference).
	 * @param WP_Post  $data_object Menu item data object.
	 * @param int      $depth       Depth of menu item.
	 * @param stdClass $args        An object of wp_nav_menu() arguments.
	 */
	public function end_el( &$output, $data_object, $depth = 0, $args = null ) {
		$output .= '</li>';
	}
}
