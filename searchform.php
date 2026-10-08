<?php
/**
 * The search form template.
 *
 * @package timesoftheatre
 */

$timesoftheatre_form_id = wp_unique_id( 'search-form-' );
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="<?php echo esc_attr( $timesoftheatre_form_id ); ?>">
		<span class="screen-reader-text"><?php esc_html_e( 'Search for:', 'timesoftheatre' ); ?></span>
		<input type="search" id="<?php echo esc_attr( $timesoftheatre_form_id ); ?>" class="search-field" placeholder="<?php esc_attr_e( 'Search', 'timesoftheatre' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s">
	</label>
	<button type="submit" class="search-submit">
		<i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
		<span class="screen-reader-text"><?php esc_html_e( 'Search', 'timesoftheatre' ); ?></span>
	</button>
</form>
