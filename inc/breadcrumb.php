<?php
/**
 * Breadcrumb trail.
 *
 * Pages follow the page hierarchy (Home > Parent > Page). A parent page with
 * no content of its own (a pure grouping page such as "Workshops") is shown
 * as plain text rather than a link to an empty page.
 *
 * @package timesoftheatre
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns the breadcrumb trail for the current view.
 *
 * @return array[] Each: array( 'title' => string, 'url' => string ), where
 *                 'url' is '' for crumbs that are not links. The last crumb
 *                 is the current view. Empty on the front page.
 */
function timesoftheatre_breadcrumb_items() {
	if ( is_front_page() ) {
		return array();
	}

	$items = array(
		array(
			'title' => __( 'Home', 'timesoftheatre' ),
			'url'   => home_url( '/' ),
		),
	);

	if ( is_page() ) {
		$page_id = get_queried_object_id();

		foreach ( array_reverse( get_post_ancestors( $page_id ) ) as $ancestor_id ) {
			$has_content = '' !== trim( wp_strip_all_tags( get_post_field( 'post_content', $ancestor_id ) ) );

			$items[] = array(
				'title' => get_the_title( $ancestor_id ),
				'url'   => $has_content ? get_permalink( $ancestor_id ) : '',
			);
		}

		$items[] = array(
			'title' => get_the_title( $page_id ),
			'url'   => get_permalink( $page_id ),
		);
	} elseif ( is_singular() ) {
		$post_id    = get_queried_object_id();
		$categories = 'post' === get_post_type( $post_id ) ? get_the_category( $post_id ) : array();

		if ( $categories ) {
			$items[] = array(
				'title' => $categories[0]->name,
				'url'   => get_category_link( $categories[0] ),
			);
		}

		$items[] = array(
			'title' => get_the_title( $post_id ),
			'url'   => get_permalink( $post_id ),
		);
	} elseif ( is_search() ) {
		$items[] = array(
			/* translators: %s: search query. */
			'title' => sprintf( __( 'Search results for "%s"', 'timesoftheatre' ), get_search_query( false ) ),
			'url'   => '',
		);
	} elseif ( is_404() ) {
		$items[] = array(
			'title' => __( 'Page not found', 'timesoftheatre' ),
			'url'   => '',
		);
	} elseif ( is_category() || is_tag() || is_tax() ) {
		$items[] = array(
			'title' => single_term_title( '', false ),
			'url'   => '',
		);
	} elseif ( is_home() ) {
		$items[] = array(
			'title' => single_post_title( '', false ),
			'url'   => '',
		);
	} elseif ( is_archive() ) {
		$items[] = array(
			'title' => wp_strip_all_tags( get_the_archive_title() ),
			'url'   => '',
		);
	}

	return count( $items ) > 1 ? $items : array();
}

/**
 * Prints the breadcrumb trail, plus BreadcrumbList structured data for the
 * crumbs that have a URL.
 */
function timesoftheatre_breadcrumb() {
	$items = timesoftheatre_breadcrumb_items();

	if ( ! $items ) {
		return;
	}

	$last   = count( $items ) - 1;
	$schema = array();
	?>
	<nav class="breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'timesoftheatre' ); ?>">
		<ol>
			<?php
			foreach ( $items as $index => $item ) :
				if ( $item['url'] ) {
					$schema[] = array(
						'@type'    => 'ListItem',
						'position' => count( $schema ) + 1,
						'name'     => html_entity_decode( wp_strip_all_tags( $item['title'] ), ENT_QUOTES, 'UTF-8' ),
						'item'     => $item['url'],
					);
				}
				?>
				<li>
					<?php if ( $index === $last ) : ?>
						<span aria-current="page"><?php echo esc_html( $item['title'] ); ?></span>
					<?php elseif ( $item['url'] ) : ?>
						<a href="<?php echo esc_url( $item['url'] ); ?>">
							<?php if ( 0 === $index ) : ?>
								<i class="fa-solid fa-house" aria-hidden="true"></i>
							<?php endif; ?>
							<?php echo esc_html( $item['title'] ); ?>
						</a>
					<?php else : ?>
						<span><?php echo esc_html( $item['title'] ); ?></span>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ol>
	</nav>
	<?php
	if ( count( $schema ) > 1 ) {
		printf(
			'<script type="application/ld+json">%s</script>',
			wp_json_encode(
				array(
					'@context'        => 'https://schema.org',
					'@type'           => 'BreadcrumbList',
					'itemListElement' => $schema,
				),
				JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG
			)
		);
	}
}
