<?php
/**
 * Template part: left-hand section menu (static column on 768px+, drawer below).
 *
 * @package timesoftheatre
 *
 * @var array $args Menu data from timesoftheatre_section_menu().
 */

if ( empty( $args['items'] ) ) {
	return;
}
?>
<button type="button" class="drawer-toggle" aria-controls="section-nav" aria-expanded="false" aria-label="<?php esc_attr_e( 'Open section menu', 'timesoftheatre' ); ?>">
	<i class="fa-solid fa-list" aria-hidden="true"></i>
</button>

<aside id="section-nav" class="section-nav" aria-label="<?php echo esc_attr( $args['title'] ); ?>">
	<button type="button" class="drawer-close" aria-label="<?php esc_attr_e( 'Close section menu', 'timesoftheatre' ); ?>">
		<i class="fa-solid fa-xmark" aria-hidden="true"></i>
	</button>

	<p class="section-nav-title"><?php echo esc_html( $args['title'] ); ?></p>

	<ul>
		<?php foreach ( $args['items'] as $timesoftheatre_item ) : ?>
			<li>
				<a href="<?php echo esc_url( $timesoftheatre_item['url'] ); ?>"<?php echo $timesoftheatre_item['current'] ? ' class="active" aria-current="page"' : ''; ?>><i class="<?php echo esc_attr( $timesoftheatre_item['icon'] ); ?> menu-icon" aria-hidden="true"></i><span><?php echo esc_html( $timesoftheatre_item['title'] ); ?></span></a>
			</li>
		<?php endforeach; ?>
	</ul>
</aside>

<div class="drawer-backdrop"></div>
